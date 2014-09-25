<?php include_once './App/Tpl/Public/header.php';?>
<link href="<?php echo C('THEME_PATH');?>/Css/full.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function chk_doing(do_type){
	switch (do_type){
	case 'verify':
		if(confirm("警告：确认审核通过吗？")){
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
	case 'disable':
		if(confirm("警告：确认禁用吗？")){
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
		<div class="location">CMS管理 &gt; 文章详情 </div>
		<div>
			<fieldset class="fieldset">
				<legend>预览</legend>
				<div class="full_content">
					<div class="full_head">
						<div class="head_title">
							<?php if(!empty($news_list)): echo $news_list['news_title']; endif; ?>
						</div>
						<div class="head_content">
							<?php if(!empty($news_list['details_date'])): echo date('Y-m-d H:i',$news_list['details_date']); endif; ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							来源：<?php if(!empty($news_list['details_source'])): echo $news_list['details_source']; endif; ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							作者：<?php if(!empty($news_list['details_author'])): echo $news_list['details_author']; endif; ?>
						</div>
						<div class="head_status">
							<b class="font_red">审核状态：</b><?php if(!empty($news_list['status'])): echo $news_list['status']; endif; ?>
						</div>
						<div class="head_subject">
							<b>导读：</b><?php if(!empty($news_list['details_subject'])): echo $news_list['details_subject']; endif; ?>
						</div>
						<div class="head_summary">
							<b>简介：</b><?php if(!empty($news_list['summary'])): echo $news_list['summary']; endif; ?>
						</div>
					</div>
					<div class="full_body">
						<div class="body_content">
							<b>正文：</b><?php if(!empty($news_list['details_content'])): echo htmlspecialchars_decode($news_list['details_content']); endif; ?>
						</div>
					</div>
					<div class="full_foot">
						<div class="foot_submit">
		        			<form action="/Cmsinfo/Article/verify" method="post" onsubmit="return chk_doing('verify');">
		        				<input type="hidden" name="news_id" value="<?php if(!empty($news_list['news_id'])): echo $news_list['news_id']; endif; ?>">
		        				<input type="hidden" name="news_status" value="<?php if(!empty($news_list['news_status'])): echo $news_list['news_status']; endif; ?>">
		        				<input type="hidden" name="news_page" value="<?php if(!empty($page)): echo $page; endif; ?>">
		        				<input type="image" src="__PUBLIC__/Images/verify_mini.gif" <?php if($news_list['news_status'] != 0): echo 'style="display:none;"'; endif; ?>>
	       					</form>
       					</div>
       					<div class="foot_undisable">
       						<a href="/Cmsinfo/Article/disable?id=<?php if(!empty($news_list['news_id'])): echo $news_list['news_id']; endif; ?>&page=<?php if(!empty($page)): echo $page; endif; ?>" onclick="return chk_doing('disable');" <?php if($news_list['news_status'] != 1): echo 'style="display:none;"'; endif; ?>><img src="__PUBLIC__/Images/disable_mini.gif"></a>
       						<a href="/Cmsinfo/Article/undisable?id=<?php if(!empty($news_list['news_id'])): echo $news_list['news_id']; endif; ?>&page=<?php if(!empty($page)): echo $page; endif; ?>" onclick="return chk_doing('undisable');" <?php if($news_list['news_status'] != 2): echo 'style="display:none;"'; endif; ?>><img src="__PUBLIC__/Images/undisable_mini.gif"></a>
       					</div>
       					<div class="foot_back">
       						<a href="/Cmsinfo/Article/index?page=<?php if(!empty($page)): echo $page; endif; ?>"><img src="__PUBLIC__/Images/back_mini.gif"></a>
       					</div>
       				</div>
				</div>
	       	</fieldset>
       	</div>
  	</div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>
