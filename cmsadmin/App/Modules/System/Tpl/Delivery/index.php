<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
       <div class="location">系统管理  > 配送方式 </div>
       <div class="tools"> <a  href="javascript:addDelivery()" class="btn_blue float" class="btn_red cmd100">新增</a> </div>
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
				       <th align="left">名称</th>
				       <th align="left">类型</th>
				       <th align="left">描述</th>
				       <th align="center">创建时间</th>
				       <th align="center">操作</th>
		          </tr>
	           <?php foreach ($List as $v){ ?>
			       <tr>
			       <td align="left"><?php echo $v['id'];?></td>
			        <td align="left"><?php echo $v['name'];?></td>
			        <td align="left"><?php if($v['type']==1){echo '普通';}else if($v['type']==2){echo 'COD';}else if($v['type']==3){echo '邮资到付';}?></td>
			       <td align="left"><?php echo $v['remark'];?></td>
			       <td align="center" width="120"><?php echo date("Y-m-d H:i:s",$v['create_time']);?></td>
			       <td width="240" align="center">
			            <a class="btn_blue float" href="javascript:editDelivery(<?php echo $v['id'];?>)">编辑</a> 
			            <a class="btn_red float" href="javascript:delDelivery(<?php echo $v['id'];?>)">删除</a>
			       </td>
			       </tr>
	        <?php }?>       
	        </table>
        <div class="page"><?php echo $page;?></div>
        <?php }?>
  </div>
</div>
<script type="text/javascript">
function addDelivery(){
	 var htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
	   htmls=htmls+"<iframe frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"<?php echo __URL__.'/insert';?>\" ></iframe>";
	   $("#show_html").css({"background":"#fff"});
	   $.Smarts.showWindow(300,200,htmls);
}
function editDelivery(id){
	 var htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
	   htmls=htmls+"<iframe frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"<?php echo __URL__.'/edit/id/';?>"+id+"\" ></iframe>";
	   $("#show_html").css({"background":"#fff"});
	   $.Smarts.showWindow(300,200,htmls);
}

function delDelivery(id){
	if(!confirm("确认要该配送方式？")){
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