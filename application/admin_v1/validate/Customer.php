<?php

namespace app\admin\validate;

use think\Validate;

class Customer extends Validate
{
   /**
    * 定义验证规则
    * 格式：'字段名'   =>   ['规则1','规则2'...]
    *
    * @var array
    */
   protected $rule = [
      'name|姓名' => 'require|max:30',
      'phone|电话' => 'require|unique:customers|number|length:11|mobile',
      'qudao_id|来源' => 'require',
   ];

   /**
    * 定义错误信息
    * 格式：'字段名.规则名'   =>   '错误信息'
    *
    * @var array
    */
   protected $message = [
      'name.require' => '姓名必须',
      'name.max' => '姓名不能超过30个字符',
   ];
}
