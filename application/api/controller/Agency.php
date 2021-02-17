<?php

namespace app\api\controller;

use think\Db;
use think\Request;
use think\Controller;
use think\Validate;
use app\admin\model\Customer;
use app\admin\model\Vehicle;
use app\admin\model\Attendance;
//代办
class Agency extends Controller
{

   /**
    * 文件列表
    *
    * @return \think\Response
    */
   public function examineList(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id'   =>  'require',
           'status|状态'          =>  'require'
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }

       if ($post['status']==0){
            $where[] = ['status','in',[0]];
            $where[] = ['approver','=',$post['customer_id']];
       } elseif ($post['status']==1) {
            $where[] = ['status','in',[1,2,3]];
           $where[] = ['approver','=',$post['customer_id']];
       } elseif ($post['status']==2) {
           $apply_list  =     Vehicle::select();

            $apply_id = [];
            foreach ($apply_list as $item) {
                if(!empty($item['copy_person'])){

                  $arr =   explode(',',$item['copy_person']);

                  if (in_array($post['customer_id'],$arr)) {
                      $apply_id[] = $item['id'];
                  }
                }
            }

           $where[] = ['id', 'in', $apply_id];
       }

       $customer    =  Customer::where('id',$post['customer_id'])->find();


           $apply      =   Vehicle::where($where)->order('id desc')->select();

           $customerList    =   Customer::select();

