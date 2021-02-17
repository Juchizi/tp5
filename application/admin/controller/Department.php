<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Department as DepartmentModel;
use app\admin\model\Company;
//部门管理
class Department extends Common
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

        $vehicle = DepartmentModel::where($where)
            ->order('create_at', 'desc')
            ->paginate(10, false, ['query' => request()->param()]);


        return view('Department/index',['vehicle' => $vehicle]);
    }

    /***
     * 详情
     */
    public function create(Request $request)
    {
        $post   =   $request->param(true);


        $info   =   DepartmentModel::where('id',$post['id']??'')->find();
        return view('Department/create',['info' => $info]);
    }
    /***
     * 修改
     */
    public function edit(Request $request)
    {
        $post   =   $request->param(true);
        unset($post['/admin/department/edit_html']);
        $post['update_at'] = date('Y-m-d H:i:s');
        DepartmentModel::where('id',$post['id'])->update($post);
        return redirect('Department/index')->with('success', '操作成功');
    }
    /***
     * 添加
     */
    public function save(Request $request)
    {
        $post   =   $request->param(true);
        $post['create_at'] = date('Y-m-d H:i:s');
        $depart = DepartmentModel::create($post);
        $data  ['create_at'] = date('Y-m-d H:i:s');
        $data  ['department_id']   =   $depart->id;
        Company::create($data);
        return redirect('Department/index')->with('success', '操作成功');
    }

    /***
     * 删除
     */
    public function delete(Request $request)
    {
        $post   =   $request->param(true);
        DepartmentModel::where('id',$post['id'])->delete();
        Company::where('department_id',$post['id'])->delete();
        return redirect('Department/index')->with('success', '操作成功');
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
