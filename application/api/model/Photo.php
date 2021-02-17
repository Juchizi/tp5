<?php

namespace app\admin\model;

use think\Model;

class Photo extends Model
{
   //设置数据库全名
   protected $table = 'photos';

   protected $autoWriteTimestamp = 'datetime';

   // 定义时间戳字段名
   protected $createTime = 'create_at';
   protected $updateTime = 'update_at';


}
