<link href="<?php echo C('THEME_PATH');?>/Css/position.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.js'></script>
<script type="text/javascript">
function chk_name(){
	var url = "/Cmsinfo/Position/detect_name";
	var p_name = $(":input[name='p_name']").val();
	var p_act = 'insert';
	var chk_res = false;
	$.ajax({
		url:url,
		type:"post",
		dataType:"json",
		data:{p_name:p_name,p_act:p_act},
		async:false,
		success:function(res){
			if(res == 'empty'){
				chk_res = true;
			}else{
				alert('“'+res['position_name']+'”已存在，请勿重复创建！');
			}
		}
	});
	return chk_res;
}
</script>
<div class="insert_content">
	<form action="/Cmsinfo/Position/add_position" method="post" onsubmit="return chk_name();">
		<div class="pname">名称：<input type="text" name="p_name" value=""></div>
		<div class="psort">顺序：<input type="text" name="p_sort" value="" size="5"></div>
		<div class="pdesc">描述：<textarea name="p_desc"></textarea></div>
		<div class="psubmit"><input type="image" src="__PUBLIC__/Images/submit_mini.gif" value="提交" /></div>
	</form>
</div>
