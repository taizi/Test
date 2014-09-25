<link href="<?php echo C('THEME_PATH');?>/Css/position.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.js'></script>

<div class="insert_content">
	<form action="/Recommend/RecommendNews/insert" method="post">
		<input type="hidden" name="act" value="position_pass">
		<div class="pname">
			<select name="pid">
				<option value="">=请选择=</option>
				<?php if(!empty($p_list)): ?>
				<?php foreach($p_list as $k => $v_p): ?>
				<option value="<?php echo $v_p['id']; ?>"><?php echo $v_p['position_name']; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="psubmit">
			<input type="image" src="__PUBLIC__/Images/submit_mini.gif" value="提交" />
		</div>
	</form>
</div>
