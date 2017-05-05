 	$(function(){

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
        if ($.trim($('#news_title').val())=='' || $.trim($('#news_content').val())=='' ) {
            alert("请填全新闻信息！");
            return;
        }

        $("#form_news").ajaxSubmit(function(message) { 
            console.log(message);
            if(message=='y'){
                alert('修改成功！');
                self.location=document.referrer;
                return;
            }else{
                alert('修改失败！');
                return;
            }


        }); 
    }