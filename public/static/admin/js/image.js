// 使用uploadify的dome
// $(function() {
//     $("#file_upload").uploadify({
//         swf           : swf,
//         uploader      : image_upload_url,
//         buttonText    : '图片上传',
//         fileTypeDesc  : 'Image files',
//         fileObjName   : 'file',
//         fileTypeExts  : '*.gif;*.jpg;*.png',
//         onUploadSuccess : function (file, data, response) {
//             if (response) {
//                 var obj = JSON.parse(data);
//                 $('#upload_org_code_img').attr("src", obj.data);
//                 $('#file_upload_image').attr("value", obj.data);
//                 $('#upload_org_code_img').show();
//             }
//         }
//     });
// });
Dropzone.autoDiscover = false;
$("#file_upload").dropzone({
    url: image_upload_url,
    maxFilesize: 2,
    success: function(res, data) {
        var obj = JSON.parse(data);
        console.log(obj.data);
        $("#file_upload_image").attr("value", obj.data);
    },
    error: function() {
        alert('上传失败!');
    },
    complete: function() {
        $(".dz-progress").css("opacity", 0);
        console.log('The file has been uploaded');
    }
});