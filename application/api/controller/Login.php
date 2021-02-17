<?php

namespace app\api\controller;

use think\Db;
use think\Request;
use think\Controller;
use think\Validate;
use app\admin\model\Customer;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;


use Qcloud\Sms\SmsSingleSender;
//登入接口
class Login extends Controller
{

   /**
    * 发送短信接口
    *
    * @return \think\Response
    */
   public function sms(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
            'phone|手机号'     => 'require',

        ]);

        if (!$validate->check($post)) {
           return $this->msg(500,$validate->getError(),2);
        }
        $post['code']        = $this->randString();
//        $post['code']        = 8888;
        $post['create_at']   = time();
        unset($post['/api/Login/sms']);

        $con = [
            'phone' => $post['phone'],
            'code'  => $post['code'],
        ];
//
        $this->smsSend($con);
        DB::table('sms')->insert($post);

       return $this->msg(200,$post['code'],1);
   }



    public function randString($len = 4)
    {
        $chars = str_repeat('0123456789', 3);
        // 位数过长重复字符串一定次数
        $chars = str_repeat($chars, $len);
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
        return $str;
    }
   /**
    * 登入
    *
    * @return \think\Response
    */
   public function login(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'phone|手机号'     => 'require',
           'code|验证码'      => 'require'

       ]);

       if (!$validate->check($post)) {
           return $this->msg('500',$validate->getError(),2);
       }
       $sms_info    =   DB::table('sms')->where('phone',$post['phone'])->order('create_at desc')->find();
       $user_info   =   Customer::where('phone',$post['phone'])->find();

       if (empty($user_info)) {
           return $this->msg('500','用户不存在',2);
       }

       if ($sms_info['code'] != $post['code']) {
           return $this->msg('500','验证码不正确',2);
       }

       if ($sms_info['create_at']+60 < time()){
           return $this->msg('500','验证码过期',2);
       }

       $login  =[
           'customers_id'   => $user_info['id'],
           'create_at'      => date('Y-m-d H:i:s',time()),
           'update_at'      => date('Y-m-d H:i:s',time()),
       ];
       DB::table('login_log')->insert($login);

       $data = [
           'customer_id' =>  $user_info['id'],
           'phone'       =>  $user_info['phone'],
           'department'  =>  $user_info['department'],
           'position'    =>  $user_info['position'],
       ];

       return $this->msg('200',$data,1);
   }

   /**
    * 用户信息
    *
    * @param  \think\Request $request
    * @return \think\Response
    */
   public function CustomersInfo(Request $request)
   {
       $post = $request->param(true);

       $validate = new Validate([
           'customer_id|用户id'     => 'require',
       ]);

       if (!$validate->check($post)) {
           return $this->msg(500,$validate->getError(),2);
       }

       $user_info   =   Customer::where('id',$post['customer_id'])->find();

       $data = [
           'name'           => $user_info['name'],
           'portrait_url'   => config('admin.path')['url'].$user_info['portrait_url'],
       ];

       return $this->msg(200,$data,1);
   }

    /**
     * 集成方法：阿里云(原大鱼)发送短信验证码
     * @param string $phoneNumber 目标手机号
     * TODO 注意 accessKeyId、accessSecret、signName、templateCode 重要参数的获取配置
     */
    public function sendAliDaYuAuthCode($con)
    {
        $accessKeyId = 'LTAXXXXXXXXXC';
        $accessSecret = '8gfwbXXXXXXXXXXXXXXXXXXXXXXXXXXXXA'; //注意不要有空格
        $signName = 'XXXXX'; //配置签名
        $templateCode = 'SMS_1XXXXXX5';//配置短信模板编号

        //TODO 短信模板变量替换JSON串,友情提示:如果JSON中需要带换行符,请参照标准的JSON协议。
        $jsonTemplateParam = json_encode(['code'=>$con['code']]);

        AlibabaCloud::accessKeyClient($accessKeyId, $accessSecret)
            ->regionId('cn-hangzhou')
            ->asGlobalClient();
        try {
            $result = AlibabaCloud::rpcRequest()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'RegionId' => 'cn-hangzhou',
                        'PhoneNumbers' => $con['phone'],//目标手机号
                        'SignName' => $signName,
                        'TemplateCode' => $templateCode,
                        'TemplateParam' => $jsonTemplateParam,
                    ],
                ])
                ->request();
            $opRes = $result->toArray();
            //print_r($opRes);
            if ($opRes && $opRes['Code'] == "OK"){
                //进行Cookie保存
//                cookie("authCodeMT",$con['code'],300);
            }
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }

    /**
     * 腾讯云
     */
    public function smsSend($con){
        // $appid $appkey $templateId $smsSign为官方demo所带，请修改为你自己的
        // 短信应用SDK AppID
        $appid = 1400304990;
        // 短信应用SDK AppKey
        $appkey = "4b540b9842ea2399a6593d4c64f23f76";
        // 你的手机号码。
        $phoneNumber = $con['phone'];
        // 短信模板ID，需要在短信应用中申请
        $templateId = 521313;  // NOTE: 这里的模板ID`7839`只是一个示例，真实的模板ID需要在短信控制台中申请
        // 签名
        $smsSign = "东河检察院"; // NOTE: 这里的签名只是示例，请使用真实的已申请的签名，签名参数使用的是`签名内容`，而不是`签名ID`
        // 单发短信
//        try {
//            $ssender = new SmsSingleSender($appid, $appkey);
//            $result = $ssender->send(0, 86, $phoneNumber,
//                "$con[code]为您的登录验证码，请于1分钟内填写。如非本人操作，请忽略本短信。", "", "");
//            $rsp = json_decode($result);
////            echo $result;
//        } catch(\Exception $e) {
//            echo var_dump($e);
//        }
//        //暂停3秒
//        sleep(3);
        // 指定模板ID单发短信
        try {
            $ssender = new SmsSingleSender($appid, $appkey);
            $params = [$con['code']];
            $result = $ssender->sendWithParam("86", $phoneNumber, $templateId,
                $params, $smsSign, "", "");  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result);
//            echo $result;
        } catch(\Exception $e) {
            echo var_dump($e);
        }
    }

    //检查账户是否合法
    public function legitimate(Request $request)
    {
        $post = $request->param(true);

        $validate = new Validate([
            'phone|手机号'     => 'require',
        ]);

        if (!$validate->check($post)) {
            return $this->msg(500,$validate->getError(),2);
        }

        $info = DB::table('customers')->where('phone',$post['phone'])->count();

        if ($info == 0) {
            return $this->msg(500,false,2);
        } else {
            return $this->msg(200,true,1);
        }
    }

}
