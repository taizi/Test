<span class="closecmd" onclick="$.Smarts.closeWindow()">X</span>
<form  id="add_form" method="post">
<input name="pos[pid]" id="pid" type="hidden" value="<?php echo $pid;?>">	
<fieldset class="fieldset">
<legend>新增分类</legend>
<dl><label>品类名称：</label><input name="pos[name]" id="name" type="text" class="inp200" value="" /></dl>
<dl><label>C6段码值：</label><input name="pos[c6_code]" id="c6_code" type="text" class="inp200" value="" /></dl>
<dl style="height:auto;"><label>品类描述：</label><textarea name="pos[desc]" id="desc" class="inp200" style="height:50px;"></textarea></dl>
<dl style="height:30px;"><label class="float">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a onclick="addNode()" class="btn_blue float" href="javascript:;">保存 </a></dl>
</fieldset>
</form>
