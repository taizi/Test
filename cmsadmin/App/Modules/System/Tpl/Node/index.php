<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
      <div class="location">系统管理   > 结点管理  > 全部结点</div>
       <div class="tools"><a href="<?php echo __URL__.'/insert/id/0';?>" class="btn_red cmd100">增加顶级结点</a></div>
       <div class="system_tree">
       <?php  echo $NodeList; ?> 
       </div>
  </div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>