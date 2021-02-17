<?php

namespace app\admin\validate;

use think\Validate;

class AdminCreate extends Validate
{
   /**
    * 定义验证规则
    * 格式：'字段名'   =>   ['规则1','规则2'...]
    *
    * @var array
    */
   protected $rule = [
      'name|用户名' => 'require|unique:admin|max:30',
      'email|邮箱' => 'require|email',
      'phone|手机号' => 'require|number|length:11|mobile',
      'password|密码' => 'require|confirm',
      'role_id|用户组' => 'require',
   ];

   /**
    * 定义错误信息
    * 格式：'字段名.规则名'   =>   '错误信息'
    *
    * @var array
    */
   protected $message = [
      'name.require' => '用户名必须',
      'name.max' => '用户名最多不能超过30个字符',
      'email' => '邮箱格式错误',
   ];
}
