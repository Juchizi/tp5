<?php

namespace app\admin\controller;

use think\Db;
use think\facade\Cache;
use app\admin\model\Vehicle;
use app\admin\model\Attendance;
use app\admin\model\Login;
class Index extends Common
{
   /**
    * 后台首页
    */
   public function index()
   {


      return view('/index');
   }

   /***
    * 后台首页主要内容
    */
   public function main()
   {
       $login_count      =   DB::table('login_log')->count();
       $vehicle_count    =   Vehicle::where('type',1)->count();
       $articles_count   =   Vehicle::where('type',0)->count();
       $room_count       =   Vehicle::where('type',3)->count();
       $duration_count   =   Vehicle::where('type',5)->count();
       $leave_count      =   Vehicle::where('type',4)->count();
       $patch_count      =   Vehicle::where('type',2)->count();
       $attendance_count =   Attendance::count();
       return view('/main',compact('login_count','vehicle_count','articles_count','room_count','duration_count','leave_count','patch_count','attendance_count'));
   }

   /**
    *  统计图
    */
   public function customer_count()
   {
       $time = array();
       $year    =   date('Y',time()).'-';
       for ($i=1;$i<13;$i++){
           $time[]  = $i.'-01';
       }

       for ($j=0;$j<count($time);$j++){
           if (isset($time[$j+1])) {
               $data[] = [
                   'login'   => Login::whereTime('create_at', [($year.$time[$j]),($year.$time[$j+1])])->count(),
                   'vehicle' => Vehicle::where('type',1)->whereTime('create_at', [($year.$time[$j]),($year.$time[$j+1])])->count(),
                   'articles' => Vehicle::where('type',0)->whereTime('create_at', [($year.$time[$j]),($year.$time[$j+1])])->count(),
                   'room' => Vehicle::where('type',3)->whereTime('create_at', [($year.$time[$j]),($year.$time[$j+1])])->count(),
                   'duration' => Vehicle::where('type',5)->whereTime('create_at', [($year.$time[$j]),($year.$time[$j+1])])->count(),
                   'leaves' => Vehicle::where('type',4)->whereTime('create_at', [($year.$time[$j]),($year.$time[$j+1])])->count(),
                   'patch' => Vehicle::where('type',2)->whereTime('create_at', [($year.$time[$j]),($year.$time[$j+1])])->count(),
                   'attendance' => Attendance::whereTime('create_at',  [($year.$time[$j]),($year.$time[$j+1])])->count(),
                   ];
           } else {
               $data[] = [
                   'vehicle' => Vehicle::where('type',1)->whereTime('create_at', [($year.$time[$j]),($year.'12'.'-30')])->count(),
                   'articles' => Vehicle::where('type',0)->whereTime('create_at', [($year.$time[$j]),($year.'12'.'-30')])->count(),
                   'room' => Vehicle::where('type',3)->whereTime('create_at', [($year.$time[$j]),($year.'12'.'-30')])->count(),
                   'duration' => Vehicle::where('type',5)->whereTime('create_at', [($year.$time[$j]),($year.'12'.'-30')])->count(),
                   'leaves' => Vehicle::where('type',4)->whereTime('create_at', [($year.$time[$j]),($year.'12'.'-30')])->count(),
                   'patch' => Vehicle::where('type',2)->whereTime('create_at', [($year.$time[$j]),($year.'12'.'-30')])->count(),
                    'attendance' => Attendance::whereTime('create_at', [($year.$time[$j]),($year.'12'.'-30')])->count(),
                   'login'   => Login::whereTime('create_at', [($year.$time[$j]),($year.'12'.'-30')])->count(),
               ];
           }
       }

      return json(compact('data'));
   }


   /***
    * 清楚缓存
    */
   public function clear()
   {
      Cache::clear();
      return redirect('Index/index')->with('alert', '清除缓存成功');
   }

}




