<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Vehicle as VehicleModel;
//办公用品领用统计
class Work extends Common
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
            ->where('type',0)
            ->with(['customer'])
            ->order('create_at', 'desc')
            ->paginate(10, false, ['query' => request()->param()]);


        return view('Work/index',['vehicle' => $vehicle]);
    }

    /***
     * 导出
     */
    public function export_customer(Request $request)
    {
        $customers = \config('admin.work');
        $name = '办公用品领取列表';
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
            ->where('type',0)
            ->with(['customer'])
            ->order('create_at', 'desc')
            ->select();

        $count = VehicleModel::
        where($where)
            ->where('type',0)
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

            $item['name'] = $item->customer->name;
        }
        exports($customers, $data, $name,$count);
    }


}
