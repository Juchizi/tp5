<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Duty as DutyModel;
use app\admin\model\Customer;
use think\Db;
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

        $vehicle  = DutyModel::where($where)
            ->paginate(10, false, ['query' => request()->param()])->each(function($item, $key){
                if (empty($item->customers_id)) {
                    $item->customers_id = array();
                } else {
                    $item->customers_id = explode(',',$item->customers_id);
                }
            });

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

        foreach ($duty_list as $item) {
                $item['customers_id'] = explode(',',$item['customers_id']);
        }
        return view('Duty/create',['time_list' => $time_list,'customers' => $customers,'duty_list' => $duty_list]);
    }


    /**
     *  修改
     */

    public function update(Request $request)
    {
        $post   =   $request->param(true);
        for($i=0;$i<count($post['week']);$i++){

            if (empty($post['customer_id'.$i])) {
                $customer_id = '';
            } else {
                $customer_id = implode(',',$post['customer_id'.$i]);
            }
            $data = [
                'customers_id'   => $customer_id,
                'create_at'     => $post['create_at'][$i]??'',
                'week'          => $post['week'][$i]??'',
                'time'          => $post['time'][$i]??'',
                'code'          => date('Ymis',time())
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
        $customers_s = \config('admin.duty');
        $name = '值班列表';
        $where = array();
        //按时间查询
        if ($request->has('date') and $request->param('date') != '') {
            $time = explode(" ~ ", $request->param('date'));
            $start = $time[0] . ' 00:00:00';
            $end = $time[1] . ' 23:59:59';
            $where[] = ['create_at', 'between time', [$start, $end]];
        }

        $department_list = DB::table('customers')
            ->join('department','customers.department = department.id')
            ->field([
                'customers.id','customers.name','customers.phone','customers.phone2','customers.phone3','customers.portrait_url',
                'department.name as department_name'
            ])->select();
        foreach ($department_list as $item) {
            $customers[$item['id']] = [
                'id'      => $item['id'],
                'name'    => $item['name'],
                'phone'   => $item['phone'],
                'phone2'  => $item['phone2'],
                'phone3'  => $item['phone3'],
                'portrait_url' => $item['portrait_url'],
                'department_name' => $item['department_name'],
            ];
        }
        $datas = array();
//       $data  = DutyModel::where($where)->select();
        $data  = DB::table('duty')->where($where)->select();
        foreach ($data as $item) {


            if (empty($item['customers_id'])) {
                $item['customers_id'] = array();
                $item['name'] = '';
                $item['department'] = '';
                $item['phone1'] = '';
                $item['phone2'] = '';
                $item['phone3'] = '';
            } else {
                $item['customers_id'] = explode(',',$item['customers_id']);
            }
            $names = '';
            $department = '';
            $phone1     = '';
            $phone2     = '';
            $phone3     = '';
            foreach ($item['customers_id'] as $key => $value) {
                if (!empty($customers[$value])) {
                    $names .= $customers[$value]['name'].',';
                    $department .= $customers[$value]['department_name'].',';
                    $phone1 .= $customers[$value]['phone'].',';
                    $phone2 .= $customers[$value]['phone2'].',';
                    $phone3 .= $customers[$value]['phone3'].',';
                    $item['name'] = $names;
                    $item['department']  =  $department;
                    $item['phone1']      =   $phone1;
                    $item['phone2']      =  $phone2;
                    $item['phone3']      =   $phone3;

                } else {
                    $item['name'] = '';
                    $item['department'] = '';
                    $item['phone1'] = '';
                    $item['phone2'] = '';
                    $item['phone3'] = '';
                }
            }
            $datas []= [
                'name' =>  $item['name'],
                'department' => $item['department'],
                'phone1'      => $item['phone1'],
                'phone2'      => $item['phone2'],
                'phone3'      =>$item['phone3'],
                'create_at'   => $item['create_at'],
            ];
        }

        $count = DutyModel::where($where)->count();
//        export($customers, $data, $name);

        exports($customers_s, $datas, $name,$count);
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
