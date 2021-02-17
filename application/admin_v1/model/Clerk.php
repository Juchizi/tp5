<?php

namespace app\admin\model;

use think\Model;

class Clerk extends Model
{
   //设置数据库全名
   protected $table = 'clerks';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';
}
