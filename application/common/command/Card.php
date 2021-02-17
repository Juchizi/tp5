<?php

namespace app\common\command;

use think\Db;
use think\Controller;
use app\admin\model\Customer;
use think\console\Command;
use think\console\Input;
use think\console\Output;
//打卡
class Card extends Command
{
    protected function configure()
    {
        $this->setName('Card')
            ->setDescription('Card tp5 cli mode');
    }
    /**
     * 每日定时接口
     *
     * @return \think\Response
     */
    protected function execute(Input $input, Output $output)
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
        $output->writeln("hello test!");
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
