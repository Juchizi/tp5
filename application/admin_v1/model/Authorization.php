<?php

namespace app\admin\model;

use think\Model;

class Authorization extends Model
{
   //设置数据库全名
   protected $table = 'login_log';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';

    //用户信息关联
    public function customer()
    {
        return $this->belongsTo('Customer','customers_id');
    }
}
