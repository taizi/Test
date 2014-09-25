<link href="<?php echo C('THEME_PATH');?>/Css/position.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.js'></script>
<script type="text/javascript">
function chk_name(){
	var url = "/Cmsinfo/Position/detect_name";
	var p_name = $(":input[name='p_name']").val();
	var p_id = $(":input[name='p_id']").val();
	var p_act = 'edit';
	var chk_res = false;
	$.ajax({
		url:url,
		type:"post",
		dataType:"json",
		data:{p_name:p_name,p_act:p_act,p_id:p_id},
		async:false,
		success:function(res){
			if(res == 'empty'){
				chk_res = true;
			}else{
				alert('警告：“'+res['position_name']+'”已存在，请用其它名称！');
			}
		}
	});
	return chk_res;
}
</script>
<div class="insert_content">
	<form action="/Cmsinfo/Position/update_position" method="post" onsubmit="return chk_name();">
		<input type="hidden" name="p_id" value="<?php if(!empty($position['id'])): echo $position['id']; endif; ?>">
		<input type="hidden" name="page" value="<?php if(!empty($position_page)): echo $position_page; endif; ?>">
		<div class="pname">
			名称：<input type="text" name="p_name" value="<?php if(!empty($position['position_name'])): echo $position['position_name']; endif; ?>">
		</div>
		<div class="psort">
			顺序：<input type="text" name="p_sort" value="<?php if(!empty($position['sort'])): echo $position['sort']; endif; ?>" size="5">
		</div>
		<div class="pdesc">
			描述：<textarea name="p_desc"><?php if(!empty($position['description'])): echo $position['description']; endif; ?></textarea>
		</div>
		<div class="psubmit">
			<input type="image" src="__PUBLIC__/Images/submit_mini.gif" value="提交" />
		</div>
	</form>
</div>
