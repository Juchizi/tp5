<?php

namespace app\admin\controller;

use app\admin\model\Area;
use app\admin\model\Customer;
use app\admin\model\Authorization as AuthModel;
use think\Db;
use think\facade\Session;
use think\Request;
//授权访问统计
class Authorization extends Common
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
      //按名称
      if ($search = input('get.name')) {
          $customer =   Customer::where('name', 'like', "%" . $search . "%")->field(['id'])->select();
          $customer_id = [];
          foreach ($customer as $key => $value) {
              $customer_id [$key] = $value['id'];
          }
          $where[] = ['customers_id', 'in', implode(',',$customer_id)];
      }
      //按时间查询
      if ($request->has('date') and $request->param('date') != '') {
         $time = explode(" ~ ", $request->param('date'));
         $start = $time[0] . ' 00:00:00';
         $end = $time[1] . ' 23:59:59';
         $where[] = ['login_log.create_at', 'between time', [$start, $end]];
      }

         $auth = AuthModel::has('customer','>',1)->
            where($where)
             ->with(['customer'])
            ->order('create_at', 'desc')
            ->paginate(10, false, ['query' => request()->param()]);

      return view('Authorization/index',['auth' => $auth]);
  }

   /***
    * 导出
    */
   public function export_customer(Request $request)
   {

      $customers = \config('admin.auth');

      $name = '授权访问列表';
       //模糊查询
       $where = [];
       //按名称
       if ($search = input('get.name')) {
           $customer =   Customer::where('name', 'like', "%" . $search . "%")->field(['id'])->select();
           $customer_id = [];
           foreach ($customer as $key => $value) {
               $customer_id [$key] = $value['id'];
           }
           $where[] = ['customers_id', 'in', implode(',',$customer_id)];
       }
       //按时间查询
       if ($request->has('date') and $request->param('date') != '') {
           $time = explode(" ~ ", $request->param('date'));
           $start = $time[0] . ' 00:00:00';
           $end = $time[1] . ' 23:59:59';
           $where[] = ['login_log.create_at', 'between time', [$start, $end]];
       }

       $data = AuthModel::has('customer','>',1)->
       where($where)
           ->with(['customer'])
           ->order('create_at', 'desc')
           ->select();
       foreach ($data as $item) {
         $item['sex'] = $item->customer->sex ? '男' : '女';  //性别
           $item['phone'] = $item->customer->phone;
           $item['name'] = $item->customer->name;
           $item['wx'] = $item->customer->wx;
           $item['certificates'] = $item->customer->certificates;
           $item['department'] = $item->customer->department;
       }

       $count   =   AuthModel::
       where($where)
           ->with(['customer'])
           ->count();

       exports($customers, $data, $name,$count);
   }


}
