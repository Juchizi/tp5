<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Duty as DutyModel;
use app\admin\model\Customer;
//考勤管理
class Duty extends Common
{
    protected $middleware = ['Auth'];

    /**
     * 显示资源列表
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $where = array();
        //按时间查询
        if ($request->has('date') and $request->param('date') != '') {
            $time = explode(" ~ ", $request->param('date'));
            $start = $time[0] . ' 00:00:00';
            $end = $time[1] . ' 23:59:59';
            $where[] = ['create_at', 'between time', [$start, $end]];
        }
        $vehicle  = DutyModel::where($where)->with(['customer'])->paginate(10, false, ['query' => request()->param()]);

        return view('Duty/index',['vehicle' => $vehicle]);
    }

    /**
     *  本周值班
     */
    public function create()
    {
        $time_list =        $this->get_week();
        $customers =        Customer::all();
        $duty_list =        DutyModel::whereTime('create_at', 'between', [$time_list[0]['date'], $time_list[6]['date']])->select();

        return view('Duty/create',['time_list' => $time_list,'customers' => $customers,'duty_list' => $duty_list]);
    }


    /**
     *  修改
     */

    public function update(Request $request)
    {
        $post   =   $request->param(true);

        for($i=0;$i<count($post['customer_id']);$i++){
            $data = [
                'customers_id'   => $post['customer_id'][$i]??'',
                'create_at'     => $post['create_at'][$i]??'',
                'week'          => $post['week'][$i]??'',
                'time'          => $post['time'][$i]??'',
            ];

            if(empty(DutyModel::where('time',$post['time'][$i]??'')->find())){
                DutyModel::create($data);
            }  else {
                DutyModel::where('time',$post['time'][$i])->update($data);
            }
        }

        return redirect('Duty/index')->with('success', '操作成功');

    }

    /***
     * 导出
     */
    public function export_customer(Request $request)
    {
        $customers = \config('admin.duty');
        $name = '值班列表';
        $where = array();
        //按时间查询
        if ($request->has('date') and $request->param('date') != '') {
            $time = explode(" ~ ", $request->param('date'));
            $start = $time[0] . ' 00:00:00';
            $end = $time[1] . ' 23:59:59';
            $where[] = ['create_at', 'between time', [$start, $end]];
        }
        $data  = DutyModel::where($where)->with(['customer'])->select();
        foreach ($data as $item) {

            $item['name'] = $item->customer->name;
            $item['department'] =   $item->customer->department;
            $item['phone1']      =   $item->customer->phone;
            $item['phone2']      =   $item->customer->phone2;
            $item['phone3']      =   $item->customer->phone3;
        }

        $count = DutyModel::where($where)->with(['customer'])->count();
        exports($customers, $data, $name,$count);
    }
    //获取当前周的时间
   public function get_week($time = '', $format='Y-m-d'){
        $time = $time != '' ? $time : time();
        //获取当前周几
        $week = date('w', $time);
        $weekname = array('周一','周二','周三','周四','周五','周六','周日');
        //星期日排到末位
        if(empty($week)){
            $week=7;
        }
        $date = [];
        for ($i=0; $i<7; $i++){
            $date_time = date($format ,strtotime( '+' . $i+1-$week .' days', $time));
            $date[$i]['date'] = $date_time;
            $date[$i]['time'] = strtotime($date_time);
            $date[$i]['week'] = $weekname[$i];
        }
        return $date;
    }

}
