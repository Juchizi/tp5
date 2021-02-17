<?php

namespace app\admin\controller;

use app\admin\model\Permission;
use app\admin\model\Role;
use think\App;
use think\Controller;
use think\Db;
use think\facade\View;
use think\Request;

class Roles extends Common
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
      $role_id = Db::table('role_admin')->whereIn('admin_id', session('admin.id'))->min('role_id');
      if ($role_id == 1) {
         $roles = Role::all();
      } else {
         $roles = Role::where('id', '>', $role_id)->select();
      }

      return view('Roles/index', compact('roles'));
   }

   /**
    * 显示创建资源表单页.
    *
    * @return \think\Response
    */
   public function create()
   {
      return view('Roles/create');
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
      $data['create_at'] = date('Y-m-d H:i:s');

      $role = Role::create($data);

      //保存权限到permission_role中间表
      foreach ($request->param('permission_id') as $permission_id) {
         $role->permissions()->saveAll([
            'permission_id' => $permission_id
         ]);
      }

      return redirect('Roles/index')->with('success', '新增用户组成功');
   }

   /**
    * 显示编辑资源表单页.
    *
    * @param  int $id
    * @return \think\Response
    */
   public function edit($id)
   {
      $role = Role::with('permissions')->find($id);
      $role_permissions = Db::table('permission_role')->where('role_id', $id)->column('permission_id');

      return view('Roles/edit', compact('role', 'role_permissions'));
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
      $role = Role::find($id);
      $data = [
         'name' => $request->param('name'),
         'description' => $request->param('description'),
         'update_at' => date('Y-m-d H:i:s'),
      ];
//      Role::where('id', $id)->update($data);
      $role->save($data);

      //更新权限
      if ($request->has('permission_id') && $request->param('permission_id') != '') {
         //先删除中间表数据
         Db::table('permission_role')->where('role_id', $id)->delete();
         //保存权限到permission_role中间表
         foreach ($request->param('permission_id') as $permission_id) {
            $role->permissions()->saveAll([
               'permission_id' => $permission_id
            ]);
         }
      }

      return redirect('Roles/index')->with('success', '更新用户组成功');
   }

   /**
    * 删除指定资源
    *
    * @param  int $id
    * @return \think\Response
    */
   public function delete($id)
   {
      Role::destroy($id);
      //删除中间表
      Db::table('permission_role')->where('role_id', $id)->delete();
   }

   /**
    * 改变状态
    */
   public function change(Request $request)
   {
      $role = Role::find($request->param('id'));
      $attr = $request->param('attr');
      $role->$attr = !$role->$attr;
      $role->save();
   }

   /***
    * 多选删除
    */
   public function delete_all(Request $request)
   {
      $ids = $request->param('check_id');
      Role::destroy($ids);
      //删除中间表
      Db::table('permission_role')->whereIn('role_id', $ids)->delete();
   }


}
