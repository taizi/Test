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
  		<div class="location">CMS管理 &gt; 类型审核 </div>
  		<div>
       		<form action="/Cmsinfo/AuditType/index" method="get">
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
			<?php if(!empty($type_list)): ?>
			<?php foreach($type_list as $k => $v_type): ?>
	        <tr>
	        	<td align="center"><?php echo $v_type['id']; ?></td>
	        	<td align="center"><?php echo $v_type['type_name']; ?></td>
	        	<td align="center"><?php echo $v_type['description']; ?></td>
	        	<td align="center"><?php echo $v_type['type_status']; ?></td>
	        	<td align="center">
	        		<a class="btn_blue float" href="/Cmsinfo/AuditType/verify?id=<?php if(!empty($v_type['id'])): echo $v_type['id']; endif; ?>&page=<?php if(!empty($type_page)): echo $type_page; endif; ?>" onclick="return chk_verify();" <?php if($v_type['status'] != 0 || $v_type['id'] == 0): echo 'style="display:none;"'; endif; ?>>启用</a>
	        		<a class="btn_red float" href="/Cmsinfo/AuditType/disable?id=<?php if(!empty($v_type['id'])): echo $v_type['id']; endif; ?>&page=<?php if(!empty($type_page)): echo $type_page; endif; ?>" onclick="return chk_disable();" <?php if($v_type['status'] == 2 || $v_type['id'] == 0): echo 'style="display:none;"'; endif; ?>>禁用</a>
	        		<a class="btn_green float" href="/Cmsinfo/AuditType/undisable?id=<?php if(!empty($v_type['id'])): echo $v_type['id']; endif; ?>&page=<?php if(!empty($type_page)): echo $type_page; endif; ?>" onclick="return chk_undisable();" <?php if($v_type['status'] != 2 || $v_type['id'] == 0): echo 'style="display:none;"'; endif; ?>>取消禁用</a>
	        	</td>
	        </tr>
	        <?php endforeach; ?>
	        <?php endif; ?>
	    </table>
	 	<div class="page"><?php if(!empty($page)): echo $page; endif; ?></div>
  	</div>
</div>

<?php include_once './App/Tpl/Public/footer.php';?>
