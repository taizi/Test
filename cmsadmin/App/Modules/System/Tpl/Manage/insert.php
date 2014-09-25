<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
     <div class="location">系统管理  > 管理员 > 新增</div>
       <div style="padding:10px 0px;">
        <form action="<?php echo __ACTION__;?>" id="save_form" method="post"> 
        <fieldset class="fieldset">
		  <legend>新增管理员</legend>
		  <dl><label>用户帐号：</label><input name="pos[account]" id="account" type="text" class="inp200" /></dl>
		  <dl><label>用户密码：</label><input name="pos[password]" id="password" type="password" class="inp200"/></dl>
		  <dl><label>用户昵称：</label><input name="pos[nickname]" id="nickname" type="text" class="inp200"  value=""/> </dl>
		  <dl><label>用户状态：</label><select name="pos[status]" id="status" class="inp200">
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
						if($("#nickname").attr('value')=='' || $("#account").attr('value')=='' || $("#password").attr('value')=='' ){
							alert('请输入完整的用户信息');
				            return;
						}
						$("#save_form").submit();
				 });
			});
		</script>
  </div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>