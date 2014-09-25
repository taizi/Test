<?php include_once './App/Tpl/Public/header.php';?>
<script type="text/javascript">
function confirmDel(){
	if(confirm("警告：确认要删除？")){
		return true;
	}else{
		return false;
	}
}

function confirmReInsert(){
	if(confirm("警告：确认要重新导入？")){
		return true;
	}else{
		return false;
	}
}

function detail_news(untitle,uncontent){
	byMsg('<div>'+untitle+'</div><div>'+uncontent+'</div>',{width:700,height:300,title:'文章详情'},['关闭',function(){
		}]);
}

function chk_all(){
	$(".check_news").each(function(){
		$(this).attr("checked",!this.checked);
	});
}

function chk_import(){
	var num = 0;
	$(".check_news").each(function(){
		if($(this).is(":checked")){
			num += 1;
		}
	});
	if(num > 0){
		return true;
	}else{
		alert('请选择需要导入的数据！');
		return false;
	}
}

</script>

<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php';?>
	<div class="con_right">
		<div class="location">CMS管理 &gt; 采集管理 </div>
		<div>
			<form action="/Cmsinfo/CollectionList/insert_all?page=<?php if(!empty($un_page)): echo $un_page; endif; ?>" method="post" onsubmit="return chk_import();">
			<fieldset class="fieldset">
				<input type="image" src="__PUBLIC__/Images/imput_mini.gif" style="float:left;">
				<a class="float_right" href="/Cmsinfo/CollectionList/delete_all" onclick="return confirmDel();">
					<img src="__PUBLIC__/Images/del_all_mini.gif">
				</a>
			</fieldset>
			<table class="tables">
				<tr>
					<th align="center" width="30">反选<input type="checkbox" onclick="chk_all();"></th>
					<th align="center" width="30">编号</th>
					<th align="center">标题</th>
					<th align="center">发表时间</th>
					<th align="center">来源</th>
					<th align="center">采集时间</th>
					<th align="center">状态</th>
					<th align="center">操作</th>
				</tr>
				<?php if(!empty($list)): ?>
				<?php foreach($list as $k => $v_news): ?>
				<tr>
					<td align="center"><input type="checkbox" name="nid_list[]" class="check_news" value="<?php echo $v_news['id']; ?>" <?php if($v_news['un_status'] != 0): echo 'disabled="true"'; endif; ?>></td>
					<td align="center"><?php echo $v_news['id']; ?></td>
					<td align="center"><a href="javascript:void(0);" onclick="detail_news('<?php echo $v_news['un_title']; ?>','<?php if(!empty($v_news['un_content'])): echo $v_news['un_content']; else: echo '内容未知'; endif; ?>');"><?php echo $v_news['un_title']; ?></a></td>
					<td align="center"><?php echo date('Y-m-d h:i',$v_news['un_date']); ?></td>
					<td align="center"><?php echo $v_news['un_source']; ?></td>
					<td align="center"><?php echo date('Y-m-d h:i',$v_news['create_time']); ?></td>
					<td align="center"><?php echo $v_news['status']; ?></td>
					<td align="center">
						<a class="btn_blue float" href="/Cmsinfo/CollectionList/insert?id=<?php echo $v_news['id']; ?>&page=<?php if(!empty($un_page)): echo $un_page; endif; ?>" <?php if($v_news['un_status'] != 0): echo 'style="display:none;"'; endif; ?>>导入</a>
						<a class="btn_blue float" href="/Cmsinfo/CollectionList/re_insert?id=<?php echo $v_news['id']; ?>&page=<?php if(!empty($un_page)): echo $un_page; endif; ?>" onclick="return confirmReInsert();" <?php if($v_news['un_status'] != 1): echo 'style="display:none;"'; endif; ?>>重新导入</a>
						<a class="btn_red float" href="/Cmsinfo/CollectionList/delete?id=<?php echo $v_news['id']; ?>&page=<?php if(!empty($un_page)): echo $un_page; endif; ?>" onclick="return confirmDel();">删除</a>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</table>
			<div class="page">
				<?php if(!empty($page)): echo $page; endif; ?>
			</div>
			</form>
        </div>
     </div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>
