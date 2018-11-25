var initCropperInModal = function(img, input, modal){
    var $image = img;
    var $inputImage = input;
    var $modal = modal;
    var options = {
        aspectRatio: 1, // 纵横比
        viewMode: 2,
        preview: '.img-preview' // 预览图的class名
    };
    // 模态框隐藏后需要保存的数据对象
    var saveData = {};
    var URL = window.URL || window.webkitURL;
    var blobURL;
    $modal.on('show.bs.modal',function () {
        // 如果打开模态框时没有选择文件就点击“打开图片”按钮
        if(!$inputImage.val()){
            $inputImage.click();
        }
    }).on('shown.bs.modal', function () {
        // 重新创建
        $image.cropper( $.extend(options, {
            ready: function () {
                // 当剪切界面就绪后，恢复数据
                if(saveData.canvasData){
                    $image.cropper('setCanvasData', saveData.canvasData);
                    $image.cropper('setCropBoxData', saveData.cropBoxData);
                }
            }
        }));
    }).on('hidden.bs.modal', function () {
        // 保存相关数据
        saveData.cropBoxData = $image.cropper('getCropBoxData');
        saveData.canvasData = $image.cropper('getCanvasData');
        // 销毁并将图片保存在img标签
        $image.cropper('destroy').attr('src',blobURL);
    });
    if (URL) {
        $inputImage.change(function() {
            var files = this.files;
            var file;
            if (!$image.data('cropper')) {
                return;
            }
            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {

                    if(blobURL) {
                        URL.revokeObjectURL(blobURL);
                    }
                    blobURL = URL.createObjectURL(file);

                    // 重置cropper，将图像替换
                    $image.cropper('reset').cropper('replace', blobURL);

                    // 选择文件后，显示和隐藏相关内容
                    $('.img-container').removeClass('hidden');
                    $('.img-preview-box').removeClass('hidden');
                    $('#changeModal .disabled').removeAttr('disabled').removeClass('disabled');
                    $('#changeModal .tip-info').addClass('hidden');

                } else {
                    window.alert('请选择一个图像文件！');
                }
            }
        });
    } else {
        $inputImage.prop('disabled', true).addClass('disabled');
    }
}

var sendPhoto = function() {
    var accesstoken = '';
    var nonce = '';
    var guid = '';
    $.ajax({
        url: image_accesstoken_url,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            accesstoken = data.data.accesstoken;
            nonce = data.data.nonce;
            // 得到PNG格式的dataURL
            var photo = $('#photo').cropper('getCroppedCanvas', {
                width: 300,
                height: 300
            }).toDataURL('image/png');
            var img = $('#photoInput')[0];
            var formData = new FormData();
            formData.append('image', img.files[0]);
            var targetURL = 'https://static-img-bbq.wutnews.net/upload/' + accesstoken + '-' + nonce + '.png';

    $.ajax({
        url: targetURL,                                                                                                                                                                                                                                                  // 要上传的地址
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.error_code == 0) {
                // 将上传的头像的地址填入，为保证不载入缓存加个随机数
                // $('#user-photo').attr('src', '地址?t=' + Math.random());
                $('#user-photo').attr('src', 'https://static-img-bbq.wutnews.net/image/' + data.message + '-100-100.webp');
                $('#changeModal').modal('hide');
                $('#file_upload_image').val(data.message);
            } else {
                alert('上传失败！');
            }
        },
        complete: function() {
            console.log('completed');
        }
    });
        }
    })
    // $('#photo').cropper('getCroppedCanvas',{
    //     width:300,
    //     height:300
    // }).toBlob(function(blob){
    //     // 转化为blob后更改src属性，隐藏模态框
    //     $('#user-photo').attr('src',URL.createObjectURL(blob));
    //     $('#changeModal').modal('hide');
    // });
}

$(function(){
    initCropperInModal($('#photo'),$('#photoInput'),$('#changeModal'));
});

// Dropzone.autoDiscover = false;
// var accesstoken = '';
// var nonce = '';
// var fileFormat = '';
// var errcode = 0;
// $("#file_upload").dropzone({
//     url: image_accesstoken_url,
//     maxFilesize: 2,
//     maxFiles: 1,
//     init: function() {
//         this.on("addedfile", function(file) {
//             console.log(file);
//             console.log(file.height);
//             console.log(file.width);
//             console.log(file.name);
//             console.log(file.type);
//             for(i in file) {
//                 console.log(i);
//             }
//             console.log(file.__proto__);
//             console.log(this.getAcceptedFiles());
//             var index = file.type.lastIndexOf('/');
//             fileFormat = file.type.substring(index + 1, file.type.length);
//             console.log(fileFormat);
//             $.ajax({
//                 url: image_accesstoken_url,
//                 type: 'GET',
//                 dataType: 'json',
//                 success: function(data) {
//                     accesstoken = data.data.accesstoken;
//                     nonce = data.data.nonce;
//                 }
//             })
//         });
//     },
//     sending: function(res, xhr, formData) {
//         console.log(xhr.responseURL);
//         xhr.responseURL = 'http://static-img.wutnews.net/upload/' + accesstoken + '-' + nonce + '.' + formData;
//         console.log(xhr)
//     },
//     accept: function(file, done) {
//         console.log(this.getQueuedFiles());
//         if (file.name == "index.png") {
//             done("Naha, you don't.");
//         }
//         else { 
//             // console.log(this.files[0]);console.log(this.files[0].width);
//             done();
//         }
//     },
//     success: function(res, data) {
//         console.log(res);
//         console.log(data);
//         // var obj = JSON.parse(data);
//         // console.log(obj.data);
//         // $("#file_upload_image").attr("value", obj.data);
//         $('.dz-progress').css('opacity', 0);
//         $('.dz-preview').addClass('dz-success');
//     },
//     error: function() {
//         if(errcode === 1)
//         {
//             alert("请上传正方形图片!");
//             errcode = 0;
//         }
//         else
//         {
//             alert('上传失败!');
//         }
//         $('.dz-progress').css('opacity', 0);
//         $('.dz-preview').addClass('dz-error');
//     },
//     complete: function(res) {
//         console.log(res);
//     }
// });