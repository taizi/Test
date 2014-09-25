<?php include_once './App/Tpl/Public/header.php';?>
<script type="text/javascript">
function chk_disable(){
	if(confirm("警告：确认禁用吗？")){
		return true;
	}else{
		return false;
	}
}
function chk_undisable(){
	if(confirm("警告：确认取消禁用吗？")){
		return true;
	}else{
		return false;
	}
}
function chk_verify(){
	if(confirm("警告：确认启用吗？")){
		return true;
	}else{
		return false;
	}
}

</script>
<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php';?> 
  	<div class="con_right">
  		<div class="location">CMS管理 &gt; 位置审核 </div>
  		<div>
       		<form action="/Cmsinfo/AuditPosition/index" method="get">
       			<fieldset class="fieldset">
        			<legend>搜索</legend>
        			<select id="search_style" name="search_style">
        				<option value="">全部分类</option>
        				<option value="3">未审核</option>
        				<option value="1">已启用</option>
        				<option value="2">已禁用</option>
					</select>
		 			名称：
		 			<input type="text" name="search_name" value="" />
		 			<input type="submit" value="搜索" />
             	</fieldset>
             </form>
         </div>
		<table class="tables">
			<tr>
				<th align="center" width="30">编号</th>
				<th align="center">名称</th>
				<th align="center" width="500">描述</th>
				<th align="center" width="70">状态</th>
				<th align="center" width="250">操作</th>
			</tr>
			<?php if(!empty($position_list)): ?>
			<?php foreach($position_list as $k => $v_position): ?>
	        <tr>
	        	<td align="center"><?php echo $v_position['id']; ?></td>
	        	<td align="center"><?php echo $v_position['position_name']; ?></td>
	        	<td align="center"><?php echo $v_position['description']; ?></td>
	        	<td align="center"><?php echo $v_position['position_status']; ?></td>
	        	<td align="center">
	        		<a class="btn_blue float" href="/Cmsinfo/AuditPosition/verify?id=<?php if(!empty($v_position['id'])): echo $v_position['id']; endif; ?>&page=<?php if(!empty($position_page)): echo $position_page; endif; ?>" onclick="return chk_verify();" <?php if($v_position['status'] != 0 || $v_position['id'] == 0): echo 'style="display:none;"'; endif; ?>>启用</a>
	        		<a class="btn_red float" href="/Cmsinfo/AuditPosition/disable?id=<?php if(!empty($v_position['id'])): echo $v_position['id']; endif; ?>&page=<?php if(!empty($position_page)): echo $position_page; endif; ?>" onclick="return chk_disable();" <?php if($v_position['status'] == 2 || $v_position['id'] == 0): echo 'style="display:none;"'; endif; ?>>禁用</a>
	        		<a class="btn_green float" href="/Cmsinfo/AuditPosition/undisable?id=<?php if(!empty($v_position['id'])): echo $v_position['id']; endif; ?>&page=<?php if(!empty($position_page)): echo $position_page; endif; ?>" onclick="return chk_undisable();" <?php if($v_position['status'] != 2 || $v_position['id'] == 0): echo 'style="display:none;"'; endif; ?>>取消禁用</a>
	        	</td>
	        </tr>
	        <?php endforeach; ?>
	        <?php endif; ?>
	    </table>
	 	<div class="page"><?php if(!empty($page)): echo $page; endif; ?></div>
  	</div>
</div>

<?php include_once './App/Tpl/Public/footer.php';?>
