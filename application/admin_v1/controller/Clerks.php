<?php

namespace app\admin\controller;

use app\admin\model\Clerk;
use think\Controller;
use think\Request;

class Clerks extends Common
{
   /**
    * 显示资源列表
    *
    * @return \think\Response
    */
   public function index()
   {
      $zhiweis = config('admin.zhiwei');
      $clerks = Clerk::order('create_at', 'desc')->select();
      return view('Clerks/index', compact('zhiweis', 'clerks'));
   }

   /**
    * 保存新建的资源
    *
    * @param  \think\Request $request
    * @return \think\Response
    */
   public function save(Request $request)
   {
      $data = $request->param();
      $data['create_at'] = date('Y-m-d H:i:s');
      Clerk::create($data);

      return redirect('Clerks/index')->with('success', '新增员工成功');
   }

   /**
    * 保存更新的资源
    *
    * @param  \think\Request $request
    * @param  int $id
    * @return \think\Response
    */
   public function update(Request $request, $id)
   {
      Clerk::update($request->param());
      return redirect('Clerks/index')->with('success', '编辑员工成功');
   }

   /**
    * 删除指定资源
    *
    * @param  int $id
    * @return \think\Response
    */
   public function delete($id)
   {
      Clerk::destroy($id);
   }

   /***
    * 多选删除
    */
   public function delete_all(Request $request)
   {
      Clerk::destroy($request->param('check_id'));
   }


   /***
    * 改变属性
    */
   public function change(Request $request)
   {
      $clerk = Clerk::find($request->param('id'));
      $attr = $request->param('attr');
      $clerk->$attr = !$clerk->$attr;
      $clerk->save();
   }


}
