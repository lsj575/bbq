/**
 * 通过form表单中提交的数据的方法
 * @param form
 */

function bbq_save(form) {
    var data = $(form).serialize();

    url = $(form).attr('url');

    // js Ajax
    $.post(url, data, function (result) {
        if(result.code == 0) {
            layer.msg(result.msg, {icon:5, time:2000});
        }else if(result.code == 1) {
            self.location = result.data.jump_url;
        }
    }, 'JSON');
}
