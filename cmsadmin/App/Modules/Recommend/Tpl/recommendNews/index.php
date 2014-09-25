<?php include_once './App/Tpl/Public/header.php';?>
<script type="text/javascript">
function chk_del(){
	if(confirm("警告：确认要删除？")){
		return true;
	}else{
		return false;
	}
}

function detail_news(newsTitle,newsContent){
	byMsg('<div>'+newsTitle+'</div><div>'+newsContent+'</div>',{width:700,height:300,title:'文章详情'},['关闭',function(){
		}]);
}

function edit_sort(hp_id,hp_page){
	byIframe('/Recommend/RecommendNews/edit_sort?hp_id='+hp_id+'&hp_page='+hp_page,{width:350,height:180,title:'修改排序'});
}
</script>
<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php'; ?> 
  	<div class="con_right">
  		<div class="location">推荐管理 &gt; 文章推荐</div>
  		<div class="tools">
			<a href="/Recommend/RecommendNews/insert" class="btn_blue float cmd100">新增</a>
		</div>
  		<div>
       		<form action="/Recommend/RecommendNews/index" method="get">
       			<fieldset class="fieldset">
        			<legend>搜索</legend>
        			<select id="search_style" name="search_style">
        				<option value="">全部分类</option>
        				<?php if(!empty($style_list)): ?>
        				<?php foreach($style_list as $k => $v_style): ?>
        				<option value="<?php echo $v_style['id']; ?>"><?php echo $v_style['position_name']; ?></option>
        				<?php endforeach; ?>
        				<?php endif; ?>
					</select>
		 			名称：
		 			<input type="text" name="search_name" value="" />
		 			<input type="submit" value="搜索" />
             	</fieldset>
             </form>
         </div>
         <table class="tables">
			<tr>
				<th align="center" width="30">编号</th>
				<th align="center" width="150">位置</th>
				<th align="center" width="350">标题</th>
				<th align="center" width="70">日期</th>
				<th align="center" width="40">排序</th>
				<th align="center" width="70">开始时间</th>
				<th align="center" width="70">结束时间</th>
				<th align="center" width="150">操作</th>
			</tr>
			<?php if(!empty($rec_list)): ?>
			<?php foreach($rec_list as $k => $v_rec): ?>
	        <tr>
	        	<td align="center"><?php echo $v_rec['hp_id']; ?></td>
	        	<td align="center"><?php echo $v_rec['p_name']; ?></td>
	        	<td align="center"><a href="javascript:void(0);" onclick="detail_news('<?php echo $v_rec['n_title']; ?>','<?php if(!empty($v_rec['n_content'])): echo $v_rec['n_content']; else: echo '内容未知'; endif; ?>');"><?php echo $v_rec['n_title']; ?></a></td>
	        	<td align="center"><?php echo date('Y-m-d H:i',$v_rec['n_date']); ?></td>
	        	<td align="center"><?php echo $v_rec['hp_sort']; ?></td>
	        	<td align="center"><?php echo date('Y-m-d H:i',$v_rec['hp_stime']); ?></td>
	        	<td align="center"><?php echo date('Y-m-d H:i',$v_rec['hp_etime']); ?></td>
	        	<td align="center">
	        		<a class="btn_blue float" href="javascript:void(0);" onclick="edit_sort(<?php echo $v_rec['hp_id']; ?>,<?php if(!empty($rec_page)): echo $rec_page; endif; ?>);">修改排序</a>
	        		<a class="btn_red float" href="/Recommend/RecommendNews/delete?id=<?php echo $v_rec['hp_id']; ?>&page=<?php if(!empty($rec_page)): echo $rec_page; endif; ?>" onclick="return chk_del();">删除</a>
	        	</td>
	        </tr>
	        <?php endforeach; ?>
	        <?php endif; ?>
	    </table>
	    <div class="page"><?php if(!empty($page)): echo $page; endif; ?></div>
  	</div>
</div>

<?php include_once './App/Tpl/Public/footer.php';?>
