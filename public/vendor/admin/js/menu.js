//进入页面检查是否有缓存
if (window.localStorage.getItem('url')) {

   if (window.localStorage.getItem('id') == -1) {
      $('#main').addClass('active');
   } else {
      var url = window.localStorage.getItem('url');
      var id = 'menus' + window.localStorage.getItem('id');
      $('iframe').attr('src', url);

      // $('.' + id).parents('ul').show();
      // $('.' + id).parents('ul').prev().addClass('active');
      // $('.' + id).parents('ul').prev().children('span').addClass('sidebar-nav-sub-ico-rotate');
      // $('.' + id).addClass('sub-active');
   }
}

//js跳转iframe标签
$('.param').click(function () {
   //当前点击页面写入浏览器缓存
   window.localStorage.setItem('url', $(this).data('url'));
   window.localStorage.setItem('id', $(this).data('id'));

   $('iframe').attr('src', $(this).data('url'));


   // var id = $(this).data('id');
   // if (id == -1) {
   //    $(this).addClass('active');//增加点击样式
   // } else {
   //    $(this).addClass('active');//增加点击样式
   // }

   $(this).parent('li').addClass('active').siblings('li').removeClass('active');   //自己添加文字样式
   $(this).parents('ul').parent('li').addClass('active').siblings('li').removeClass('active');
});

//点击消息列表跳转具体页面
// $('.check_jump').click(function () {
//
//    //当前点击页面写入浏览器缓存
//    window.localStorage.setItem('url', $(this).data('url'));
//    window.localStorage.setItem('id', $(this).data('id'));
//    var id = 'menus' + window.localStorage.getItem('id');
//    $('#check_message').removeClass('am-active');
//    $('iframe').attr('src', $(this).data('url'));
//    $('.' + id).parents('ul').show();
//    $('.' + id).parents('ul').prev().addClass('active');
//    $('.' + id).parents('ul').prev().children('span').addClass('sidebar-nav-sub-ico-rotate');
//    $('.' + id).addClass('sub-active');
//
//
//    $('.' + id).parent('li').siblings().find('.param').removeClass('sub-active');//同辈移除样式
//    $('.' + id).parents('li').siblings().find('a').removeClass('sub-active active');
//    $('.' + id).parents('li').siblings().find('.sidebar-nav-sub-ico').removeClass('sidebar-nav-sub-ico-rotate');
//    $('.' + id).parents('li').siblings().find('ul').hide();
//
// });

//退出清除缓存
$('.logout').click(function () {
   localStorage.clear();
});
