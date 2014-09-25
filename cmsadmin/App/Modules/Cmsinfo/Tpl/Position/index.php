<?php include_once './App/Tpl/Public/header.php';?>
<style type="text/css">
	.do_operating{float:left; margin:0 0 0 67px;}
	.do_operating a{margin:1px 4px 1px 4px;}
</style>
<script type="text/javascript">
function insert_position(){
	byIframe('/Cmsinfo/Position/insert',{width:350,height:150,title:'新增位置'});
}
function edit_position(id,page){
	byIframe('/Cmsinfo/Position/edit?pid='+id+'&page='+page,{width:350,height:150,title:'编辑位置'});
}
function chk_doing(do_type){
	switch (do_type){
	case 'del':
		if(confirm("警告：确认要删除？")){
			return true;
		}else{
			return false;
		}
		break;
	case 'disable':
		if(confirm("警告：确认禁用吗？")){
			return true;
		}else{
			return false;
		}
		break;
	case 'undisable':
		if(confirm("警告：确认取消禁用吗？")){
			return true;
		}else{
			return false;
		}
		break;
	case 'verify':
		if(confirm("警告：确认启用吗？")){
			return true;
		}else{
			return false;
		}
		break;
	}
}

</script>
<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php'; ?> 
  	<div class="con_right">
  		<div class="location">CMS管理 &gt; 位置管理 </div>
  		<div class="tools">
			<a href="javascript:void(0);" class="btn_blue float cmd100" onclick="insert_position();">新增</a>
		</div>
  		<div>
       		<form action="" method="get">
       			<fieldset class="fieldset">
        			<legend>搜索</legend>
        			<select id="search_style" name="search_style">
        				<option value="">全部分类</option>
        				<option value="1">已启用</option>
        				<option value="2">已禁用</option>
        				<option value="3">未审核</option>
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
				<th align="center" width="150">名称</th>
				<th align="center" width="250">描述</th>
				<th align="center" width="40">排序</th>
				<th align="center" width="70">状态</th>
				<th align="center" width="250">操作</th>
			</tr>
			<?php if(!empty($position_list)): ?>
			<?php foreach($position_list as $k => $v_position): ?>
	        <tr>
	        	<td align="center"><?php echo $v_position['id']; ?></td>
	        	<td align="center"><?php echo $v_position['position_name']; ?></td>
	        	<td align="center"><?php echo $v_position['description']; ?></td>
	        	<td align="center"><?php echo $v_position['sort']; ?></td>
	        	<td align="center"><?php echo $v_position['position_status']; ?></td>
	        	<td align="center">
	        		<div class="do_operating">
	        			<a class="btn_blue float" href="javascript:void(0);" onclick="edit_position(<?php echo $v_position['id']; ?>,<?php echo $position_page; ?>);" <?php if($v_position['id'] == 0): echo 'style="display:none;"'; endif; ?>>编辑</a>
	        			<a class="btn_red float" href="/Cmsinfo/Position/delete?id=<?php echo $v_position['id']; ?>&page=<?php echo $position_page; ?>" onclick="return chk_doing('del');" <?php if($v_position['id'] == 0): echo 'style="display:none;"'; endif; ?>>删除</a>
	        			<a class="btn_blue float" href="/Cmsinfo/Position/verify?id=<?php if(!empty($v_position['id'])): echo $v_position['id']; endif; ?>&page=<?php if(!empty($position_page)): echo $position_page; endif; ?>" onclick="return chk_doing('verify');" <?php if($v_position['status'] != 0 || $v_position['id'] == 0): echo 'style="display:none;"'; endif; ?>>启用</a>
	        			<a class="btn_red float" href="/Cmsinfo/Position/disable?id=<?php if(!empty($v_position['id'])): echo $v_position['id']; endif; ?>&page=<?php if(!empty($position_page)): echo $position_page; endif; ?>" onclick="return chk_doing('disable');" <?php if($v_position['status'] != 1 || $v_position['id'] == 0): echo 'style="display:none;"'; endif; ?>>禁用</a>
	        			<a class="btn_green float" href="/Cmsinfo/Position/undisable?id=<?php if(!empty($v_position['id'])): echo $v_position['id']; endif; ?>&page=<?php if(!empty($position_page)): echo $position_page; endif; ?>" onclick="return chk_doing('undisable');" <?php if($v_position['status'] != 2 || $v_position['id'] == 0): echo 'style="display:none;"'; endif; ?>>取消禁用</a>
	        		</div>
	        	</td>
	        </tr>
	        <?php endforeach; ?>
	        <?php endif; ?>
	    </table>
         <div class="page"><?php if(!empty($page)): echo $page; endif; ?></div>
  	</div>
</div>

<?php include_once './App/Tpl/Public/footer.php';?>
