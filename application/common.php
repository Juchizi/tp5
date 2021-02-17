<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
//导出excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// 应用公共文件
//密码截取
function set_password($password)
{
   return substr(md5($password), 3, -3);
}

//生成token，用于发邮件
function make_token()
{
   return date('YmdHis') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

//改变属性
function is_something($model, $attr)
{
   if (isset($model[$attr]) && $model[$attr] == 1) {
      return "<i class='fa fa-check-circle change_attr' data-attr='" . $attr . "'></i>";
   }
   return "<i class='fa fa-times-circle change_attr' data-attr='" . $attr . "'></i>";
}

//权限管理--用户管理,判断数组中的元素是否存在于该数组中，存在则取出
function pluck($array, $key)
{
   $result = [];
   foreach ($array as $k => $v) {
      if (!array_key_exists($key, $v)) {
         return;
      }
      $result[] = $v[$key];
   }
   return $result;
}


// 七牛上传图片
function qiniu_upload($filePath)
{
   // 需要填写你的 Access Key 和 Secret Key
   $accessKey = "";
   $secretKey = "";
   $bucket = "";
   // 构建鉴权对象
   $auth = new Auth($accessKey, $secretKey);
   // 生成上传 Token
   $token = $auth->uploadToken($bucket);

   // 上传到七牛后保存的文件名
   $key = basename($filePath);
   // 初始化 UploadManager 对象并进行文件的上传。
   $uploadMgr = new UploadManager();
   // 调用 UploadManager 的 putFile 方法进行文件的上传。
   list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//        unlink($filePath);
}

//删除七牛云图片
function qiNiuDeleteImg($img)
{
//   $img = 'http://xxx/0rLNa4wcPhJiC0XPo5pRZS2f633vn7p3CptaA4DA.jpeg';

   $accessKey = '';
   $secretKey = '';
   $bucket = '';
   $fileName = substr($img, 23);   //截取图片名称

   // 判断是否是图片
   $isImage = preg_match('/.*(\.png|\.jpg|\.jpeg|\.gif)$/', $fileName);
   if (!$isImage) {
      return false;
   }
   // 构建鉴权对象
   $auth = new Auth($accessKey, $secretKey);
   // 配置
   $config = new \Qiniu\Config();

   // 管理资源
   $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
   // 删除文件操作
   $bucketManager->delete($bucket, $fileName);
}

//删除七牛云多张图片
function qiNiuDeleteAll($imgs)
{
//   $imgs = [];  //多图数组
   $accessKey = '';
   $secretKey = '';
   $bucket = '';
   // 构建鉴权对象
   $auth = new Auth($accessKey, $secretKey);
   // 配置
   $config = new \Qiniu\Config();
   // 管理资源
   $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
   // 删除文件操作
   foreach ($imgs as $img) {
      $fileName = substr($img, 23);   //截取图片名称
      $bucketManager->delete($bucket, $fileName);
   }
}

//导出Excel
function exportExcel($spreadsheet, $format = 'xls', $savename = 'export')
{
   if (!$spreadsheet) return false;
   if ($format == 'xls') {
      //输出Excel03版本
      header('Content-Type:application/vnd.ms-excel');
      $class = "\PhpOffice\PhpSpreadsheet\Writer\Xls";
   } elseif ($format == 'xlsx') {
      //输出07Excel版本
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      $class = "\PhpOffice\PhpSpreadsheet\Writer\Xlsx";
   }
   //输出名称
   header('Content-Disposition: attachment;filename="' . $savename . '.' . $format . '"');
   //禁止缓存
   header('Cache-Control: max-age=0');
   $writer = new $class($spreadsheet);
   $filePath = env('runtime_path') . "temp/" . time() . microtime(true) . ".tmp";
   $writer->save($filePath);
   readfile($filePath);
   unlink($filePath);
}

//封装导出方法,$param->数据库字段及对应的名称，$data->数据库数据，$name->导出表名
function export($param, $data, $name)
{
   $spreadsheet = new Spreadsheet();
   $arr = range('A', 'Z');  //A-Z的数组
   $new = array_slice($arr, 0, count($param));  //数组截取
   $res = array_combine($new, $param);  //将两个数组组成key=>$v形式
   foreach ($res as $k => $v) {
      $key = array_search($v, $param);  //取数组key,数据表的字段名
      //标题
      $spreadsheet->setActiveSheetIndex(0)
         ->setCellValue($k . '1', $v);
      //内容
      $i = 2;
      foreach ($data as $rs) {
         $spreadsheet->getActiveSheet()
            ->setCellValue($k . $i, ' ' . $rs[$key]);
         $i++;
      }

      //设置表格的宽度
      $spreadsheet->getActiveSheet()
         ->getColumnDimension($k)
         ->setWidth(15);
   }

   $spreadsheet->getActiveSheet()->getStyle('A1:F' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
   $spreadsheet->getActiveSheet()->getStyle('C2:C' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
   $spreadsheet->setActiveSheetIndex(0);
   ob_end_clean();   //处理乱码
   return exportExcel($spreadsheet, 'xls', $name);
}

//封装导出方法,$param->数据库字段及对应的名称，$data->数据库数据，$name->导出表名
function exports($param, $data, $name,$count)
{
    $spreadsheet = new Spreadsheet();
    $arr = range('A', 'Z');  //A-Z的数组
    $new = array_slice($arr, 0, count($param));  //数组截取
    $res = array_combine($new, $param);  //将两个数组组成key=>$v形式
    foreach ($res as $k => $v) {
        $key = array_search($v, $param);  //取数组key,数据表的字段名
        //标题
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue($k . '1', $v);
        //内容
        $i = 2;
        foreach ($data as $rs) {
            $spreadsheet->getActiveSheet()
                ->setCellValue($k . $i, ' ' . $rs[$key]);
            $i++;
        }

        //设置表格的宽度
        $spreadsheet->getActiveSheet()
            ->getColumnDimension($k)
            ->setWidth(15);
    }
    $spreadsheet->getActiveSheet()
        ->setCellValue($k . $i, '总计： ' . $count);
    $spreadsheet->getActiveSheet()->getStyle('A1:F' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('C2:C' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    $spreadsheet->setActiveSheetIndex(0);
    ob_end_clean();   //处理乱码
    return exportExcel($spreadsheet, 'xls', $name);
}

//盐值加密
function passCrypt($psw)
{
    //取随机10位字符串
    $strs="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
    $str =substr(str_shuffle($strs),mt_rand(0,strlen($strs)-11),10);
    $psw =md5((md5($psw).$str));

    $data['salt'] = $str;
    $data['psw']  = $psw;
    return $data;
}

function https_request($url, $data = null)
{
    $curl = curl_init();//初始化
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);//允许 cURL 函数执行的最长秒数。
    /*if (!empty($port)) {
        curl_setopt($curl, CURLOPT_PORT, $port);//可选的用来指定连接端口，默认80端口可不写
    }*/
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json;charset=UTF-8'));//设置请求目标url头部信息
    if (!empty($data)) {
        //$data不为空，发送post请求
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); //$data：数组
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);//执行命令
    $error = curl_error($curl);//错误信息
    if ($error || $output == FALSE) {
        //报错信息
        return 'ERROR ' . curl_error($curl);
    }
    curl_close($curl);
    return $output;
}

