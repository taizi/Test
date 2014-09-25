<?php include_once './App/Tpl/Public/header.php';?>
<style type="text/css">
	#hold_pic{display:none;}
</style>
<script type="text/javascript">
function checkType(){
	var source = $("#sou_type").find("option:selected").text();
	if(source == '======全部分类======'){
		alert('请选择采集来源！');
		return false;
	}else{
		$("input:submit[name='submit']").hide();
		$("#hold_pic").show();
		return true;
	}
}

</script>

<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php';?>
	<div class="con_right">
		<div class="location">CMS管理 &gt; 文章采集 </div>
		<div>
			<form action="/cmsinfo/collection/insert" method="post" onsubmit="return checkType();">
				<fieldset class="fieldset">
					<legend>选择采集来源</legend>
					来源类型：
					<select name="source" id="sou_type">
						<option value="0">======全部分类======</option>
						<option value="2">太平洋女性-美容-彩妆</option>
						<option value="3">太平洋女性-美容-美发</option>
						<option value="4">时尚女人-服装-韩国搭配</option>
						<option value="5">时尚女人-服装-身材搭配</option>
						<option value="6">时尚女人-服装-场合搭配</option>
						<option value="7">尚秀-服装-日韩搭配</option>
						<option value="8">尚秀-服装-明星搭配</option>
						<option value="9">尚秀-服装-混搭流行</option>
						<option value="10">尚秀-服装-欧美流行</option>
						<option value="11">尚秀-美容-化妆</option>
						<option value="12">尚秀-美容-彩妆</option>
						<option value="13">尚秀-美容-美甲</option>
						<option value="14">尚秀-美容-眼妆</option>
						<option value="15">时尚魔女-服装搭配</option>
						<option value="16">时尚魔女-日韩服装</option>
						<option value="17">时尚魔女-职场白领</option>
						<option value="18">时尚魔女-鞋包配饰</option>
						<option value="19">时尚魔女-时尚街拍</option>
						<option value="20">时尚魔女-流行发型</option>
						<option value="21">时尚魔女-护肤彩妆</option>
						<option value="22">时尚魔女-休闲装扮</option>
						<option value="23">女装-服装-潮流搭配</option>
						<option value="24">女装-服装-潮流风尚</option>
						<option value="25">米娜-服装-街头</option>
						<option value="26">米娜-服装-趋势</option>
						<option value="27">米娜-服装-混搭</option>
						<option value="28">女人志-服装-搭配</option>
						<option value="29">女人志-服装-单品</option>
						<option value="30">都市主妇-服装-搭配</option>
						<option value="31">都市主妇-服装-明星</option>
						<option value="32">都市主妇-服装-造型</option>
					</select>
					起始位置：
					<input type="text" name="page_start" value="" size="2">
					偏移页数：
					<input type="text" name="page_offset" value="" size="2">
					<input type="submit" name="submit" value="开始采集" />
					&nbsp;&nbsp;<img src="__PUBLIC__/Images/loading_new.gif" id="hold_pic" width="20">
				</fieldset>
			</form>
		</div>
	</div>
</div>

<?php include_once './App/Tpl/Public/footer.php';?>
