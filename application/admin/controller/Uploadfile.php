<?php

namespace app\admin\controller;

use think\Controller;
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use app\admin\model\Photo;
use think\facade\Request;

/**
 * 上传控制器
 * @author hdj
 */
class Uploadfile extends Controller
{
   /**
    * 上传
    */
   public function upload()
   {
      // 获取表单上传文件 例如上传了001.jpg
      $file = request()->file('image');
      // 移动到框架应用根目录/uploads/ 目录下
      $info = $file->move('./uploads');

      //拼接本地上传的完整路径
      $filePath = getcwd() . '/uploads/' . $info->getSaveName();

//      //调用七牛sdk执行上传七牛
//      qiniu_upload($filePath);
//      //前端显示图片地址
//      $result['msg'] = 'http://xxx/' . $info->getFilename();

      //上传到本地
      $result['msg'] = Request::root(true).'/uploads/' . $info->getSaveName();

      //将图片直接存入photo数据库
      $photo = Photo::create(['image' => $result['msg']]);
      $result['photo_id'] = $photo->id;
      $result['status'] = 1;

//        dump($photo_id);exit;
      return json($result);
   }

   //文件上传
    public function store($obj, $rule = [])
    {
        if(!is_array($obj))
        {
            $obj = [$obj];
        }
        if(empty($rule))
        {
            $rule = [
                'size' => 10000000,
                'ext' => 'jpg,png,jpeg,gif,mp4,flv,3gp,txt,xls,xlsx,ppt,pdf,doc,xls,zip'
            ];
        }

        $paths = [];
        foreach($obj as $file)
        {
            $info = $file->validate($rule)->rule('uniqid')->move( './uploads/images');
            if(!$info)
            {
                return $file->getError();
            }

            $saveName =  $info->getSaveName();
            $paths[] = $saveName;
        }
        return $paths;
    }
}