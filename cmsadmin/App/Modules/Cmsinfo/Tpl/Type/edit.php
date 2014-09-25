<link href="<?php echo C('THEME_PATH');?>/Css/position.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.js'></script>
<script type="text/javascript">
function chk_editName(){
	var url = "/Cmsinfo/Type/detect_name";
	var t_name = $(":input[name='t_name']").val();
	var t_id = $(":input[name='t_id']").val();
	var t_act = 'edit';
	var chk_res = false;
	$.ajax({
		url:url,
		type:"post",
		dataType:"json",
		data:{t_name:t_name,t_id:t_id,t_act:t_act},
		async:false,
		success:function(res){
			if(res == 'empty'){
				chk_res = true;
			}else{
				alert('警告：“'+res['type_name']+'”已存在，请用其它名称！');
			}
		}
	});
	return chk_res;
}
</script>
<div class="insert_content">
	<form action="/Cmsinfo/Type/update_type" method="post" onsubmit="return chk_editName();">
		<input type="hidden" name="t_id" value="<?php if(!empty($type['id'])): echo $type['id']; endif; ?>">
		<input type="hidden" name="page" value="<?php if(!empty($type_page)): echo $type_page; endif; ?>">
		<div class="pname">
			名称：<input type="text" name="t_name" value="<?php if(!empty($type['type_name'])): echo $type['type_name']; endif; ?>">
		</div>
		<div class="psort">
			顺序：<input type="text" name="t_sort" value="<?php if(!empty($type['sort'])): echo $type['sort']; endif; ?>" size="5">
		</div>
		<div class="pdesc">
			描述：<textarea name="t_desc"><?php if(!empty($type['description'])): echo $type['description']; endif; ?></textarea>
		</div>
		<div class="psubmit">
			<input type="image" src="__PUBLIC__/Images/submit_mini.gif" value="提交" />
		</div>
	</form>
</div>
