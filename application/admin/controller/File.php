<?php

namespace app\admin\controller;

use app\admin\model\Customer;
use think\Controller;
use think\Db;
use think\facade\Session;
use think\Request;
use app\admin\model\File as FileModel;
//文件上传管理
class File extends Common
{
   protected $middleware = ['Auth'];

   /**
    * 显示资源列表
    * @return \think\Response
    */
   public function index(Request $request)
   {
      //模糊查询
      $where = [];
      $result = \config('admin.customers');
      //按名称
      if ($search = input('get.name')) {
         $where[] = ['admin', 'like', "%" . $search . "%"];
      }
      //按时间查询
      if ($request->has('date') and $request->param('date') != '') {
         $time = explode(" ~ ", $request->param('date'));
         $start = $time[0] . ' 00:00:00';
         $end = $time[1] . ' 23:59:59';
         $where[] = ['create_at', 'between time', [$start, $end]];
      }

         $file = FileModel::
            where($where)
            ->order('create_at', 'desc')
            ->paginate(10, false, ['query' => request()->param()]);


      return view('File/index',['file' => $file]);
  }
   /**
    * 显示创建资源表单页.
    *
    * @return \think\Response
    */
   public function create()
   {
      return view('File/create');
   }

   /**
    * 保存新建的资源
    *
    * @param  \think\Request $request
    * @return \think\Response
    */
   public function save(Request $request, Uploadfile $Uploadfile)
   {
       $data = $request->param(true);
       $url = $request->file('url');

           if(!empty($url))
           {
               $res = $Uploadfile->store($url);
               if(!is_array($res))
               {
                   return redirect('File/index')->with('error', '操作失败');
               }
               foreach ($res as $key => $value) {
                   $file_data['url'] = $value;
               }

           }
       $imag = './uploads/images/'.$file_data['url'];
       $size = filesize($imag);

       $file_data['size'] = $this->getSize($size);
       $file_data['create_at'] = date('Y-m-d H:i:s');
       $file_data['type']      = substr(strrchr($file_data['url'], '.'), 1);
       $file_data['admin']  = session::get('admin.name');
          $file = FileModel::create($file_data);

          //写入customer_logs表日志
          $id = $file['id'];
          $content = session::get('admin.name') . '上传文件' . $file['id'];
          $this->log($id, $content);


      return redirect('File/index')->with('success', '操作成功');
   }

  public function getSize($filesize) {

        if($filesize >= 1073741824) {

        $filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';

        } elseif($filesize >= 1048576) {

              $filesize = round($filesize / 1048576 * 100) / 100 . ' MB';

        } elseif($filesize >= 1024) {

              $filesize = round($filesize / 1024 * 100) / 100 . ' KB';

        } else {

                $filesize = $filesize . ' 字节';

        }

        return $filesize;

    }

   /***
    * 多选删除
    */
   public function delete_all(Request $request)
   {
       FileModel::destroy($request->param('check_id'));

      //写入customer_logs表日志
      $content = session::get('admin.name') . '删除了文件' . implode(',', $request->param('check_id'));
      $this->log($id = '', $content);
   }

   /****
    * 写入日志表
    */
   public function log($id, $content)
   {
      $log['customer_id'] = $id;
      $log['name'] = session::get('admin.name');
      $log['log'] = $content;
      $log['create_at'] = date('Y-m-d H:i:s');
      Db::table('customer_logs')->insert($log);
   }


//   /***
//    * 导出
//    */
//   public function export_customer()
//   {
//
//      $customers = \config('admin.customers');
//      $name = '人员列表';
//      $data = Db::table('customers')->order('id', 'desc')->select();
//      foreach ($data as &$item) {
//         $item['sex'] = $item['area_id'] ? '男' : '女';  //性别
//
//      }
//
//      export($customers, $data, $name);
//   }


}
