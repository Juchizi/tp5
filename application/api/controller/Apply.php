<?php

namespace app\api\controller;

use think\Db;
use think\Request;
use think\Controller;
use think\Validate;
use app\admin\model\Vehicle;
use app\admin\model\Department;
use app\admin\model\Customer;
//申请
class Apply extends Controller
{

   /**
    * 请假
    *
    * @return \think\Response
    */
   public function leave(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customers_id|用户id' =>  'require',
           'str_time|开始时间'  =>   'require',
           'end_time|结束时间'  =>   'require',
           'cause|请假事由'     =>   'require',
           'leave_type|请假类型' =>   'require',
           'days|请假天数'      =>    'require',
           'approver|审批人'   => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }
       $post['type'] = 4;
       $post['create_at'] = date('Y-m-d H:i:s',time());
       $post['update_at'] = date('Y-m-d H:i:s',time());

       if (!empty($post['copy_person'])) {
           foreach ($post['copy_person'] as $item) {
               $copyId[] = $item['id'];
           }
           $post['copy_person'] = implode(',', $copyId);
       }
       $info =   Vehicle::create($post);

       return $this->msg(200,$info->id, 1);
   }

   /**
    * 外出
    *
    * @return \think\Response
    */
   public function out(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customers_id|用户id' =>  'require',
           'str_time|开始时间'  =>   'require',
           'end_time|结束时间'  =>   'require',
           'cause|外出事由'         =>   'require',
           'out_address|外出地点'   => 'require',
           'approver|审批人'   => 'require',
           'duration|外出时长'  => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }
       $post['type'] = 5;
       $post['create_at'] = date('Y-m-d H:i:s',time());
       $post['update_at'] = date('Y-m-d H:i:s',time());
       if (!empty($post['copy_person'])) {
           foreach ($post['copy_person'] as $item) {
               $copyId[] = $item['id'];
           }
           $post['copy_person'] = implode(',', $copyId);
       }
       $info =  Vehicle::create($post);

       return $this->msg(200, $info->id, 1);
   }

    /**
     * 办公用品领用
     *
     * @return \think\Response
     */
    public function articles(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customers_id|用户id' =>  'require',
            'department|部门'     => 'require',
            'approver|审批人'   => 'require',
            'articles_name|用品名称' => 'require'
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }
        $post['type'] = 0;
        $post['create_at'] = date('Y-m-d H:i:s',time());
        $post['update_at'] = date('Y-m-d H:i:s',time());
        if (!empty($post['copy_person'])) {
            foreach ($post['copy_person'] as $item) {
                $copyId[] = $item['id'];
            }
            $post['copy_person'] = implode(',', $copyId);
        }
        $info = Vehicle::create($post);

        return $this->msg(200, $info->id, 1);
    }

    /**
     * 用车申请
     *
     * @return \think\Response
     */
    public function vehicle(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customers_id|用户id' =>  'require',
            'department|部门'     => 'require',
            'approver|审批人'    => 'require',
            'str_time|开始时间'  => 'require',
            'end_time|结束时间'  => 'require',
            'vehicle_num|用车数量' => 'require',
            'license_plate|车牌号'  => 'require',
            'cause|用车事由'       => 'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }
        $post['type'] = 1;
        $post['create_at'] = date('Y-m-d H:i:s',time());
        $post['update_at'] = date('Y-m-d H:i:s',time());
        if (!empty($post['copy_person'])) {
            foreach ($post['copy_person'] as $item) {
                $copyId[] = $item['id'];
            }
            $post['copy_person'] = implode(',', $copyId);
        }
        $info = Vehicle::create($post);

        return $this->msg(200, $info->id, 1);
    }

    /**
     * 会议室申请
     *
     * @return \think\Response
     */
    public function conference(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customers_id|用户id' =>  'require',
            'approver|审批人'    => 'require',
            'str_time|开始时间'  => 'require',
            'end_time|结束时间'  => 'require',
            'people_num|参会人数' => 'require',
            'meeting_name|会议名称'=> 'require',
            'company_name|承办单位'       => 'require',
            'room_name|会议室名称'  => 'require',
            'company_form|会议形式' =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }
        $post['type'] = 3;
        $post['create_at'] = date('Y-m-d H:i:s',time());
        $post['update_at'] = date('Y-m-d H:i:s',time());
        if (!empty($post['copy_person'])) {
            foreach ($post['copy_person'] as $item) {
                $copyId[] = $item['id'];
            }
            $post['copy_person'] = implode(',', $copyId);
        }
        $info = Vehicle::create($post);

        return $this->msg(200, $info->id, 1);
    }
    /**
     * 补卡申请
     *
     * @return \think\Response
     */

    public function patch(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customers_id|用户id' =>  'require',
            'approver|审批人'    => 'require',
            'patch_status|异常状态'  => 'require',
            'abnormal|补卡时间'=> 'require',
            'cause|补卡事由'       => 'require',

        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $post['type'] = 2;
        $post['create_at'] = date('Y-m-d H:i:s',time());
        $post['update_at'] = date('Y-m-d H:i:s',time());
        if (!empty($post['copy_person'])) {
            foreach ($post['copy_person'] as $item) {
                $copyId[] = $item['id'];
            }
            $post['copy_person'] = implode(',', $copyId);
        }
        $info = Vehicle::create($post);

        return $this->msg(200, $info->id, 1);
    }
    /**
     * 部门列表
     *
     * @return \think\Response
     */
    public function department()
    {
        $department =   Department::select();

        return $this->msg(200, $department, 1);
    }

    /**
     * 申请详情
     *
     * @return \think\Response
     */
    public function details(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'apply_id|申请id' =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $apply  =   Vehicle::where('id',$post['apply_id'])->find();

        if (empty($apply)) {
            return $this->msg(500, 'id错误', 2);
        }

        $customer  = Customer::where('id',$apply['customers_id'])->find();

        if ($apply['status'] == 0) {
            $status = '审批中';
        } elseif ($apply['status'] == 1) {
            $status = '已通过';
        } elseif ($apply['status'] == 2) {
            $status = '已驳回';
        } elseif ($apply['status'] == 3) {
            $status = '已撤回';
        }

        $approver       = Customer::where('id','in',$apply['approver'])->field(['id','name','portrait_url'])->select();
        $copy_person    = Customer::where('id','in',$apply['copy_person'])->field(['id','name','portrait_url'])->select();
        foreach ($approver as $item) {
            $item['portrait_url']   =   config('admin.path')['url'].$item['portrait_url'];
        }
        foreach ($copy_person as $item) {
            $item['portrait_url']   =   config('admin.path')['url'].$item['portrait_url'];
        }
        $data['apply_id']       =  $apply['id'];
        $data['department']     =  $apply['department'];
        $data['create_at']      =  $apply['create_at'];
        $data['approver']       =  $approver;
        $data['copy_person']    =  $copy_person;
        $data['path']           =   config('admin.path')['url'];
        $data['status']         =  $apply['status'];
        $data['y_status']       =   $status;
        $data['type']           =   $apply['type'];
        $data['portrait_url']   =   $customer['portrait_url'];
        if ($apply['type'] == 0) {
            $data['title']  = $customer['name'].'的办公用品领用申请';
            $data['articles_name']  = $apply['articles_name'];
        } elseif ($apply['type'] == 1) {
            $data['title']  = $customer['name'].'的用车申请';
            $data['str_time']       = $apply['str_time'];
            $data['end_time']       = $apply['end_time'];
            $data['vehicle_num']    = $apply['vehicle_num'];
            $data['license_plate']  = $apply['license_plate'];
            $data['cause']          = $apply['cause'];
        } elseif ($apply['type'] == 2) {
            $data['title']              =   $customer['name'].'的补卡申请';
            $data['patch_status']       =   $apply['patch_status'];
            $data['cause']              =   $apply['cause'];
            $data['abnormal']           =   $apply['abnormal'];
        } elseif ($apply['type'] == 3) {
            $data['title']              =   $customer['name'].'的会议事由申请';
            $data['meeting_name']       =   $apply['meeting_name'];
            $data['people_num']         =   $apply['people_num'];
            $data['company_name']       =   $apply['company_name'];
            $data['room_name']          =   $apply['room_name'];
            $data['company_form']       =   $apply['company_form'];
            $data['str_time']           = $apply['str_time'];
            $data['end_time']           = $apply['end_time'];
        } elseif ($apply['type'] == 4) {
            $data['title']              =   $customer['name'].'的请假申请';
            $data['leave_type']         =   $apply['leave_type'];
            $data['days']               =   $apply['days'];
            $data['str_time']           =   $apply['str_time'];
            $data['end_time']           =   $apply['end_time'];
            $data['cause']              =   $apply['cause'];
        } elseif ($apply['type'] == 5) {
            $data['title']              =   $customer['name'].'的外出申请';
            $data['out_address']        =   $apply['out_address'];
            $data['str_time']           =   $apply['str_time'];
            $data['end_time']           =   $apply['end_time'];
            $data['duration']           =   $apply['duration'];
            $data['cause']              =   $apply['cause'];
        }

        return $this->msg(200, $data, 1);
    }
    /**
     * 申请列表
     *
     * @return \think\Response
     */
    /**
 * @return bool
 */
    public function detailsList(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customers_id|用户id' =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }
        $data       =   array();
        $apply      =   Vehicle::where('customers_id',$post['customers_id'])->order('id desc')->select();

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
                    'title'             => '办公用品领用申请',
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
                    'title'     => '用车申请',
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
                    'title'             => '补卡申请',
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
                    'title'             => '会议室使用申请',
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
                    'title'         => '请假申请',
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
                    'title'     => '外出申请',
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
        return $this->msg(200, $data, 1);
    }

    //获取部门领导
    public function auditor(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id' =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $customer   =   Customer::where('id',$post['customer_id'])->find();

        $auditor    =   Customer::where('department',$customer['department'])->where('position',1)->find();

        $data['id']     =   $auditor['id']??'';
        $data['name']   =   $auditor['name']??'';
        $data['portrait_url']   =   config('admin.path')['url'].$auditor['portrait_url']??'';
        return $this->msg(200, $data, 1);
    }

    //获取数字方法
    public function findNum($str=''){
        $str=trim($str);
        if(empty($str)){return '';}
        $result='';
        for($i=0;$i<strlen($str);$i++){
            if(is_numeric($str[$i])){
                $result.=$str[$i];
            }
        }
        return $result;
    }

    /**
     * 获取补卡异常
     *
     * @return \think\Response
     */
    public function abnormal(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id' =>  'require',
            'time|补卡时间'      =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }
        $info =   DB::table('attendance_card')->where('customers_id',$post['customer_id'])->whereBetweenTime('create_at',$post['time'])->find();
        $customer = Customer::with(['company'])->where('id',$post['customer_id'])->find();
        if (empty($info)) {
            $data = '无异常';
        } elseif ($info['str_status']==2) {
            $data = '迟到（'.$customer['company']['go_to'].'）';
        } elseif ($info['end_status'] == 2) {
            $data = '早退（'.$customer['company']['go_off'].'）';
        } elseif ($info['type'] == 3) {
            $data = '缺卡（'.$post['time'].'）';
        } elseif ($info['type'] == 4) {
            $data = '旷工（'.$post['time'].'）';
        } else {
            $data = '无异常';
        }
        return $this->msg(200, $data, 1);
    }

}
