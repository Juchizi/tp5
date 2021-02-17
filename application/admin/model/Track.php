<?php

namespace app\admin\model;

use think\Model;

class Track extends Model
{
   //设置数据库全名
   protected $table = 'tracks';


   //客资追踪属于客资
   public function customer()
   {
      return $this->belongsTo('Customer','customer_id');
   }


}
