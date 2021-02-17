<?php

namespace app\admin\model;

use think\Model;

class Category extends Model
{
   //设置数据库全名
   protected $table = 'categories';

   // 开启自动写入时间戳字段
   protected $autoWriteTimestamp = 'datetime';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';

   //分类属于相册
   public function photo()
   {
      return $this->belongsTo('Photo', 'photo_id');
   }

   //一级分类下有很多二级分类
   public function children()
   {
      return $this->hasMany('Category', 'parent_id', 'id');
   }

   //一级分类
   public function parent()
   {
      return $this->belongsTo('Category', 'parent_id');
   }

   //查出一级分类对应下的二级分类(静态方法)
   static function all_categories()
   {
      $categories = self::with(['photo', 'children' => function ($query) {
         $query->order('sort_order', 'desc');
      }])
         ->where("parent_id", '0')
         ->order('sort_order', 'desc')
         ->select();

      return $categories;
   }

}