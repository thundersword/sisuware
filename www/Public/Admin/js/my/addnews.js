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

    function up_news(){
        $('#news_content').val($.trim(UE.getEditor('editor').getContent()));
        // alert($('#news_content').val());
        if ($.trim($('#news_title').val())=='' || $.trim($('#news_content').val())=='' ) {
            alert("请填全新闻信息！");
            return;
        }
        $('#preview').val(UE.getEditor('editor').getPlainTxt());
        
        $("#form_news").ajaxSubmit(function(message) { 
            console.log(message);
            if(message=='y'){
                alert('发布成功！');
                $('#btn_reset1').click();
                UE.getEditor('editor').setContent('')
                $("#preview_img").hide();
                return;
            }else{
                alert('发布失败！');
                return;
            }


        }); 
    }