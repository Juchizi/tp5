<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
   //设置数据库全名
   protected $table = 'admins';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';

   //一个用户有多个用户组
   public function roles()
   {
      return $this->belongsToMany('Role','role_admin','role_id','admin_id');
   }


}
