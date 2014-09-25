<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
       <div class="location">系统管理  > 配送价格 </div>
       <div class="tools"> <a  href="javascript:addPrice()" class="btn_blue float" class="btn_red cmd100">新增</a> </div>
       <div >
       <form action="<?php echo __ACTION__;?>" method="get">
       <fieldset class="fieldset">
        <legend>搜索</legend>
                          名称<input name="keyword" type="text" value="" /> <input name="so" type="submit" value="搜索"/>
       </fieldset>
       </form>
       </div>
        <?php if(!empty($List)){?>
	        <table width="100%"  class="tables">
		          <tr>
		               <th align="left" width="30">编号</th>
		               <th align="left">地区</th>
		               <th align="left">公司</th>
				       <th align="left">名称</th>
				       <th align="left">价格</th>
				       <th align="left">续重</th>
				       <th align="left">描述</th>
				       <th align="center">创建时间</th>
				       <th align="center">操作</th>
		          </tr>
	           <?php foreach ($List as $v){ ?>
			       <tr>
			       <td align="left"><?php echo $v['rid'];?></td>
			        <td align="left"><?php echo $v['area_name'];?></td>
			        <td align="left"><?php echo $v['company_name'];?></td>
			        <td align="left"><?php echo $v['delivery_name'];?></td>
			        <td align="left"><?php echo $v['delivery_price'];?></td>
			        <td align="left"><?php echo $v['delivery_replenish'];?></td>
			        <td align="left"><?php echo $v['delivery_remark'];?></td>
			        <td align="center" width="120"><?php echo date("Y-m-d H:i:s",$v['create_time']);?></td>
			        <td width="160" align="center">
			            <a class="btn_red float" href="javascript:delPrice(<?php echo $v['rid'];?>)">删除</a>
			            <a class="btn_red float" href="javascript:editPrice(<?php echo $v['rid'];?>)">编辑</a>
			       </td>
			       </tr>
	        <?php }?>       
	        </table>
        <div class="page"><?php echo $page;?></div>
        <?php }?>
  </div>
</div>
<script type="text/javascript">
function addPrice(){
	 var htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
	   htmls=htmls+"<iframe frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"<?php echo __URL__.'/insert';?>\" ></iframe>";
	   $("#show_html").css({"background":"#fff"});
	   $.Smarts.showWindow(380,300,htmls);
}
function editPrice(id){
	 var htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
	   htmls=htmls+"<iframe frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"<?php echo __URL__.'/edit/id/';?>"+id+"\" ></iframe>";
	   $("#show_html").css({"background":"#fff"});
	   $.Smarts.showWindow(380,300,htmls);
}
function delPrice(id){
	if(!confirm("确认要该配送价格？")){
        return false;
	}
	$.ajax({
        type: "GET",
	    url: "<?php echo __URL__.'/delete/id/';?>"+id,
	    dataType:"json",
	    success: function(ref){
		    if(ref.status<1){
			    alert(ref.info);
			}else{
                window.location.reload();
			}
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){           
            alert(XMLHttpRequest.status);
            alert(XMLHttpRequest.readyState);
            alert(textStatus);
        }
     });
}
</script>
<?php include_once './App/Tpl/Public/footer.php';?>