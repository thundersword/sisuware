 	$(function(){
 		$("#preview_img").hide();//隐藏图片框
 	})


 	function img_file_change(){
        var filename=$('#input_file').val();
        // console.log(filename);
        $('#file_name').val(getFileName(filename));
       if (filename!=='') { up_image();}
        
    }

	function getFileName(o){
        var pos=o.lastIndexOf("\\");
        return o.substring(pos+1);  
    }

	function click_up_img(){
        $('#input_file').click();
    }

    function up_image(){
        $("#form_upimg").ajaxSubmit(function(message) { 
            // console.log(message);
            $('#hidden_filename').val(message);
            $("#preview_img").show();
            $("#preview_img").attr("src",'/Uploads/Public/uploads/img/news/'+message);
            $("#preview_img").width('300px');
            $("#preview_img").height('300px');

        }); 
    }

    function up_about(){
        $('#jianjie').val($.trim(UE.getEditor('editor').getContent()));
        $('#jianjie_preview').val(UE.getEditor('editor').getPlainTxt());


        $("#form1").ajaxSubmit(function(message) { 
            console.log(message);
            if(message=='y'){
                alert('保存成功！');
                location.reload();
                return;
            }else{
                alert('保存失败！');
                return;
            }


        }); 
    }