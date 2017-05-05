// $.ajax({   
//     type: "POST",   
//     url: "some.php",   
//     data: "",   
//     success: function(msg){   
//         alert( "Data Saved: " + msg );   
//     }   
// });  


function selectAll(){
    $("input[type='checkbox']").each(function (i, t) {
        if (t.checked==false) {$(t).click();}   
        // console.log(i,t);
    });


    var ids='';
    $("input[type='checkbox']").each(function (i, t) {
      if (t.checked==true) {ids+=t.value+','}   
    });
    // console.log(ids);

 //    var chk_value =[]; 
  // $('input[name="checkbox_article"]:checked').each(function(){ 
  //  chk_value.push($(this).val()); 
  // }); 
  // console.log(chk_value);
}

function invert_select(){
    $("input[type='checkbox']").each(function (i, t) {
        $(t).click();
        // console.log(i,t);
    });
}

function un_selectAll(){
    $("input[type='checkbox']").each(function (i, t) {
        if (t.checked==true) {$(t).click();}
        // console.log(i,t);
    });

}


function BatcDelete(){
  // var chk_value =[]; 
  var chk_value='';
  $('input[name="checkbox_article"]:checked').each(function(){ 
   // chk_value.push($(this).val());
   chk_value+=$(this).val()+',';
  });
  chk_value=chk_value.substring(0,chk_value.length-1)
  if (chk_value.length==0) {alert('请先选择要删除的产品');return;}
  // console.log(chk_value);

  if (confirm('您确定要删除选中的资质吗？')) {
    $.post("/admin.php/Admin/BatcDeleteAptitude",{'ids':chk_value},function(result){
    // console.log(result);
    // var info=eval('(' + result + ')'); //转化为对象
      if (result=='y') {
        alert('删除成功！');
        location.reload();
        return;
      }else{
        alert('删除失败！');
        return;
      }          
    });
  }
}


function Delete(id){
  if (confirm('您确定要删除这个资质吗？')) {
    $.post("/admin.php/Admin/DeleteAptitude",{'id':id},function(result){
      if (result=='y') {
        alert('删除成功！');
        location.reload();
        return;
      }else{
        alert('删除失败！');
        return;
      }          
    });
  }
}









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
            console.log(message);
            $('#hidden_filename').val(message);
            $("#preview_img").show();
            $("#preview_img").attr("src",'/Uploads/Public/uploads/img/aptitude/'+message);
            $("#preview_img").width('300px');
            $("#preview_img").height('300px');

        }); 
    }

    function up_product(){
      if ($.trim($('#hidden_filename').val())=='') {
        alert("请选择资质图片！");
        return;
      }


        $("#form_product").ajaxSubmit(function(message) { 
            console.log(message);
            if(message=='y'){
              alert('添加成功！');
              location.reload();
              return;
            }else{
              alert('添加失败！');
              return;
            }


        }); 
    }