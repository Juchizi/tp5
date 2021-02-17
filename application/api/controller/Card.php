<?php

namespace app\api\controller;

use think\Db;
use think\Request;
use think\Controller;
use think\Validate;
use app\admin\model\Customer;
use app\admin\model\Company;
use app\admin\model\Department;
//打卡
class Card extends Controller
{

   /**
    * 文件列表
    *
    * @return \think\Response
    */
   public function clock(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id' =>  'require',
           'lat|纬度'           =>  'require',
           'lng|经度'           =>  'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }

       $customer    =   Customer::where('id',$post['customer_id'])->find();

       $company      =   Company::where('department_id',$customer['department'])->find();

       return $this->Webservice($post,$company);

   }


   public function Webservice($post,$company)
   {
           $r2 = https_request("https://apis.map.qq.com/ws/distance/v1/?mode=walking&from=$company[lat],$company[lng]&to=$post[lat],$post[lng]&key=7BCBZ-SA36P-646DZ-L42XD-3FQVJ-XHBRI");

           $arr = json_decode($r2,true);
           if($arr['status']==0){
               if($arr['result']['elements'][0]['distance']>$company['range']){
                   return $this->msg(500,'当前位置不在服务范围',2);
               } else {
                   $card_info   =   Db::table('attendance_card')->where('customers_id',$post['customer_id'])->whereTime('create_at', 'today')->find();

                   $data['update_at']    = date('Y-m-d H:i:s',time());
                   $data['customers_id'] = $post['customer_id'];
                   if (empty($card_info)) { //上班打卡

                       if (time() < strtotime((date('Y-m-d')." $company[go_to]"))){
                            $str_status         =   1;
                       } else {
                           $str_status          =   2;
                           $data['late_time']   =   (int)((time() -  strtotime((date('Y-m-d')." $company[go_to]"))) / 60);
                       }
                       $data['create_at']    = date('Y-m-d H:i:s',time());
                       $data['str_status']   = $str_status;
                       $data['end_status']   = 0;
                       $data['str_time']     = date('Y-m-d H:i:s',time());
                       $data['type']         = 0;
//                        dump($data);exit;
                       DB::table('attendance_card')->insert($data);
                   } elseif($card_info['type'] == 0 && $card_info['end_status'] == 0) {

                       if (time() > strtotime((date('Y-m-d')." $company[go_off]"))) {
                            $end_status  = 1;
                       } else {
                            $end_status  = 2;
                       }
                       $data['end_status']  =   $end_status;
                       $data['end_time']    =   date('Y-m-d H:i:s',time());

                       DB::table('attendance_card')->where('customers_id',$post['customer_id'])->whereTime('create_at', 'today')->update($data);
                   }

                   return $this->msg(200,'打卡成功',1);
               }
           }else{
               return $this->msg(500,$arr,2);
           }

   }

