<?php

namespace app\admin\model;

use think\facade\Cache;
use think\Model;

class Permission extends Model
{
   //设置数据库全名
   protected $table = 'permissions';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';

   //权限与用户组多对多关系
   public function roles()
   {
      return $this->belongsToMany('Role', 'permission_role', 'role_id', 'permission_id');
   }

   //查出一级分类下的所有分类
   public function children()
   {
      return $this->hasMany('Permission', 'parent_id', 'id');
   }

   //清楚缓存
   static function clear()
   {
      Cache::rm('system_permissions');
   }

   //查出所有权限
   static function get_permissions()
   {
      $permissions = Cache::remember('system_permissions', function () {
         return self::with(['children' => function ($query) {
            $query->order('sort_order', 'desc')->order('id');
            $query->with(['children' => function ($query) {
               $query->order('sort_order', 'desc')->order('id');
            }]);
         }])
            ->where('parent_id', 0)->order('sort_order', 'desc')->order('id')->select();
      });

      return $permissions;
   }

   //检查是否有子栏目
   static function check_children($id)
   {
      $permission = self::with('children')->find($id);
      if ($permission->children->isEmpty()) {
         return true;
      }
      return false;
   }


}
