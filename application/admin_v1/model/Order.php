<?php

namespace app\admin\model;

use think\Model;

class Order extends Model
{
   //设置数据库全名
   protected $table = 'orders';


   public function customer()
   {
      return $this->belongsTo('Customer');
   }

}