           foreach ($customerList as $item) {
               $customer_list [$item['id']]  =   $item['name'];
           }
           $data = array();
           foreach ($apply as $item) {

               if ($item['status'] == 0) {
                   $status = '审批中';
               } elseif ($item['status'] == 1) {
                   $status = '已通过';
               } elseif ($item['status'] == 2) {
                   $status = '已驳回';
               } elseif ($item['status'] == 3) {
                   $status = '已撤回';
               }

               if ($item['type'] == 0) {
                   $data[] = [
                       'id'                => $item['id'],
                       'title'             => $customer_list[$item['customers_id']].'办公用品领用申请',
                       'articles_name'     => $item['articles_name'],
                       'department'        => $item['department'],
                       'type'              => $item['type'],
                       'status'            => $item['status'],
                       'y_status'          => $status,
                       'create_at'         => $item['create_at'],
                   ];

               } elseif ($item['type'] == 1) {

                   $data[] = [
                       'id'                => $item['id'],
                       'title'     => $customer_list[$item['customers_id']].'用车申请',
                       'cause'     => $item['cause'],
                       'str_time'  => $item['str_time'],
                       'end_time'  => $item['end_time'],
                       'type'              => $item['type'],
                       'status'            => $item['status'],
                       'y_status'          => $status,
                       'create_at'         => $item['create_at'],
                   ];

               } elseif ($item['type'] == 2) {

                   $data[] = [
                       'id'                => $item['id'],
                       'title'             => $customer_list[$item['customers_id']].'补卡申请',
                       'patch_status'      => $item['patch_status'],
                       'abnormal'          => $item['abnormal'],
                       'cause'             => $item['cause'],
                       'type'              => $item['type'],
                       'status'            => $item['status'],
                       'y_status'          => $status,
                       'create_at'         => $item['create_at'],
                   ];

               } elseif ($item['type'] == 3) {

                   $data[] = [
                       'id'                => $item['id'],
                       'title'             => $customer_list[$item['customers_id']].'会议室使用申请',
                       'meeting_name'      => $item['meeting_name'],
                       'company_name'      => $item['company_name'],
                       'str_time'          => $item['str_time'],
                       'type'              => $item['type'],
                       'status'            => $item['status'],
                       'y_status'          => $status,
                       'create_at'         => $item['create_at'],
                   ];

               } elseif ($item['type'] == 4) {

                   $data[] = [
                       'id'                => $item['id'],
                       'title'         => $customer_list[$item['customers_id']].'请假申请',
                       'leave_type'    => $item['leave_type'],
                       'str_time'      => $item['str_time'],
                       'end_time'      => $item['end_time'],
                       'type'              => $item['type'],
                       'status'            => $item['status'],
                       'y_status'          => $status,
                       'create_at'         => $item['create_at'],
                   ];


               } elseif ($item['type'] == 5) {

                   $data[] = [
                       'id'                => $item['id'],
                       'title'     => $customer_list[$item['customers_id']].'外出申请',
                       'cause'     => $item['cause'],
                       'out_address'   => $item['out_address'],
                       'str_time'  => $item['str_time'],
                       'type'              => $item['type'],
                       'status'            => $item['status'],
                       'y_status'          => $status,
                       'create_at'         => $item['create_at'],
                   ];

               }

           }
           return $this->msg(200,$data, 1);


   }


    /**
     * 是否有待处理
     *
     * @return \think\Response
     */
    public function ifExamine(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id'   =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $num      =   Vehicle::where('approver',$post['customer_id'])->where('status',0)->count();

        if ($num == 0) {
            return $this->msg(200,'没待处理', 1);
        } else {
            return $this->msg(500,'有待处理', 2);
        }
    }

    /**
     * 审核驳回
     *
     * @return \think\Response
     */
    public function reject(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id'   =>  'require',
            'apply_id|申请id'      =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $data['status']     =   2;
        $data['update_at']  =   date('Y-m-d H:i:s',time());
        $data['opinion']    =   $post['opinion']??'';
        Vehicle::where('approver',$post['customer_id'])->where('id',$post['apply_id'])->update($data);

        return $this->msg(200,'操作成功', 1);
    }

    /**
     * 审核通过
     *
     * @return \think\Response
     */
    public function agree(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id'   =>  'require',
            'apply_id|申请id'      =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

       $apply_info =  Vehicle::where('approver',$post['customer_id'])->where('id',$post['apply_id'])->find();
//（0：办公用品领用）（1：用车）（2：补卡）（3：会议室使用）（4：请假）（5：外出）
        $data['status']     =   1;
        $data['update_at']  =   date('Y-m-d H:i:s',time());
        $data['opinion']    =   $post['opinion']??'';
       if ($apply_info['type'] == 2) {

           $abnormal    =   $apply_info['abnormal'];//补卡时间
           $Datetime = date('H',strtotime($abnormal));
           $WhereTime   =  date('Y-m-d',strtotime($abnormal));//补卡
           $card    =     Attendance::whereBetweenTime('create_at',$WhereTime)->where('customers_id',$apply_info['customers_id'])->find();

           if (empty($card)) {
               $cardData['create_at']   =  date('Y-m-d H:i:s',strtotime($abnormal));//补卡
               $cardData['update_at']   =  date('Y-m-d',time());
               $cardData['str_status']  = 0;
               $cardData['end_status']  = 0;
               $cardData['type']        = 0;
               $cardData['customers_id']= $apply_info['customers_id'];
               Attendance::create($cardData);
           }
           if ($Datetime>6&&$Datetime<12){
               Attendance::whereBetweenTime('create_at',$WhereTime)->where('customers_id',$apply_info['customers_id'])->update(['str_status' => 1]);
           } if ($Datetime>=12&&$Datetime<=24){
               Attendance::whereBetweenTime('create_at',$WhereTime)->where('customers_id',$apply_info['customers_id'])->update(['end_status' => 1]);
           }
       } elseif($apply_info['type'] == 4) {
           $str_time    =   $apply_info['str_time'];//请假开始时间
           $end_time    =   $apply_info['end_time'];//请假结束时间

           $createList =  $this->prDates($str_time,$end_time);

           $dataList    =   array();
            foreach ($createList as $key =>  $item) {
                $dataList []=[
                    'create_at' => $item,
                    'type'      => 2,
                    'customers_id'  => $apply_info['customers_id']
                ];
            }
           Attendance::insertAll($dataList);
       } elseif ($apply_info['type'] == 5) {
           $str_time    =   $apply_info['str_time'];//请假开始时间
           $end_time    =   $apply_info['end_time'];//请假结束时间

           $createList =  $this->prDates($str_time,$end_time);

           $dataList    =   array();
           foreach ($createList as $key =>  $item) {
               $dataList []=[
                   'create_at' => $item,
                   'type'      => 1,
                   'customers_id'  => $apply_info['customers_id']
               ];
           }
           Attendance::insertAll($dataList);
       }
        Vehicle::where('approver',$post['customer_id'])->where('id',$post['apply_id'])->update($data);

        return $this->msg(200,'操作成功', 1);
    }

    /**
     * 获取时间方法
     *
     * @return \think\Response
     */
    public function prDates($start,$end){ // 两个日期之间的所有日期
        $dt_start = strtotime($start);
        $dt_end = strtotime($end);
        $time = array();
        while ($dt_start<=$dt_end){
            $time[] = date('Y-m-d',$dt_start);

            $dt_start = strtotime('+1 day',$dt_start);
        }
        return $time;
    }

    /**
     * 转审
     * @return \think\Response
     */
    public function transfer(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id'   =>  'require',
            'apply_id|申请id'      =>  'require',
            'turn_id|转审人id'     =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $customer   =   Customer::where('id',$post['turn_id'])->find();

        if  ($customer['position'] != 1) {
            return $this->msg(500,'不是部门领导', 2);
        }
        $data['opinion']    =   $post['opinion']??'';
        $data['approver']    =   $post['turn_id']??'';
        Vehicle::where('approver',$post['customer_id'])->where('id',$post['apply_id'])->update($data);

        return $this->msg(200,'操作成功', 1);
    }
    /**
     * 重新提交
     * @return \think\Response
     */
    public function again(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id'   =>  'require',
            'apply_id|申请id'      =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $data['status']     =   0;
        $data['update_at']  =   date('Y-m-d H:i:s',time());
        Vehicle::where('customers_id',$post['customer_id'])->where('id',$post['apply_id'])->update($data);
        return $this->msg(200,'操作成功', 1);
    }
    /**
     * 催办
     * @return \think\Response
     */
    public function urge(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id'   =>  'require',
            'apply_id|申请id'      =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }
        return $this->msg(200,'操作成功', 1);
    }

    /**
     * 撤回
     * @return \think\Response
     */
    public function withdraw(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id'   =>  'require',
            'apply_id|申请id'      =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }
        $data['status']     =   3;
        $data['update_at']  =   date('Y-m-d H:i:s',time());
        Vehicle::where('customers_id',$post['customer_id'])->where('id',$post['apply_id'])->update($data);

        return $this->msg(200,'操作成功', 1);
    }

    /**
     * 修改
     * @return \think\Response
     */
    public function update(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id'   =>  'require',
            'apply_id|申请id'      =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }
        $apply_id           =   $post['apply_id'];
        $customer_id        =   $post['customer_id'];
        $post['status']     =   0;
        $post['update_at']  =   date('Y-m-d H:i:s',time());
        unset($post['apply_id']);
        unset($post['customer_id']);
        if (!empty($post['copy_person'])) {
            foreach ($post['copy_person'] as $item) {
                $copyId[] = $item['id'];
            }
            $post['copy_person'] = implode(',', $copyId);
        }
        Vehicle::where('customers_id',$customer_id)->where('id',$apply_id)->update($post);

        return $this->msg(200,'操作成功', 1);
    }
}
