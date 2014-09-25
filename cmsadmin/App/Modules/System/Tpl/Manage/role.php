<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
    <div class="location">系统管理   > 管理员  > 角色</div>
       <div class="system_tree">
       <form id="save_role" method="post" action="<?php echo __URL__.'/role/id/'.$id;?>" >
        <input name="id" type="hidden" value="<?php echo $id;?>" />
       <?php  echo $RoleList; ?> <br>
       <a  href="javascript:;" onclick="$('#save_role').submit();" class="btn_blue float"> 保存</a> <a href="<?php echo __URL__;?>" class="btn_blue float" >返回</a>
       </form>
       <div class="clear"></div>
       </div>
  </div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>
            