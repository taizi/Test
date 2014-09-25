<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
     <h1> 系统管理  > 管理员组  > 编辑</h1>
      <form action="<?php echo __URL__.'/edit/id/'.$row['id'];?>" id="save_form" method="post"> 
       <input name="pos[id]" type="hidden" value="<?php echo $row['id'];?>">        
       <fieldset class="fieldset">
		  <legend>编辑管理员</legend>
		  <dl><label>名称：</label><input name="pos[name]" id="name" type="text" class="inp200" value="<?php echo $row['name'];?>"/></dl>
		  <dl><label>状态：</label><select name="pos[status]" id="status" class="inp200">
		  <option value="1" <?php echo !empty($row['status'])?'selected':'';?>>开启</option>
		  <option value="0" <?php echo empty($row['status'])?'selected':'';?>>禁用</option>
		  </select>
		  </dl>
		  <dl style="height:30px;"><label class="float">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><a id="save_cmd" class="btn_blue float" href="javascript:;"> 保存 </a></dl>
		</fieldset>
		</form>
  </div>
</div>
<script type="text/javascript">
		$(document).ready(function(){
			 $("#save_cmd").click(function(){
					if($("#name").attr('value')=='' || $("#title").attr('value')==''){
						alert('请输入完整的信息');
			            return;
					}
					$("#save_form").submit();
			 });
		});
</script>
<?php include_once './App/Tpl/Public/footer.php';?>