<?php

namespace app\admin\model;

use think\Model;

class Article extends Model
{
   //设置数据库全名
   protected $table = 'articles';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';

   //文章属于分类
   public function category()
   {
      return $this->belongsTo('Category', 'category_id');
   }

   //文章属于相册
   public function photo()
   {
      return $this->belongsTo('Photo', 'photo_id');
   }

}
