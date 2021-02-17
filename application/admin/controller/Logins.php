<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;
use think\Request;
// use think\captcha\Captcha;

class Logins extends Controller
{
   /**
    * 显示资源列表
    *
    * @return \think\Response
    */
   public function index()
   {
      return view('Logins/index');
   }


   /***
    * 用户登录
    */
   public function login(Request $request)
   {
      $data['name'] = $request->param('name');
      $data['password'] = set_password($request->param('password'));
      $data['status'] = 1;
      $remember = $request->param('remember');

      $token = make_token();
      Admin::where($data)->setField('token', $token);

      // // 检测输入的验证码是否正确
      // $captcha = new Captcha();
      // if (!$captcha->check($request->param('captcha'))) {
      //    return redirect('Logins/index')->with('error', '验证码不正确！');
      // }
      //判断用户名和密码是否正确
      $admin = Admin::where($data)->find();
      if (!$admin) {
         return redirect('Logins/index')->with('error', '用户名或密码不正确！');
      }

      //更新登录时间
      $admin->save(['login_at' => date('Y-m-d H:i:s')]);

      //是否记住密码
      if ($remember) {
         Cookie::set('token', $admin['token'], time() + 60 * 60 * 24 * 7, '/');
      } else {
         Cookie::set('token', $admin['token'], null, '/');
      }

      return redirect('/admin')->with('success', '登录成功');
   }


   /**
    * 退出登录
    */
   public function logout()
   {
      Cookie::delete('token');
      Session::delete('admin');
      return redirect('Admins/index')->with('success', '退出成功');
   }
}
