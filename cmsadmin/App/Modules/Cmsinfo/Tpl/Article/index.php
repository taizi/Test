<?php include_once './App/Tpl/Public/header.php';?>
<style type="text/css">
	.do_operating{float:left; margin:0 0 0 4px;}
	.do_operating a{margin:1px 3px 1px 4px;}
</style>
<script type="text/javascript">
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
	}
}

</script>
<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php';?>
	<div class="con_right">
		<div class="location">CMS管理 &gt; 文章管理 </div>
		<div class="tools">
			<a href="/Cmsinfo/Article/insert?page=<?php if(!empty($news_page)): echo $news_page; endif; ?>" class="btn_blue float cmd100">新增</a>
		</div>
		<div>
       		<form action="/Cmsinfo/Article/index" method="get">
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
			 		<input name="search_name" type="text" value="" />
			 		<input type="submit" value="搜索"/>
	       		</fieldset>
       		</form>
       	</div>
       	<div>
       		<table class="tables">
       			<tr>
       				<th align="center" width="30">编号</th>
       				<th align="center" width="350">标题</th>
				    <th align="center" width="250">类型</th>
				    <th align="center" width="130">日期</th>
				    <th align="center" width="40">排序</th>
				    <th align="center" width="70">状态</th>
				    <th align="center">操作</th>
				</tr>
				<?php if(!empty($news_list)): ?>
				<?php foreach($news_list as $k => $v_news): ?>
				<tr>
					<td align="center"><?php echo $v_news['news_id']; ?></td>
			     	<td align="center"><a href="javascript:void(0);"><?php echo $v_news['news_title']; ?></a></td>
			        <td align="center"><?php echo $v_news['news_type']; ?></td>
			        <td align="center"><?php echo date('Y-m-d h:i',$v_news['details_date']); ?></td>
			        <td align="center"><?php echo $v_news['news_sort']; ?></td>
					<td align="center"><?php echo $v_news['status']; ?></td>
					<td align="center">
						<div class="do_operating">
			            	<a class="btn_blue float" href="/Cmsinfo/Article/edit?id=<?php echo $v_news['news_id']; ?>&page=<?php if(!empty($news_page)): echo $news_page; endif; ?>">编辑</a> 
			           		<a class="btn_red float" href="/Cmsinfo/Article/delete?id=<?php echo $v_news['news_id']; ?>&page=<?php if(!empty($news_page)): echo $news_page; endif; ?>" onclick="return chk_doing('del');">删除</a>
			           		<a class="btn_blue float" href="/Cmsinfo/Article/full?id=<?php if(!empty($v_news['news_id'])): echo $v_news['news_id']; endif; ?>&page=<?php if(!empty($news_page)): echo $news_page; endif; ?>">详情</a>
	        				<a class="btn_red float" href="/Cmsinfo/Article/disable?id=<?php if(!empty($v_news['news_id'])): echo $v_news['news_id']; endif; ?>&page=<?php if(!empty($news_page)): echo $news_page; endif; ?>" onclick="return chk_doing('disable');" <?php if($v_news['news_status'] != 1): echo 'style="display:none;"'; endif; ?>>禁用</a>
	        				<a class="btn_green float" href="/Cmsinfo/Article/undisable?id=<?php if(!empty($v_news['news_id'])): echo $v_news['news_id']; endif; ?>&page=<?php if(!empty($news_page)): echo $news_page; endif; ?>" onclick="return chk_doing('undisable');" <?php if($v_news['news_status'] != 2): echo 'style="display:none;"'; endif; ?>>取消禁用</a>
			           	</div>
			        </td>
			    </tr>
			    <?php endforeach; ?>
			    <?php endif; ?>
			</table>
        	<div class="page"><?php if(!empty($page)): echo $page; endif; ?></div>
     	 </div>
  	</div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>