   /**
    * 打卡信息
    *
    * @return \think\Response
    */
   public function card(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id' =>  'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500, $validate->getError(), 2);
       }

       $customer = Customer::where('id',$post['customer_id'])->find();
        $attendance_card = DB::table('attendance_card')->whereTime('create_at', 'today')->where('customers_id',$customer['id'])->find();
       $company  =  DB::table('company')->where('department_id',$customer['department'])->find();
     $data = [
           'address' => $company['address'],
           'range'   => $company['range'],
           'go_to'   => $company['go_to'],
           'go_off'  => $company['go_off'],
           'lng'     => $company['lng'],
           'lat'     => $company['lat'],
         'str_time'  => $attendance_card['str_time']??'',
         'end_time'  => $attendance_card['end_time']??'',
       ];

       return $this->msg(200,$data,1);
   }

    /**
     * 获取打卡状态
     *
     * @return \think\Response
     */
    public function IfCard(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'customer_id|用户id' =>  'require',
            'lat|纬度'           =>  'require',
            'lng|经度'           =>  'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500, $validate->getError(), 2);
        }

        $customer    =   Customer::where('id',$post['customer_id'])->find();

        $company      =   Company::where('department_id',$customer['department'])->find();

        $r2 = https_request("https://apis.map.qq.com/ws/distance/v1/?mode=walking&from=$company[lat],$company[lng]&to=$post[lat],$post[lng]&key=7BCBZ-SA36P-646DZ-L42XD-3FQVJ-XHBRI");

        $arr = json_decode($r2,true);
        if($arr['status']==0) {
            if ($arr['result']['elements'][0]['distance'] > $company['range']) {
                return $this->msg(500, $company, 2);//位子不在服务区
            } else {
                $card_info = Db::table('attendance_card')->where('customers_id', $post['customer_id'])->whereTime('create_at', 'today')->find();
                if (empty($card_info)) { //上班打卡
                    return $this->msg(200, ['status' => 1,'str_time' => $card_info['str_time']??'','end_time' => $card_info['end_time']??''], 1);
                } elseif ($card_info['type'] == 0 && $card_info['end_status'] == 0) {
                    return $this->msg(200, ['status' => 2,'str_time' => $card_info['str_time']??'','end_time' => $card_info['end_time']??''], 1);
                }
                    return $this->msg(200, ['status' => 3,'str_time' => $card_info['str_time']??'','end_time' => $card_info['end_time']??''], 1);
            }
        }else{
                return $this->msg(501, $arr, 2);
        }
    }

    /**
     * 每日定时接口
     *
     * @return \think\Response
     */
    public function cardTiming()
    {
        $this->GetHoliday();//节假日
        $holiday_list = DB::table('holiday_list')->where('startday', 'like', "%" . date('Y',time()) . "%")->select();//今年节假日
        $time       =   date('Y-m-d',time());  //当天时间
        $week       =   date('w',time());//周
        $customer   =   Customer::has('company',1)->with(['company'])->select(); //用户
        foreach ($holiday_list as $item) {
            $holiday[] = strtotime($item['startday']);
        }

        foreach ($customer as $item) {
            if (in_array($week,explode(',',$item['company']['working_day']))){ //判断工作日
                if($item['company']['legal'] == 1 || !in_array(strtotime($time),$holiday)) { //判断是否是法定假日
                    $card_info = Db::table('attendance_card')->where('customers_id', $item['id'])->whereTime('create_at', 'today')->find();

                    if (empty($card_info)) {
                        $data['create_at'] = date('Y-m-d H:i:s',time());
                        $data['update_at'] = date('Y-m-d H:i:s',time());
                        $data['type']      = 4;
                        $data['customers_id']   =   $item['id'];
                        Db::table('attendance_card')->insert($data);
                    }
                    if($card_info['type'] == 0 && $card_info['end_status'] ==  0){
                        $data['update_at'] = date('Y-m-d H:i:s',time());
                        $data['type']      = 3;
                        DB::table('attendance_card')->where('id',$card_info['id'])->update($data);
                    }
                }
            }
        }
    }

    /**
     * 判断今年是否更新节假日
     *
     * @return \think\Response
     */

    public function GetHoliday()
    {
        $holiday_list = DB::table('holiday_list')->where('startday', 'like', "%" . date('Y',time()) . "%")->select();
        if(empty($holiday_list)) {
            $holiday =   $this->GetDate(date('Y',time()))['result']['data']['holiday_list'];
            DB::table('holiday_list')->insertAll($holiday);
        }
    }
    //获取节假日接口
    public function GetDate($year)
    {

//************3.获取当年的假期列表************
        $url = "http://v.juhe.cn/calendar/year";
        $params = array(
            "key" => '77bec053c855f5c608e7072796ad7913',//您申请的appKey
            "year" => $year,//指定年份,格式为YYYY,如:2015
        );
        $paramstring = http_build_query($params);
        $content = $this->juhecurl($url, $paramstring);
        $result = json_decode($content, true);
        if ($result) {
            if ($result['error_code'] == '0') {
                return $result;
            } else {
//                echo $result['error_code'].":".$result['reason'];
            }
        } else {
//            echo "请求失败";
        }
    }
}
