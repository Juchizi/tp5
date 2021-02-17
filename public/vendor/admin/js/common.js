<!--错误提示信息-->
if (count($errors) > 0) {
   layer.msg('{{$errors->first()}}', {
      icon: 5,
      time: 2000 //2秒关闭（如果不配置，默认是3秒）
   });
}


if (session('success')) {
   layer.msg("{{session('success')}}", {
      icon: 5,
      time: 2500 //2秒关闭（如果不配置，默认是3秒）
   });
}

