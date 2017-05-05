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
            $("#preview_img").attr("src",'/Uploads/Public/uploads/img/recruitment/'+message);
            $("#preview_img").width('300px');
            $("#preview_img").height('300px');

        }); 
    }

    function up_product(){
    	if ($.trim($('#name').val())=='' || $.trim($('#num').val())=='' || $.trim($('#duty').val())=='' || $.trim($('#requirement').val())=='') {
    		alert("请填全招聘信息！");
    		return;
    	}


        $("#form_product").ajaxSubmit(function(message) { 
            console.log(message);
            if(message=='y'){
            	alert('添加成功！');
            	$('#btn_reset1').click();
            	$('#btn_reset2').click();
            	$("#preview_img").hide();
            	return;
            }else{
            	alert('添加失败！');
            	return;
            }


        }); 
    }