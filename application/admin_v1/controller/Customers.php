<?php

namespace app\admin\controller;

use app\admin\model\Customer;
use think\Controller;
use think\Db;
use think\facade\Session;
use think\Request;
//用户模块
class Customers extends Common
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
         $where[] = ['name', 'like', "%" . $search . "%"];
      }
      //按时间查询
      if ($request->has('date') and $request->param('date') != '') {
         $time = explode(" ~ ", $request->param('date'));
         $start = $time[0] . ' 00:00:00';
         $end = $time[1] . ' 23:59:59';
         $where[] = ['create_at', 'between time', [$start, $end]];
      }

         $customers = Customer::
            where($where)
            ->order('create_at', 'desc')
            ->paginate(10, false, ['query' => request()->param()]);


      return view('Customers/index',['customers' => $customers]);
  }
   /**
    * 显示创建资源表单页.
    *
    * @return \think\Response
    */
   public function create(Request $request)
   {
       $post    =   $request->param(true);

       $info    =   array();
       $info    =   Customer::where('id',$post['id']??'')->find();
      return view('Customers/create',['info' => $info]);
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
       $portrait_url = $request->file('portrait_url');

           if(!empty($portrait_url))
           {
               $res = $Uploadfile->store($portrait_url);
               if(!is_array($res))
               {
                   return redirect('Customers/index')->with('error', '操作失败');
               }
               foreach ($res as $key => $value) {
                   $data['portrait_url'] = $value;

               }
           }

           $crypt = passCrypt($data['password']);
          $data['create_at'] = date('Y-m-d H:i:s');
          $data['password']  = $crypt['psw'];
          $data['salt']      = $crypt['salt'];
          $customer = Customer::create($data);

          //写入customer_logs表日志
          $id = $customer['id'];
          $content = session::get('admin.name') . '录入人员' . $customer['id'];
          $this->log($id, $content);


      return redirect('Customers/index')->with('success', '操作成功');
   }

   /**
    * 修改
    */
   public function edit(Request $request, Uploadfile $Uploadfile)
   {
       $data = $request->param(true);
       $data['update_at'] = date('Y-m-d H:i:s');
       $file = $request->file();
           if(!empty($file['portrait_url']))
           {
               $res = $Uploadfile->store($request->file('portrait_url'));
               if(!is_array($res))
               {
                   return redirect('Customers/index')->with('error', '操作失败');
               }
               foreach ($res as $key => $value) {
                   $data['portrait_url'] = $value;

               }
           }

           if (empty($data['password'])) {
               unset($data['password']);
           } else {
               $crypt = passCrypt($data['password']);
               $data['password']  = $crypt['psw'];
               $data['salt']      = $crypt['salt'];
           }

       unset($data['/admin/customers/edit_html']);
       Customer::where('id',$data['id'])->update($data);

       //写入customer_logs表日志
       $id = $data['id'];
       $content = session::get('admin.name') . '修改人员' . $data['id'];
       $this->log($id, $content);

       return redirect('Customers/index')->with('success', '操作成功');
   }

   /***
    * 多选删除
    */
   public function delete_all(Request $request)
   {
      Customer::destroy($request->param('check_id'));

      //写入customer_logs表日志
      $content = session::get('admin.name') . '删除了人员' . implode(',', $request->param('check_id'));
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


   /***
    * 导出
    */
   public function export_customer()
   {

      $customers = \config('admin.customers');
      $name = '人员列表';
      $data = Db::table('customers')->order('id', 'desc')->select();
      foreach ($data as &$item) {
         $item['sex'] = $item['area_id'] ? '男' : '女';  //性别

      }

      export($customers, $data, $name);
   }


}
