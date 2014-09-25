<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
  <div class="location">系统管理   > 管理员组  > 全部组</div>
     <div class="tools"><a href="<?php echo __URL__.'/insert/id/0';?>" class="btn_red cmd100">增加顶级结点</a></div>
      <div class="system_tree">
       <?php  echo $RoleList; ?> 
       </div>
  </div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>