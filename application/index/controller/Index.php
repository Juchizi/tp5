<?php

namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
   /***
    * @return int|\think\response\View
    * 首页
    */
   public function index()
   {
//      return view('/index');

//      $dir = './index/article/index/id/';
//      $dir = './index/article/lovedetail/id/';
//      if (!is_dir($dir)) {   //如果目录不存在
//         mkdir(iconv("GBK", "UTF-8", $dir), 0777, true);  //创建目录(777权限)
//      }
//      $url = '35893';
//      ob_start();// 打开输出缓存
//      $content = file_get_contents('http://jd.coolsphoto.com/' . $dir . $url);
//      echo $content;// 输出内容，此部分的内容为静态页的内容
//      file_put_contents($dir . $url . '.html', ob_get_contents());
//      ob_end_clean();// 关闭
//      echo $content;

      echo $this->fetch('/index');
      file_put_contents('./index.html', ob_get_clean());
   }


}
