<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Company as CompanyModel;
//打卡范围设置
class Company extends Common
{
    protected $middleware = ['Auth'];

    /**
     * 显示资源列表
     * @return \think\Response
     */
    public function index(Request $request)
    {

        $post   =   $request->param(true);
        $info = CompanyModel::where('department_id',$post['id'])->find();

        return view('Company/create',['info' => $info]);
    }

    /***
     * 修改
     */
    public function update(Request $request)
    {
        $post = $request->param(true);

        $post['working_day'] = implode(',',$post['working']);
        $post['legal']   = $post['legal']??''=='ON'?0:1;
        unset($post['/admin/company/update_html']);
        unset($post['working']);
        CompanyModel::where('id',$post['id'])->update($post);
        return redirect('Department/index')->with('success', '操作成功');
    }


}
