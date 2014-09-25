<?php include_once './App/Tpl/Public/iframe_header.php';?>
<form  id="edit_form" method="post">
<fieldset class="fieldset">
<legend>新增</legend>
<dl id="sel_type_link"><label>描述：</label>
<select id="sid" name="pos[sid]">
<option value="0">一级分类</option>
</select>
</dl>
<dl><label>名称：</label><input name="pos[name]" id="name" type="text" class="inp200" value="" /></dl>
<dl style="height:30px;"><label class="float">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a onclick="savePage()" class="btn_blue float" href="javascript:;">保存 </a></dl>
</fieldset>
</form>
<script>
function savePage(){
	if($("#edit_form #name").attr("value")==''){
		alert('请输入名称');
        return false;
    }
	
	$.ajax({
        type: "POST",
	    url: "<?php echo __URL__.'/insert';?>",
	    data:$("#edit_form").serialize(),
	    dataType:'json',
	    success: function(ref){
         if(ref.status<1){
             alert(ref.info);
         }else{
        	 parent.window.location.reload();
	     }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
          alert(XMLHttpRequest.status);
          alert(XMLHttpRequest.readyState);
          alert(textStatus);
      }
   });
}
</script>
<?php include_once './App/Tpl/Public/iframe_footer.php';?>