<?php

namespace app\api\controller;

use think\Db;
use think\Request;
use think\Controller;
use think\Validate;
use app\admin\model\File;
use app\admin\model\Customer;
use app\admin\model\Department;
use app\admin\model\Duty;
use app\admin\model\Vehicle;
//登入接口
class Customers extends Controller
{

   /**
    * 文件列表
    *
    * @return \think\Response
    */
   public function file(Request $request)
   {
      $file_list = File::select();


      foreach ($file_list as $item) {
          $item['url_name'] =   $item['url'];
          $item['url']  =   config('admin.path')['url'].$item['url'];
      }
       return $this->msg(200,$file_list,1);
   }


   /**
    * 部门联系人
    *
    * @return \think\Response
    */
   public function department(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id' => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }
       $where = [];
       if(!empty($post['name'])) {
           $where[] = ['name', 'like', "%" . $post['name'] . "%"];
       }
       $customer_info = Customer::where('id', $post['customer_id'])->find();
       $sign = DB::table('sign')->where('customer_id', $customer_info['id'])->select();

       $sign_array = array();

       foreach ($sign as $item) {
           $sign_array[] = $item['relative_id'];
       }
       $customer = Customer::with(['departments'])->where('department', $customer_info['department'])->where('id', '<>', $customer_info['id'])->where($where)->select();
       $customer_list = array();
       foreach ($customer as $item) {

           if (in_array($item['id'], $sign_array)) {
               $if_sign = true;
           } else {
               $if_sign = false;
           }
           $customer_list[] = [
               'id' => $item['id'],
               'department' => $item['departments']['name'],
               'phone' => $item['phone'],
               'phone2' => $item['phone2'],
               'phone3' => $item['phone3'],
               'if_sign' => $if_sign,
               'name'    => $item['name'],
               'portrait_url'   => config('admin.path')['url'].$item['portrait_url'],
           ];
       }
       return $this->msg(200, $customer_list, 1);
   }
   /**
    * 标记操作
    *
    * @param  \think\Request $request
    * @return \think\Response
    */
   public function sing(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id' => 'require',
           'relative_id|被标记用户id' => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }

       $sign    =   DB::table('sign')->where('customer_id',$post['customer_id'])->where('relative_id',$post['relative_id'])->find();

       if (empty($sign)) {
           unset($post['/api/Customers/sing']);
           DB::table('sign')->insert($post);
       } else {
           DB::table('sign')->where('relative_id',$post['relative_id'])->where('customer_id',$post['customer_id'])->delete();
       }

