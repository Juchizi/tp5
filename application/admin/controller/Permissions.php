<?php

namespace app\admin\controller;

use app\admin\model\Permission;
use think\App;
use think\Controller;
use think\facade\View;
use think\Request;

class Permissions extends Common
{
   protected $middleware = ['Auth'];

   public function __construct(App $app = null)
   {
      parent::__construct($app);
      $permissions = Permission::get_permissions();
      View::share(compact('permissions'));
   }

   /**
    * 显示资源列表
    *
    * @return \think\Response
    */
   public function index()
   {
      return $this->fetch();
   }

   /**
    * 显示创建资源表单页.
    *
    * @return \think\Response
    */
   public function create()
   {
      return view('Permissions/create');
   }

   /**
    * 保存新建的资源
    *
    * @param  \think\Request $request
    * @return \think\Response
    */
   public function save(Request $request)
   {
      $data = $request->param();
//      if ($request->param('parent_id') != 0 && !\Request::route($request->param('label'))) {
//         return redirect('Permissions/create')->with('error', '菜单路由地址不存在~');
//      }

      $data['create_at'] = date('Y-m-d H:i:s');

      $validate = new \app\admin\validate\PermissionCreate;
      if (!$validate->check($data)) {
         return redirect('Permissions/create')->with('error', $validate->getError());
      }

      Permission::create($data);
      Permission::clear();
      return redirect('Permissions/index')->with('success', '新增菜单成功');
   }

   /**
    * 显示编辑资源表单页.
    *
    * @param  int $id
    * @return \think\Response
    */
   public function edit($id)
   {
      $perm = Permission::find($id);
      return view('Permissions/edit', compact('perm'));
   }

   /**
    * 保存更新的资源
    *
    * @param  \think\Request $request
    * @param  int $id
    * @return \think\Response
    */
   public function update(Request $request, $id)
   {
      $permission = Permission::find($id);
      $permission->save($request->param());
      Permission::clear();
      return redirect('Permissions/index')->with('success', '编辑菜单成功');
   }

   /**
    * 删除指定资源
    *
    * @param  int $id
    * @return \think\Response
    */
   public function delete($id)
   {
      if (!Permission::check_children($id)) {
         return json(['status' => 0, 'msg' => '当前菜单有子菜单，请先将子菜单删除后再尝试删除~']);
      }

      Permission::destroy($id);
      Permission::clear();
      return json(['status' => 1, 'msg' => '删除菜单成功~']);
   }

   /**
    * 排序
    */
   public function sort(Request $request)
   {
      $permission = Permission::find($request->param('id'));
      $permission->sort_order = $request->param('sort');
      $permission->save();
      Permission::clear();
   }

}


