<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Role;
use think\Db;
use think\facade\View;
use think\Request;

class Admins extends Common
{
   protected $middleware = ['Auth'];

   public function __construct()
   {
      parent::__construct();
      $roles = Role::all();
      View::share(compact('roles'));
   }

   /**
    * 显示资源列表
    *
    * @return \think\Response
    */
   public function index()
   {
      $admins = Admin::with('roles')->select()->toArray();;
      return view('Admins/index', compact('admins'));
   }

   /**
    * 显示创建资源表单页.
    *
    * @return \think\Response
    */
   public function create()
   {
      return view('Admins/create');
   }

   /**
    * 保存新建的资源
    *
    * @param  \think\Request $request
    * @return \think\Response
    */
   public function save(Request $request)
   {
      $data = [
         'name' => $request->param('name'),
         'email' => $request->param('email'),
         'phone' => $request->param('phone'),
         'password' => set_password($request->param('password')),
         'password_confirm' => set_password($request->param('password_confirm')),
         'create_at' => date('Y-m-d H:i:s', time()),
         'update_at' => date('Y-m-d H:i:s', time()),
         'role_id' => $request->param('role_id'),
      ];

      $validate = new \app\admin\validate\AdminCreate;
      if (!$validate->check($data)) {
         return redirect('Admins/create')->with('error', $validate->getError());
      }
      $admin = Admin::create($data);

      //插入中间表role_admin
      foreach ($request->param('role_id') as $id) {
         $admin->roles()->saveAll([
            'role_id' => $id
         ]);
      }

      return redirect('Admins/index')->with('success', '新增成功！');
   }

   /**
    * 显示指定的资源
    *
    * @param  int $id
    * @return \think\Response
    */
   public function read($id)
   {
      //
   }

   /**
    * 显示编辑资源表单页.
    *
    * @param  int $id
    * @return \think\Response
    */
   public function edit($id)
   {
      $admin = Admin::with('roles')->find($id);
      $admin_roles = Db::table('role_admin')->where('admin_id', $id)->column('role_id');

      return view('Admins/edit', compact('admin', 'admin_roles'));
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
      $admin = Admin::find($id);

      if ($request->has('old_password') && $request->param('old_password') != '') {
         $old_password = set_password($request->param('old_password'));
         if ($old_password != $admin->password) {
            return redirect('Admins/edit', ['id' => $id])->with('error', '原密码不正确');
         }
      }

      $data = [
         'name' => $request->param('name'),
         'email' => $request->param('email'),
         'phone' => $request->param('phone'),
         'password' => set_password($request->param('password')),
         'password_confirm' => set_password($request->param('password_confirm')),
         'update_at' => date('Y-m-d H:i:s', time()),
         'role_id' => $request->param('role_id'),
      ];

      $validate = new \app\admin\validate\AdminUpdate;
      $result = $validate->check($data);
      if (!$result) {
         return redirect('Admins/edit', ['id' => $id])->with('error', $validate->getError());
      } else {
         //更新信息
         $admin->allowField(true)->save($data);
      }

      //更新用户组
      if ($request->has('role_id') && $request->param('role_id') != '') {
         //先删除中间表数据
         Db::table('role_admin')->where('admin_id', $id)->delete();
         //保存用户组到role_admin中间表
         foreach ($request->param('role_id') as $id) {
            $admin->roles()->saveAll([
               'role_id' => $id
            ]);
         }
      }
      return redirect('Admins/index')->with('success', '更新用户成功！');
   }

   /**
    * 删除指定资源
    *
    * @param  int $id
    * @return \think\Response
    */
   public function delete($id)
   {
      Admin::destroy($id);
      //删除中间表
      Db::table('role_admin')->where('admin_id', $id)->delete();
   }


   /**
    * 改变状态---是否禁用
    */
   public function change(Request $request)
   {
      $admin = Admin::find($request->param('id'));
      $attr = $request->param('attr');
      $admin->$attr = !$admin->$attr;
      $admin->save();
   }

   /***
    * 多选删除
    */
   public function delete_all(Request $request)
   {
      $ids = $request->param('check_id');
      Admin::destroy($ids);
      //删除中间表
      Db::table('role_admin')->whereIn('admin_id', $ids)->delete();
   }


}
