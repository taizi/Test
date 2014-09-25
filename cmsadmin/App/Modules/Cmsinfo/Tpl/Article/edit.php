<?php include_once './App/Tpl/Public/header.php';?>
<script type="text/javascript" src="__PUBLIC__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="__PUBLIC__/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__PUBLIC__/My97DatePicker/calendar.js"></script>
<style type="text/css">
	.hold{width:100px;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	var editor = new UE.ui.Editor();
	editor.render("news_content");
});

</script>
<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php';?>
	<div class="con_right">
		<div class="location">CMS管理 &gt; 编辑文章 </div>
		<div>
       		<form action="/Cmsinfo/Article/update_news" method="post" enctype="multipart/form-data" onsubmit="return doSubmit();">
       			<input type="hidden" name="news_id" value="<?php if(!empty($list['news_id'])): echo $list['news_id']; endif; ?>">
       			<input type="hidden" name="news_page" value="<?php if(!empty($page)): echo $page; endif; ?>">
       			<fieldset class="fieldset">
	        		<legend>属性</legend>
	        		<table class="tables_news">
		        		<tr>
		        			<td class="float_right">标题：</td>
		        			<td width="220"><input type="text" name="news_title" value="<?php if(!empty($list['news_title'])): echo $list['news_title']; endif; ?>"></td>
		        			<td class="float_right">关键字：</td>
		        			<td width="220"><input type="text" name="news_keyword" value="<?php if(!empty($list['keyword'])): echo $list['keyword']; endif; ?>"></td>
		        			<td class="float_right">排序：</td>
		        			<td width="220"><input type="text" name="news_sort" value="<?php if(!empty($list['news_sort'])): echo $list['news_sort']; endif; ?>"></td>
		        			<td class="hold"></td>
		        		</tr>
		        		<tr>
		        			<td class="float_right">作者：</td>
		        			<td width="220"><input type="text" name="news_author" value="<?php if(!empty($list['details_author'])): echo $list['details_author']; endif; ?>"></td>
		        			<td class="float_right">来源：</td>
		        			<td width="220"><input type="text" name="news_source" value="<?php if(!empty($list['details_source'])): echo $list['details_source']; endif; ?>"></td>
		        			<td class="float_right">日期：</td>
		        			<td width="220"><input type="text" name="news_date" value="<?php if(!empty($list['details_date'])): echo date('Y-m-d H:i',$list['details_date']); endif; ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"></td>
		        			<td class="hold"></td>
		        		</tr>
		        		<tr>
		        			<td class="float_right">类型：</td>
		        			<td colspan="5">
		        				<div class="news_type">
		        					<?php if(!empty($news_type)): ?>
		        					<?php foreach($news_type as $k => $v_type): ?>
		    						<div class="type_check"><input type="checkbox" name="news_type[]" value="<?php echo $v_type['id']; ?>" <?php if(in_array($v_type['id'],$list['news_type'])): echo 'checked'; endif; ?>>&nbsp;<?php echo $v_type['type_name']; ?></div>
		    						<?php endforeach; ?>
		    						<?php endif; ?>
		        				</div>
		        			</td>
		        			<td class="hold"></td>
		        		</tr>
		        		<tr>
		        			<td class="float_right">副标题栏：</td>
		        			<td colspan="2" width="300">
		        				<textarea name="news_subject" id="news_subject" cols="50" rows="3"><?php if(!empty($list['details_subject'])): echo $list['details_subject']; endif; ?></textarea>
		        			</td>
		        			<td class="float_right">简介：</td>
		        			<td colspan="2" width="300">
		        				<textarea name="news_summary" id="news_summary" cols="50" rows="3"><?php if(!empty($list['summary'])): echo $list['summary']; endif; ?></textarea>
		        			</td>
		        			<td class="hold"></td>
		        		</tr>
		        		<tr>
		        			<td class="float_right">内容：</td>
		        			<td colspan="5" width="960"><textarea name="news_content" id="news_content"><?php if(!empty($list['details_content'])): echo $list['details_content']; endif; ?></textarea></td>
		        			<td class="hold"></td>
		        		</tr>
		        		<tr>
		        			<td class="float_right">封面图：</td>
		        			<td colspan="5"><div style="float:left; margin:12px 0 10px 0;"><img src="<?php if(!empty($list['news_cover'])): echo $list['news_cover']; endif; ?>"></div></td>
		        			<td class="hold"></td>
		        		</tr>
		        		<tr>
		        			<td></td>
		        			<td colspan="5"><input type="file" name="news_cover" value=""></td>
		        			<td class="hold"></td>
		        		</tr>
		        		<tr>
		        			<td colspan="3" align="center"><input type="image" src="__PUBLIC__/Images/submit_mini.gif" value="提交" /></td>
		        			<td colspan="3" align="center"><a href="/Cmsinfo/Article/index?page=<?php if(!empty($page)): echo $page; endif; ?>"><img src="__PUBLIC__/Images/back_mini.gif"></a></td>
		        			<td class="hold"></td>
		        		</tr>
		        	</table>
	       		</fieldset>
       		</form>
       	</div>
  	</div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>
