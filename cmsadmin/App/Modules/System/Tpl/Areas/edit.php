<span class="closecmd" onclick="$.Smarts.closeWindow()">X</span>
<form  id="edit_form" method="post">
<input name="pos[id]" id="id" type="hidden" value="<?php echo $row['id'];?>">	
<fieldset class="fieldset">
<legend>修改分类</legend>
<dl><label>品类名称：</label><input name="pos[name]" id="name" type="text" class="inp200" value="<?php echo $row['name'];?>" /></dl>
<dl><label>C6段码值：</label><input name="pos[c6_code]" id="c6_code" type="text" class="inp200" value="<?php echo $row['c6_code'];?>" /></dl>
<dl style="height:auto;"><label>品类描述：</label><textarea name="pos[desc]" id="desc" class="inp200" style="height:50px;"><?php echo $row['desc'];?></textarea></dl>
<dl style="height:30px;"><label class="float">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a onclick="saveNode()" class="btn_blue float" href="javascript:;">保存 </a></dl>
</fieldset>
</form>