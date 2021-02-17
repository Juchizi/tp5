<?php

namespace app\admin\model;

use think\Model;

class Customer extends Model
{
   //设置数据库全名
   protected $table = 'customers';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';

    public function departments()
    {
        return $this->belongsTo('department','department');
    }

    public function company()
    {
       return $this->belongsTo('company','department','department_id');
    }
}
