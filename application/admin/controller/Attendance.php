<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Attendance as AttendanceModel;
use think\Db;
use app\admin\model\Customer;
//考勤统计
class Attendance extends Common
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
       if ($request->param('name') != '') {

           $where[] = ['customers_id', '=',$request->param('name') ];
       }

       if ($request->param('department') != '') {
           $customer =   Customer::where('department', '=', $request->param('department') )->field(['id'])->select();
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
         $where[] = ['create_at', 'between time', [$start, $end]];
      }

       $attendance = AttendanceModel::
            where($where)
           ->with(['customer'])
            ->order('create_at', 'desc')
            ->paginate(10, false, ['query' => request()->param()]);

      return view('Attendance/index',['attendance' => $attendance]);
  }

   /***
    * 导出
    */
   public function export_customer(Request $request)
   {
      $customers = \config('admin.attendance');
      $name = '考勤统计';
       //模糊查询
       $where = [];
       if ($request->param('name') != '') {

           $where[] = ['customers_id', '=',$request->param('name') ];
       }

       if ($request->param('department') != '') {
           $customer =   Customer::where('department', '=', $request->param('department') )->field(['id'])->select();
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
           $where[] = ['create_at', 'between time', [$start, $end]];
       }

       $data = AttendanceModel::
       where($where)
           ->with(['customer'])
           ->order('create_at', 'desc')
           ->select();

       $count = AttendanceModel::
       where($where)
           ->with(['customer'])
           ->order('create_at', 'desc')
           ->count();

       $department  =   DB::table('department')->select();
       $departments =   array();
       foreach ($department as $key) {
           $departments [$key['id']]= $key['name'];

       }
        foreach ($data as $item) {
            if ($item['type'] == 0) {
                $item['type'] = '正常考勤';
            } elseif ($item['type']==1) {
                $item['type'] = '外出';
            } elseif ($item['type']==2) {
                $item['type'] = '请假';
            } elseif ($item['type']==3) {
                $item['type'] = '缺卡';
            } else {
                $item['type'] = '旷工';
            }

            $item['name']        = $item->customer->name??'';
            $item['department']  = $departments[$item['customer']['department']]??'';
        }
      exports($customers, $data, $name,$count);
   }


}
