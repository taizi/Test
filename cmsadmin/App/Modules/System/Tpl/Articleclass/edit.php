<?php include_once './App/Tpl/Public/iframe_header.php';?>
<form  id="edit_form" method="post">
<input name="pos[id]" id="id" type="hidden" value="<?php echo $row['id'];?>">	
<fieldset class="fieldset">
<legend>新增</legend>
<dl><label>名称：</label><input name="pos[name]" id="name" type="text" class="inp200" value="<?php echo $row['name'];?>" /></dl>
<dl><label>关键字：</label><input name="pos[key]" id="key" type="text" class="inp200" value="<?php echo $row['key'];?>" /></dl>
<dl id="sel_type_link"><label>描述：</label>
<textarea name="pos[des]" id="des" cols="" rows="" class="inp200" style="height:60px;"><?php echo $row['des'];?></textarea>
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
	    url: "<?php echo __URL__.'/edit';?>",
	    data:$("#edit_form").serialize(),
	    dataType:'json',
	    success: function(ref){
         if(ref.status<1){ alert(ref.info);
         }else{ parent.window.location.reload(); }
      },error: function(XMLHttpRequest, textStatus, errorThrown){
          alert(XMLHttpRequest.status);
          alert(XMLHttpRequest.readyState);
          alert(textStatus);
      }
   });
}
</script>
<?php include_once './App/Tpl/Public/iframe_footer.php';?>