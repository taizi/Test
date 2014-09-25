<?php include_once './App/Tpl/Public/header.php';?>
<script type="text/javascript" src="/Public/My97DatePicker/WdatePicker.js"></script>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
       <div class="location">系统管理  > 系统日志 </div>
       <div >
       <form action="<?php echo __ACTION__;?>" method="get">
       <fieldset class="fieldset">
        <legend>搜索</legend>
                          搜索词<input name="pos[keyword]" type="text" value="" /> 
                         时间<input name="pos[stime]" type="text"   style="width:120px;" onfocus="WdatePicker({doubleCalendar:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly />
			-<input name="pos[etime]" type="text"   style="width:120px;" onfocus="WdatePicker({doubleCalendar:true,dateFmt:'yyyy-MM-dd HH:mm:ss'})" readonly />             
         <input name="so" type="submit" value="搜索"/>
       </fieldset>
       </form>
       </div>
        <?php if(!empty($List)){?>
	        <table width="100%"  class="tables">
		          <tr>
		               <th align="left" width="30">编号</th>
				       <th align="left">请求类型</th>
				       <th align="left">模块</th>
				        <th align="left">用户</th>
				        <th align="left">操作数据</th>
				        <th align="left">ip</th>
				       <th align="center">时间</th>
				       <th align="center">操作</th>
		          </tr>
	           <?php foreach ($List as $v){ ?>
			       <tr>
			       <td align="left"><?php echo $v['id'];?></td>
			        <td align="left"><?php echo $v['reqtype'];?></td>
			       <td align="left"><?php echo $v['node1'].'->'.$v['node2'].'->'.$v['node3'];?></td>
			       <td><?php echo $v['username']."(".$v['truename'].")"?></td>
			       <td style="position:relative;"> <a href="javascript:dispinfo('<?php echo $v['id'];?>');">查看详细</a>
			           <div id="infos_<?php echo $v['id'];?>" style="display:none;background:#FFF;word-break : break-all;border:1px solid #CCC;padding:6px;z-index:3;position:absolute; left:-300px; height:auto; width:500px;"><?php echo $v['data']?></div>
			       </td>
			        <td><?php echo $v['ip']?></td>
			       <td align="center" width="120"><?php echo date("Y-m-d H:i:s",$v['create_time']);?></td>
			       <td width="240" align="center">
			            <a class="btn_red float" href="javascript:delLog(<?php echo $v['id'];?>)">删除</a>
			       </td>
			       </tr>
	        <?php }?>       
	        </table>
        <div class="page"><?php echo $page;?></div>
        <?php }?>
  </div>
</div>
<script type="text/javascript">
function dispinfo(v){
	$("#infos_"+v).toggle();
}
function delLog(id){
	if(!confirm("确认要删除该记录吗？")){
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