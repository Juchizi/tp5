<?php

namespace app\admin\controller;

use app\admin\model\Category;
use think\App;
use think\Db;
use think\facade\View;
use think\Request;

class Categories extends Common
{
   protected $middleware = ['Auth'];

   public function __construct(App $app = null)
   {
      parent::__construct($app);
      $categories = Category::all_categories();
      View::share(compact('categories'));
   }

   /**
    * 显示资源列表
    *
    * @return \think\Response
    */
   public function index()
   {
      return view('Categories/index');
   }

   /**
    * 显示创建资源表单页.
    *
    * @return \think\Response
    */
   public function create()
   {
      return view('Categories/create');
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
      $data['create_at'] = date('Y-m-d H:i:s', time());
      $data['update_at'] = date('Y-m-d H:i:s', time());

      Db::table('categories')->strict(false)->insert($data);
      return redirect('Categories/index');
   }

   /**
    * 显示编辑资源表单页.
    *
    * @param  int $id
    * @return \think\Response
    */
   public function edit($id)
   {
      $cate = Category::with('photo')->find($id);
      return view('categories/edit', compact('cate'));
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
      $data = $request->param();
      Db::table('categories')->where('id', $id)->update($data);
      return redirect('Categories/index');
   }

   /**
    * 删除指定资源
    *
    * @param  int $id
    * @return \think\Response
    */
   public function delete($id)
   {
      $category = Db::table('categories')->find($id);
      Db::table('categories')->where('id', $id)->delete();
      //删除对应的图片
      Db::table('photos')->where('id', $category['photo_id'])->delete();
   }

   /***
    * 排序
    */
   public function sort(Request $request)
   {
      $sort = Category::find($request->param('id'));
      $sort->sort_order = $request->param('sort');
      $sort->save();
   }

   /****
    * 多选删除
    */
   public function delete_all(Request $request)
   {
      $ids = $request->param('check_id');
      foreach ($ids as $id) {
         $category = Db::table('categories')->find($id);
         Db::table('categories')->where('id', $category['id'])->delete();
         Db::table('photos')->where('id', $category['photo_id'])->delete();
      }
   }


}
