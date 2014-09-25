<link href="<?php echo C('THEME_PATH');?>/Css/position.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.js'></script>
<script type="text/javascript">
function chk_name(){
	var url = "/Cmsinfo/Type/detect_name";
	var t_name = $(":input[name='t_name']").val();
	var t_act = 'insert';
	var chk_res = false;
	$.ajax({
		url:url,
		type:"post",
		dataType:"json",
		data:{t_name:t_name,t_act:t_act},
		async:false,
		success:function(res){
			if(res == 'empty'){
				chk_res = true;
			}else{
				alert('“'+res['type_name']+'”已存在，请用其它名称！');
			}
		}
	});
	return chk_res;
}
</script>
<div class="insert_content">
	<form action="/Cmsinfo/Type/add_type" method="post" onsubmit="return chk_name();">
		<div class="pname">名称：<input type="text" name="t_name" value=""></div>
		<div class="psort">顺序：<input type="text" name="t_sort" value="" size="5"></div>
		<div class="pdesc">描述：<textarea name="t_desc"></textarea></div>
		<div class="psubmit"><input type="image" src="__PUBLIC__/Images/submit_mini.gif" value="提交" /></div>
	</form>
</div>
