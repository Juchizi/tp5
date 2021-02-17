<?php

namespace app\admin\controller;

use think\Request;
use think\Db;
//关于我们
class About extends Common
{
    protected $middleware = ['Auth'];

    /**
     * 显示资源列表
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $about = DB::table('about')->where('id',1)->find();

        return view('About/create',['about' =>  $about['count']]);
    }

    /***
     * 修改
     */
    public function update(Request $request)
    {
        $post = $request->param(true);
        DB::table('about')->where('id',1)->update(['count' =>$_POST['info']]);
        return redirect('About/index')->with('success', '操作成功');
    }


}
