<?php

namespace app\admin\model;

use think\Model;
//申请记录表
class Vehicle extends Model
{
   //设置数据库全名
   protected $table = 'apply_record';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';

    //用户信息关联
    public function customer()
    {
        return $this->belongsTo('Customer','customers_id');
    }
}
