<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
	<?php include_once './App/Tpl/Public/leftmenu.php';?>
	<div class="con_right">
		<div class="location">系统管理  > 广告管理 </div>
		<div class="tools"><a href="javascript:void(0)" class="btn_blue float" class="btn_red cmd100">新增</a></div>
		<div>
			<form action="" method="get">
				<fieldset class="fieldset">
					<legend>搜索</legend>
					<select id="" name="" onchange="">
						<option value="">全部分类</option>
					</select>
					名称
					<input name="keyword" type="text" value="" />
					<input name="" type="submit" value="搜索"/>
				</fieldset>
			</form>
		</div>
		<div>
			<table class="tables">
				<tr>
					<th align="center" width="30">编号</th>
					<th align="center">标题</th>
					<th align="center">排序</th>
					<th align="center">状态</th>
					<th align="center">创建时间</th>
					<th align="center">操作</th>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left"></td>
					<td align="left"></td>
					<td align="left"></td>
					<td align="left"></td>
					<td align="left"></td>
				</tr>
			</table>
			<div class="page"></div>
        </div>
	</div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>
