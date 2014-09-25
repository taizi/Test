<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
     <div class="location">系统管理  > 结点管理  > 编辑</div>
       <div style="padding:10px 0px;">
        <form action="<?php echo __URL__.'/edit/id/'.$row['id'];?>" id="save_form" method="post"> 
         <input name="pos[id]" type="hidden" value="<?php echo $row['id'];?>">   
         <fieldset class="fieldset">
		  <legend>编辑结点</legend>
		  <dl><label>名称：</label><input name="pos[name]" id="name" type="text" value="<?php echo $row['name'];?>" class="inp200"/></dl>
		  <dl><label>标题：</label><input name="pos[title]" id="title" type="text" value="<?php echo $row['title'];?>" class="inp200"/></dl>
		  <dl><label>排序：</label><input name="pos[sort]" id="sort" type="text" value="<?php echo $row['sort'];?>" class="inp200"/> </dl>
		  <dl><label>状态：</label><select name="pos[status]" id="status" class="inp200">
		  <option value="1" <?php echo !empty($row['status'])?'selected':'';?>>开启</option>
		  <option value="0" <?php echo empty($row['status'])?'selected':'';?>>禁用</option>
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