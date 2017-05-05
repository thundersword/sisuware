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
  if (chk_value.length==0) {alert('请先选择要删除的案例');return;}
  // console.log(chk_value);

  if (confirm('您确定要删除选中的案例吗？')) {
    $.post("/admin.php/Admin/BatcDeleteCase",{'ids':chk_value},function(result){
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
  if (confirm('您确定要删除这个案例吗？')) {
    $.post("/admin.php/Admin/DeleteCase",{'id':id},function(result){
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





