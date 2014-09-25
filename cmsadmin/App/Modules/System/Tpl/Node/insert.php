<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
      <div class="location">系统管理  > 结点管理  > 新增</div>
       <div style="padding:10px 0px;">
       <form action="<?php echo __URL__.'/insert/id/'.$row['id'];?>" id="save_form" method="post"> 
              <input name="pos[pid]" type="hidden" value="<?php echo $row['id'];?>" />
              <input name="pos[level]" type="hidden" value="<?php echo $row['level']+1;?>" /> 
         <fieldset class="fieldset">
		  <legend>新增结点</legend>
		  <dl><label>名称：</label><input name="pos[name]" id="name" type="text" value="" class="inp200"/></dl>
		  <dl><label>标题：</label><input name="pos[title]" id="title" type="text" value="" class="inp200"/></dl>
		  <dl><label>排序：</label><input name="pos[sort]" id="sort" type="text" value="" class="inp200"/> </dl>
		  <dl><label>状态：</label><select name="pos[status]" id="status" class="inp200">
		  <option value="1" >开启</option>
		  <option value="0" >禁用</option>
		  </select>
		  </dl>
		  <dl style="height:30px;"><label class="float">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a id="save_cmd" class="btn_blue float" href="javascript:;"> 保存 </a></dl>
		</fieldset>
		</form>
       </div>
        <script type="text/javascript">
			$(document).ready(function(){
				 $("#save_cmd").click(function(){
						if($("#name").attr('value')=='' || $("#title").attr('value')=='' || $("#sort").attr('value')=='' ){
							alert('请输入完整的信息');
				            return;
						}
						$("#save_form").submit();
				 });
			});
		</script>
  </div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>