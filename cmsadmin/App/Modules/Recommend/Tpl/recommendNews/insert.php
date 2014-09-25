<?php include_once './App/Tpl/Public/header.php';?>
<link href="<?php echo C('THEME_PATH');?>/Css/recommend_insert.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/My97DatePicker/calendar.js"></script>
<style type="text/css">
	.rec_page{margin:10px 0 0 0; width:982px; text-align:center; color:#666;}
	.choose_position{float:left; margin:5px 0 0 30px;}
	.red_font{color:#f00; font-weight:bold;}
	.rec_time{float:right; margin:5px 106px 0 0px;}
</style>
<script type="text/javascript">
function position_choose(){
	byIframe('/Recommend/RecommendNews/position_choose',{width:500,height:'auto',title:'位置选择'});
}

function detail_news(newsTitle,newsContent){
	byMsg('<div>'+newsTitle+'</div><div>'+newsContent+'</div>',{width:700,height:300,title:'文章详情'},['关闭',function(){
		}]);
}

function chk_sub(){
	var num_news = 0;
	var num_time = 0;
	$(".check_news").each(function(){
		if($(this).is(":checked")){
			num_news += 1;
		}
	});
	if($("#stime").val() != ''){
		num_time = 1;
	}
	if(num_news > 0 && num_time > 0){
		return true;
	}else if(num_news == 0 && num_time > 0){
		alert('警告：请选择推荐的文章！');
		return false;
	}else if(num_news > 0 && num_time == 0){
		alert('警告：请输入推荐开始时间！');
		return false;
	}else{
		alert('警告：请勾选推荐文章及填写开始时间！');
		return false;
	}
}
</script>
<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php';?>
	<div class="con_right">
		<div class="location">推荐管理 &gt; 文章推荐 </div>
		<div class="rec_content">
       		<form action="/Recommend/RecommendNews/add_recNews" method="post" onsubmit="return chk_sub();">
       			<input type="hidden" name="act" value="<?php if(!empty($recNews_act)): echo $recNews_act; else: echo 'no_position'; endif; ?>">
       			<input type="hidden" name="pid" value="<?php if(!empty($position)): echo $position['id']; endif; ?>">
       			<fieldset class="fieldset" style="width:960px;">
	        		<legend>新增推荐</legend>
	        		<a href="javascript:void(0);" class="btn_blue float cmd100" onclick="position_choose();">位置选择</a>
	        		<div class="choose_position"><font class="red_font">位置</font>：<?php if(!empty($position)): echo $position['position_name']; else: echo '未选择'; endif; ?></div>
	        		<input type="image" src="__PUBLIC__/Images/submit_mini.gif" class="sub">
	        		<div class="rec_time">
	        			时间：<input type="text" name="stime" id="stime" value="" size="15" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">
	        			至<input type="text" name="etime" id="etime" value="" size="15" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">
	        		</div>
	       		</fieldset>
	       		<table class="tables" style="width:982px;">
	       			<tr <?php if(empty($position)): echo 'style="display:none;"'; endif; ?>>
	       				<th align="center" width="30">编号</th>
	       				<th align="center" width="350">标题</th>
	       				<th align="center" width="70">日期</th>
	       				<th align="center" width="30">排序</th>
	       				<th align="center" width="50">选择</th>
	       			</tr>
	       			<?php if(!empty($news_list)): ?>
	       			<?php foreach($news_list as $k => $v_list): ?>
	       			<tr>
	       				<td align="center"><?php echo $v_list['news_id']; ?></td>
	       				<td align="center"><a href="javascript:void(0);" onclick="detail_news('<?php echo $v_list['news_title']; ?>','<?php if(!empty($v_list['details_content'])): echo $v_list['details_content']; else: echo '内容未知'; endif; ?>');"><?php echo $v_list['news_title']; ?></a></td>
	       				<td align="center"><?php echo date('Y-m-d H:i',$v_list['details_date']); ?></td>
	       				<td align="center"><input type="text" name="sort_<?php echo $v_list['news_id']; ?>" value="" size="3"></td>
	       				<td align="center"><input type="checkbox" name="nid_list[]" value="<?php echo $v_list['news_id']; ?>" class="check_news"></td>
	       			</tr>
	       			<?php endforeach; ?>
	       			<?php endif; ?>
	       		</table>
	       		<div class="rec_page"><?php if(!empty($page)): echo $page; endif; ?></div>
       		</form>
       	</div>
  	</div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>
