<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Vehicle as VehicleModel;
//会议室使用统计
class Room extends Common
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
        //按申请类型（0：审核中）（1：审核通过）（2：审核不通过）
        if ($search = input('get.status')) {
            $where[] = ['status', '=',$search ];
        }
        //按时间查询
        if ($request->has('date') and $request->param('date') != '') {
            $time = explode(" ~ ", $request->param('date'));
            $start = $time[0] . ' 00:00:00';
            $end = $time[1] . ' 23:59:59';
            $where[] = ['create_at', 'between time', [$start, $end]];
        }

        $vehicle = VehicleModel::
        where($where)
            ->where('type',3)
            ->with(['customer'])
            ->order('create_at', 'desc')
            ->paginate(10, false, ['query' => request()->param()]);


        return view('Room/index',['vehicle' => $vehicle]);
    }

    /***
     * 导出
     */
    public function export_customer(Request $request)
    {
        $customers = \config('admin.room');
        $name = '会议室使用统计';
        //模糊查询
        $where = [];
        //按申请类型（0：审核中）（1：审核通过）（2：审核不通过）
        if ($search = input('get.status')) {
            $where[] = ['status', '=',$search ];
        }
        //按时间查询
        if ($request->has('date') and $request->param('date') != '') {
            $time = explode(" ~ ", $request->param('date'));
            $start = $time[0] . ' 00:00:00';
            $end = $time[1] . ' 23:59:59';
            $where[] = ['create_at', 'between time', [$start, $end]];
        }

        $data = VehicleModel::
        where($where)
            ->where('type',3)
            ->with(['customer'])
            ->order('create_at', 'desc')
            ->select();

        $count = VehicleModel::
        where($where)
            ->where('type',3)
            ->with(['customer'])
            ->order('create_at', 'desc')
            ->count();
        foreach ($data as $item) {
            if ($item['status'] == 0) {
                $item['status'] = '审核中';
            } elseif ($item['status'] == 1) {
                $item['status'] = '审核通过';
            } elseif ($item['status'] == 2) {
                $item['status'] = '审核驳回';
            } elseif ($item['status'] == 3) {
                $item['status'] = '已撤回';
            }

            $item['name']   =   $item->customer->name;
            $item['time']   =   $item['str_time'].'至'.$item['end_time'];
        }
        exports($customers, $data, $name,$count);
    }


}
