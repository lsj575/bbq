$(function(){
  console.log("fuck");
  var imgs=$(".article-imgs");
  for(var i=imgs.length-1;i>=0;i--){
    var img=$(imgs[i]).find('img');
    var length=img.length;
    var row=Math.ceil(length/3);
    var line=Math.ceil(length/row);
    var widthM=16*line>26?26:16*line; 
    var widthX=(widthM/line).toFixed(2)-2;
    var margin="0.5rem";
    img.css({
      width:widthX+'rem',
      height:widthX+'rem',
      margin:margin
    });
  };
})


function article_convert(url,type,id) {
    var data = {
        'type' : type,
        'id'   : id
    }
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success : function(data) {
            data = JSON.parse(data);

            if (data['status'] == 200 ) {
                if (type=='hide') {
                    if ($.trim($('#hide').text())=='展示') {
                        $('#hide').html("隐藏");
                    }else {
                        $('#hide').html("展示");
                    }
                }else if (type=='recommend'){
                    if ($.trim($('#recommend').text())=='推荐') {
                        $('#recommend').html("已推荐");
                    }else {
                        $('#recommend').html("推荐");
                    }
                }else {
                    if ($.trim($('#top').text())=='置顶') {
                        $('#top').html("取消置顶");
                    }else {
                        $('#top').html("置顶");
                    }
                }
            
            }
            else {
                alert("错误: " + data['message']);
            }
        }
    });
}
