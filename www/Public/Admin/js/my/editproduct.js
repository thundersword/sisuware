function img_file_change() {    var filename = $('#input_file').val();    // console.log(filename);    $('#file_name').val(getFileName(filename));    if (filename !== '') {        up_image();    }}function getFileName(o) {    var pos = o.lastIndexOf("\\");    return o.substring(pos + 1);}function click_up_img() {    $('#input_file').click();}function up_image() {    $("#form_upimg").ajaxSubmit(function (message) {        // console.log(message);        $('#hidden_filename').val('/Uploads/img/products/' + message);        $("#preview_img").show();        $("#preview_img").attr("src", '/Uploads/img/products/' + message);        $("#preview_img").width('300px');        $("#preview_img").height('300px');    });}function up_product() {    var name = $('#name').val();    if(name == ''){        console.log(name);        alert('软件名称不能为空');        return false;    }    $("#form_product").ajaxSubmit(function (message) {        if (message == 'y') {            alert('修改成功！');            self.location = document.referrer;            return;        } else {            alert('修改失败！');            return;        }    });}