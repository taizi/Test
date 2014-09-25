<?php include_once './App/Tpl/Public/iframe_header.php';?>
<form  id="edit_form" method="post">
<input name="pos[id]" id="id" type="hidden" value="<?php echo $row['id'];?>">	
<fieldset class="fieldset">
<legend>新增</legend>
<dl><label>名称：</label><input name="pos[name]" id="name" type="text" class="inp200" value="<?php echo $row['name'];?>" /></dl>
<dl><label>类型：</label><select name="pos[type]" id="types">
 <option value="1" <?php if($row['type']==1){ echo 'selected';}?>>普通</option>
 <option value="2" <?php if($row['type']==2){ echo 'selected';}?>>COD</option>
 <option value="3" <?php if($row['type']==3){ echo 'selected';}?>>邮资到付</option>
</select></dl>
<dl id="sel_type_link"><label>说明：</label>
<textarea name="pos[remark]" id="remark" cols="" rows="" class="inp200" style="height:60px;"><?php echo $row['remark'];?></textarea>
<dl style="height:30px;"><label class="float">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a onclick="saveDelivery()" class="btn_blue float" href="javascript:;">保存 </a></dl>
</fieldset>
</form>

<script>
function saveDelivery(){
	if($("#edit_form #name").attr("value")==''){
		alert('请输入名称');
        return false;
    }
	if($("#edit_form #remark").attr("value")==''){
		alert('请输入说明');
        return false;
    }
	$.ajax({
        type: "POST",
	    url: "<?php echo __URL__.'/edit';?>",
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