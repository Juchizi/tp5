<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Permission;
use app\admin\model\Track;
use think\App;
use think\Controller;
use think\Db;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\View;

class Common extends Controller
{
   public function __construct(App $app = null)
   {
      parent::__construct($app);
      $this->check_login();

      $this->menus();
      $this->counts();
      $department = array(); //部门列表
      $customers  = array(); //用户列表
      $department_list = DB::table('department')->select();
      foreach ($department_list as $item) {
          $department[$item['id']] = [
              'id'      => $item['id'],
              'name'    => $item['name'],
          ];
      }

       $department_list = DB::table('customers')->select();
       foreach ($department_list as $item) {
           $customers[$item['id']] = [
               'id'      => $item['id'],
               'name'    => $item['name'],
           ];
       }

       View::share(compact('department','customers'));
   }

   /**
    * 检查用户是否登录
    */
   public function check_login()
   {
      //如果cookie不存在，跳会登录页面
      if (!Cookie::has('token')) {
         $this->error('你未登录，请登录后访问', url('Logins/index'));
      }

      //如果token与数据库里面不匹配，表示用户伪造了token
      $token = Cookie::get('token');
      $admin = Admin::where('token', $token)->find();
      if (!$admin) {
         $this->error('非法登录，请重新登录', url('Logins/index'));
      }

      Session::set('admin', $admin);
   }

   /***
    * 查出当前用户的菜单
    */
   public function menus()
   {
      $admin_id = Session::get('admin.id');

      //查出当前用户的权限列表
      $role_id = Db::table('role_admin')->where('admin_id', $admin_id)->column('role_id');
      $permission_id = Db::table('permission_role')->whereIn('role_id', $role_id)->column('permission_id');

      //判断是不是超级管理员
      if ($admin_id == 1) {
         $menus = $this->all_menus();
      } else {
         //查出当前用户的菜单
         $menus = $this->get_menus($permission_id);
      }

      View::share(compact('menus'));
   }

   /***
    *  所有当前用户权限菜单
    */
   public function get_menus($permission_id)
   {
      $menus = Permission::with(['children' => function ($query) use ($permission_id) {
         $query->order('sort_order', 'desc')
            ->whereIn('id', $permission_id)
            ->order('id');
      }])
         ->where('parent_id', 0)
         ->whereIn('id', $permission_id)
         ->order('sort_order', 'desc')
         ->order('id')
         ->select();

      return $menus;
   }

   /***
    * 所有权限菜单
    */
   public function all_menus()
   {
      $menus = Permission::with(['children' => function ($query) {
         $query->order('sort_order', 'desc')->order('id');
      }])
         ->where('parent_id', 0)
         ->order('sort_order', 'desc')
         ->order('id')
         ->select();

      return $menus;
   }

   /***
    * 统计
    */
   public function counts()
   {
      $start = date('Y-m-d') . ' 00:00:00';
      $end = date('Y-m-d') . ' 23:59:59';
      $comes = '';

      View::share(compact('comes'));
   }


}