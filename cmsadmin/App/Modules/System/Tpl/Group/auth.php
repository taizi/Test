<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
     <h1> 系统管理  > 管理员组  > 组权限</h1>
      <div class="system_tree">
         <form id="authfrm" method="post" action="<?php echo __URL__.'/auth/id/'.$id;?>" >
            <input name="id" type="hidden" value="<?php echo $id;?>" />
            <?php  echo $NodeList; ?><br> 
            <a href="javascript:;" onclick="$('#authfrm').submit();" class="btn_blue float">保存 </a> <a href="<?php echo __URL__;?>" class="btn_blue float" >返回</a>
           <div class="clear"></div>
           </form>    
       </div>
  </div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>