<link href="<?php echo C('THEME_PATH');?>/Css/rec_editSort.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.js'></script>

<div class="insert_content">
	<form action="/Recommend/RecommendNews/update_sort" method="post">
		<input type="hidden" name="r_id" value="<?php if(!empty($rec_news['hp_id'])): echo $rec_news['hp_id']; endif; ?>">
		<input type="hidden" name="r_page" value="<?php if(!empty($rec_page)): echo $rec_page; endif; ?>">
		<div class="pname">
			标题：<?php if(!empty($rec_news['n_title'])): echo $rec_news['n_title']; endif; ?>
		</div>
		<div class="pname">
			位置：<?php if(!empty($rec_news['p_name'])): echo $rec_news['p_name']; endif; ?>
		</div>
		<div class="psort">
			排序：<input type="text" name="r_sort" value="<?php if(!empty($rec_news['hp_sort'])): echo $rec_news['hp_sort']; endif; ?>" size="5">
		</div>
		<div class="psubmit">
			<input type="image" src="__PUBLIC__/Images/submit_mini.gif" value="提交" />
		</div>
	</form>
</div>
