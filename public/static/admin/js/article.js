$(function(){
  article_img_reset(); 
})

function article_img_reset(){
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
}


function article_copyid(id) {
    CopyToClipboard(id);
}

function article_comment(id,url) {
    window.open(url+"?article_id="+id);
}

function article_convert(url,type,id) {
                if (type=='hide') {
                    if ($.trim($('#hide'+id).text())=='展示') {
                        $('#hide'+id).html("隐藏").removeClass("btn-success").addClass("btn-info");
                    }else {
                        $('#hide'+id).html("展示").removeClass("btn-info").addClass("btn-success");
                    }
                }else if (type=='recommend'){
                    if ($.trim($('#recommend'+id).text())=='推荐') {
                        $('#recommend'+id).html("已推荐").removeClass("btn-info").addClass("btn-disabled");
                    }else {
                        $('#recommend'+id).html("推荐").removeClass("btn-success").addClass("btn-info");
                    }
                }else {
                    if ($.trim($('#top'+id).text())=='置顶') {
                        $('#top'+id).html("取消置顶").removeClass("btn-info").addClass("btn-success");
                    }else {
                        $('#top'+id).html("置顶").removeClass("btn-success").addClass("btn-info");
                    }
                }


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
                            
            }
            else {
                alert("错误: " + data['message']);
            }
        }
    });
}

//复制
function CopyToClipboard (input) {
var textToClipboard = input;

var success = true;
if (window.clipboardData) { // Internet Explorer
    window.clipboardData.setData ("Text", textToClipboard);
}
else {
        // create a temporary element for the execCommand method
    var forExecElement = CreateElementForExecCommand (textToClipboard);

            /* Select the contents of the element 
                (the execCommand for 'copy' method works on the selection) */
    SelectContent (forExecElement);

    var supported = true;

        // UniversalXPConnect privilege is required for clipboard access in Firefox
    try {
        if (window.netscape && netscape.security) {
            netscape.security.PrivilegeManager.enablePrivilege ("UniversalXPConnect");
        }

            // Copy the selected content to the clipboard
            // Works in Firefox and in Safari before version 5
        success = document.execCommand ("copy", false, null);
    }
    catch (e) {
        success = false;
    }

        // remove the temporary element
    document.body.removeChild (forExecElement);
}

if (success) {
    alert ("ID复制成功!");
}
else {
    alert ("您的游览器不支持复制!");
}
}

function CreateElementForExecCommand (textToClipboard) {
var forExecElement = document.createElement ("div");
    // place outside the visible area
forExecElement.style.position = "absolute";
forExecElement.style.left = "-10000px";
forExecElement.style.top = "-10000px";
    // write the necessary text into the element and append to the document
forExecElement.textContent = textToClipboard;
document.body.appendChild (forExecElement);
    // the contentEditable mode is necessary for the  execCommand method in Firefox
forExecElement.contentEditable = true;

return forExecElement;
}

function SelectContent (element) {
    // first create a range
var rangeToSelect = document.createRange ();
rangeToSelect.selectNodeContents (element);

    // select the contents
var selection = window.getSelection ();
selection.removeAllRanges ();
selection.addRange (rangeToSelect);
}
