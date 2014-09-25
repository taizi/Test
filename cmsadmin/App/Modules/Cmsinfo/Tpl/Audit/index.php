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

</script>
<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php';?> 
  	<div class="con_right">
  		<div class="location">CMS管理 &gt; 文章审核 </div>
  		<div>
       		<form action="/Cmsinfo/Audit/index" method="get">
       			<fieldset class="fieldset">
        			<legend>搜索</legend>
        			<select id="search_style" name="search_style">
        				<option value="">全部分类</option>
        				<option value="3">未审核</option>
        				<option value="1">已启用</option>
        				<option value="2">已禁用</option>
					</select>
		 			<select id="search_filter" name="search_filter">
		 				<option value="">=请选择=</option>
		 				<option value="num">搜编号</option>
		 				<option value="name">搜标题</option>
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
				<th align="center">标题</th>
				<th align="center" width="130">日期</th>
				<th align="center" width="70">状态</th>
				<th align="center" width="250">操作</th>
			</tr>
			<?php if(!empty($news_list)): ?>
			<?php foreach($news_list as $k => $v_list): ?>
	        <tr>
	        	<td align="center"><?php echo $v_list['news_id']; ?></td>
	        	<td align="center"><?php echo $v_list['news_title']; ?></td>
	        	<td align="center"><?php echo date("Y-m-d H:i",$v_list['details_date']); ?></td>
	        	<td align="center"><?php echo $v_list['status']; ?></td>
	        	<td align="center">
	        		<a class="btn_blue float" href="/Cmsinfo/Audit/full?id=<?php if(!empty($v_list['news_id'])): echo $v_list['news_id']; endif; ?>&page=<?php if(!empty($news_page)): echo $news_page; endif; ?>">详情</a>
	        		<a class="btn_red float" href="/Cmsinfo/Audit/disable?id=<?php if(!empty($v_list['news_id'])): echo $v_list['news_id']; endif; ?>&page=<?php if(!empty($news_page)): echo $news_page; endif; ?>" onclick="return chk_disable();" <?php if($v_list['news_status'] == 2): echo 'style="display:none;"'; endif; ?>>禁用</a>
	        		<a class="btn_green float" href="/Cmsinfo/Audit/undisable?id=<?php if(!empty($v_list['news_id'])): echo $v_list['news_id']; endif; ?>&page=<?php if(!empty($news_page)): echo $news_page; endif; ?>" onclick="return chk_undisable();" <?php if($v_list['news_status'] != 2): echo 'style="display:none;"'; endif; ?>>取消禁用</a>
	        	</td>
	        </tr>
	        <?php endforeach; ?>
	        <?php endif; ?>
	    </table>
	 	<div class="page"><?php if(!empty($page)): echo $page; endif; ?></div>
  	</div>
</div>

<?php include_once './App/Tpl/Public/footer.php';?>
