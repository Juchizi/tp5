<?php

namespace app\admin\model;

use think\Model;

class Role extends Model
{
   //设置数据库全名
   protected $table = 'roles';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';

   //用户组与权限多对多关系
   public function permissions()
   {
      return $this->belongsToMany('Permission', 'permission_role', 'permission_id', 'role_id');
   }

   //用户组有多个用户
   public function admins()
   {
      return $this->belongsToMany('Admin','role_admin','admin_id','role_id');
   }

}
