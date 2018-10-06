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
var errcode = 0;
var index = 0;
$("#file_upload").dropzone({
    url: image_upload_url,
    maxFilesize: 2,
    init: function() {
        this.on("addedfile", function(file) { console.log(file) });
    },
    accept: function(file, done) {
        console.log(file.width);
        if (file.name != "index.png") {
          done("Naha, you don't.");
        }
        else { console.log(this.files[0]);console.log(this.files[0].width);done(); }
      },
    // accept: function(file, done) {
    //     console.log(file);
    //     console.log(file.status+' '+file.type+' '+file.fileHeight+' '+file.size);
    //     console.log.toString();
    //     if(file.height != file.width)
    //     {
    //         // console.log('www');
    //         errcode = 1;
    //         done("Naha, you don't");  
    //     }
    //     else
    //     {
    //         // console.log('upload');
    //         done();
    //     }
    // },
    success: function(res, data) {
        var obj = JSON.parse(data);
        console.log(obj.data);
        $("#file_upload_image").attr("value", obj.data);
        $('.dz-progress').css('opacity', 0);
        $('.dz-preview').eq(index).addClass('dz-success');
    },
    error: function() {
        if(errcode === 1)
        {
            alert("请上传正方形图片!");
            errcode = 0;
        }
        else
        {
            alert('上传失败!');
        }
        $('.dz-progress').css('opacity', 0);
        $('.dz-preview').eq(index).addClass('dz-error');
    },
    complete: function() {
        console.log(errcode);
        index++;
    }
});