       return $this->msg(200, '操作成功', 1);
   }

   /**
    * 标记联系人
    *
    * @param  int $id
    * @return \think\Response
    */
   public function SignList(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id' => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }
       $where = [];
       if(!empty($post['name'])) {
           $where[] = ['name', 'like', "%" . $post['name'] . "%"];
       }
       $sign    =   DB::table('sign')->where('customer_id',$post['customer_id'])->select();
       $sign_arr = array();
       foreach ($sign as $item){
           $sign_arr [] = $item['relative_id'];
       }
       if (empty($sign_arr)) {
           $relative_id = '';
       } else {
           $relative_id = implode(',',$sign_arr);
       }
       $customer = Customer::with(['departments'])->where('id','in',$relative_id)->where($where)->select();
       $customer_list = array();
       foreach ($customer as $item) {
           $customer_list[] = [
               'id' => $item['id'],
               'department' => $item['departments']['name'],
               'phone' => $item['phone'],
               'phone2' => $item['phone2'],
               'phone3' => $item['phone3'],
               'name'    => $item['name'],
               'portrait_url'   => config('admin.path')['url'].$item['portrait_url'],
           ];
       }

       return $this->msg(200, $customer_list, 1);
   }

   /**
    * 组织架构
    *
    * @return \think\Response
    */
   public function organization(Request $request)
   {

       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id' => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }
       $where = [];
       if(!empty($post['name'])) {
           $where[] = ['name', 'like', "%" . $post['name'] . "%"];
       }

        $department = Department::select();
        $department_arr = array();
        $list     = array();
        foreach ($department as $item) {
            $departmentList [$item['id']]= $item['name'];
        }
       $sign = DB::table('sign')->where('customer_id', $post['customer_id'])->select();

       $sign_array = array();

       foreach ($sign as $item) {
           $sign_array[] = $item['relative_id'];
       }
       $customer = Customer::has('company',1)->with(['departments'])->where($where)->select();
       foreach ($customer as $qs) {

           if (in_array($qs['id'], $sign_array)) {
               $if_sign = true;
           } else {
               $if_sign = false;
           }
                $list[$qs['department']][] = [
                    'id' => $qs['id'],
                    'department' => $qs['departments']['name'],
                    'phone' => $qs['phone'],
                    'phone2' => $qs['phone2'],
                    'phone3' => $qs['phone3'],
                    'name'    => $qs['name'],
                    'if_sign' => $if_sign,
                    'portrait_url'   => config('admin.path')['url'].$qs['portrait_url'],
                ];
            }
        foreach ($departmentList as $key => $value) {

            $department_arr [] = [
                'department' => $value,
                'list'=>  $list[$key]??'',
            ];

        }
       return $this->msg(200, $department_arr, 1);
   }

   /**
    * 值班列表
    *
    * @param  \think\Request $request
    * @param  int $id
    * @return \think\Response
    */
   public function duty(Request $request)
   {

       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id' => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }

       $time_list =        $this->get_week();
       $duty_list =        Duty::whereTime('create_at', 'between', [$time_list[0]['date'], $time_list[6]['date']])->select();

       if (empty($duty_list)) {
           return $this->msg(500, '暂未安排', 2);
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
       $duty_arr  = array();
       $code = '';
       foreach ($duty_list as $item) {

           if (!empty($item['customers_id'])) {
               $customers_id = explode(',',$item['customers_id']);
           } else {
               $customers_id = array();
           }
           if (in_array($post['customer_id'],$customers_id)) {
               $sign = true;
           } else {
               $sign = false;
           }
           $names = array();
           $department = array();
           $phone1     = array();
           $phone2     = array();
           $phone3     = array();
           foreach ($customers_id as $key => $value) {

               if (!empty($customers[$value])) {

                   $names []= $customers[$value]['name']??'';
                   $department []= $customers[$value]['department_name']??'';
                   $phone1 []= $customers[$value]['phone']??'';
                   $phone2 []= $customers[$value]['phone2']??'';
                   $phone3 []= $customers[$value]['phone3']??'';
               }
           }
           $code = $item['code'];
           $duty_arr [] =[
               'id'         => $item['customer']['id'],
               'name'       => $names,
               'phone'      => $phone1,
               'phone2'     => $phone2,
               'phone3'     => $phone3,
               'week'       => $item['week'],
               'day'        => date('d',$item['time']),
               'time'       => date('Y-m-d',$item['time']),
               'sign'       => $sign,
           ];
       }
       $duty_if =   DB::table('duty_if')->where('sign_code',$code)->where('customer_id',$post['customer_id'])->find();
       if (empty($duty_if)){
           $dutyData  ['customer_id'] = $post['customer_id'];
           $dutyData  ['sign_code'] = $code;
           DB::table('duty_if')->insert($dutyData);
       }
       return $this->msg(200, $duty_arr, 1);
   }

   /**
    * 出勤统计duty
    *
    * @param  int $id
    * @return \think\Response
    */
   public function attendance(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id' => 'require',
           'month|月份'         => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }
       $data['sel_time'] =  $post['month'];
       $data['str_time'] = strtotime($data['sel_time']);        //指定月份的开始时间戳
       $data['end_time'] = mktime(23,59,59,date('m',strtotime($data['sel_time']))+1,00);  //指定月份月末时间戳
       $start = date('Y-m-d',$data['str_time']) . ' 00:00:00';
       $end   = date('Y',$data['str_time']).'-'. date('m-d',$data['end_time']) . ' 23:59:59';
       $where[] = ['create_at', 'between time', [$start, $end]];
       $arr = array();
       $arr = [
           'attendance'  => DB::table('attendance_card')
               ->where('type','in',[0,3,5,6])
               ->where('customers_id',$post['customer_id'])
               ->where($where)
               ->count(),
           'sick_leave'  => Vehicle::where($where)
               ->where('status',1)
               ->where('leave_type','病假')
               ->count(),
           'matter_leave' => Vehicle::where($where)
               ->where('status',1)
               ->where('leave_type','事假')
               ->count(),
           'late'         => DB::table('attendance_card')
               ->where('str_status',2)
               ->where('customers_id',$post['customer_id'])
               ->where($where)
               ->count(),
           'early'        => DB::table('attendance_card')->where($where)
               ->where('end_status',2)
               ->where('customers_id',$post['customer_id'])
               ->count(),
           'absenteeism'  => DB::table('attendance_card')->where($where)
               ->where('type',4)
               ->where('customers_id',$post['customer_id'])
               ->count(),
       ];

       return $this->msg(200, $arr, 1);
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
    /**
     * 判断是否查看本周值班duty
     *
     * @param  int $id
     * @return \think\Response
     */

    public function ifDuty(Request $request){
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id' => 'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $time_list =        $this->get_week();
        $duty_list =        Duty::whereTime('create_at', 'between', [$time_list[0]['date'], $time_list[6]['date']])->select();

        if (empty($duty_list) || count($duty_list) == 0) {
            return $this->msg(500, '未读', 2);
        }
        $customer_id = array();
        foreach ($duty_list as $item) {
            $code = $item['code'];
            if (!empty($item['customers_id'])) {
              $customer_id[] =  explode(',',$item['customers_id']);
            }
        }

        $duty_if    =   DB::table('duty_if')->where('customer_id',$post['customer_id'])->where('sign_code',$code)->find();

        $result = array_reduce($customer_id, 'array_merge', array());


        if (!in_array($post['customer_id'],$result)){
            return $this->msg(200, '已读', 1);
        }elseif (empty($duty_if)) {
            return $this->msg(500, '未读', 2);
        } elseif(!empty($duty_if)) {
            return $this->msg(200, '已读', 1);
        } else {
            return $this->msg(200, '已读', 1);
        }

    }

    /**
     * 关于我们
     *
     * @param  int $id
     * @return \think\Response
     */
    public function About()
    {
        $info = DB::table('about')->where('id',1)->find();

        return $this->msg(200, $info, 1);
    }

}
