<?php

namespace app\http\middleware;

use think\Db;
use think\facade\Session;
use traits\controller\Jump;

class Auth
{
   use Jump;

   public function handle($request, \Closure $next)
   {
      $admin_id = Session::get('admin.id');

      //超级管理员自动所有权限
      if ($admin_id == 1) {
         return $next($request);
      }

      //查出当前用户的权限列表
      $role_id = Db::table('role_admin')->where('admin_id', $admin_id)->column('role_id');
      $permission_id = Db::table('permission_role')->whereIn('role_id', $role_id)->column('permission_id');
      //查出当前用户的路由
      $labels = Db::table('permissions')->whereIn('id', $permission_id)->column('label');

      $module = request()->module();//模块名
      $controller = strtolower(request()->controller());//控制器名
      $action = request()->action();//方法名
      $url = $module . '/' . $controller . '/' . $action;

      if (!in_array('/' . $url, $labels)) {
         if ($request->isAjax() && ($request->method() != 'GET')) {

            return json([
               'status' => 0,
               'code' => 403,
               'msg' => '您没有权限执行此操作~',
            ]);
         } else {
            return $this->error('没有权限操作');
         }
      }

      return $next($request);
   }

}
