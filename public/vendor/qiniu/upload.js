//设置事件绑定按钮
$(".upload_img").click(function () {
   $("#image_upload").click();
   return false;
});


//文件上传
var opts = {
   url: "/admin/Uploadfile/upload",
   type: "POST",
   beforeSend: function () {
      $("#loading").attr('class', 'fa fa-spin fa-spinner');
   },
   success: function (result, status, xhr) {
      if (result.status == 0) {
         alert(result.msg);
         return false;
      }

      $("input[name='photo_id']").val(result.photo_id);
      $("#img_show").attr("src", result.msg);
      $("#loading").attr('class', 'fa fa-cloud-upload');
   },
   error: function (result, status, errorThrown) {
      alert('文件上传失败');
      $("#loading").attr('class', 'fa fa-upload');
   }
};

$('#image_upload').fileUpload(opts);