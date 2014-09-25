<?php include_once './App/Tpl/Public/header.php';?>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
      <div class="location">系统管理   > 管理员 </div>
       <div class="tools"><a href="<?php echo __URL__.'/insert';?>" class="btn_blue float" class="btn_red cmd100">新增管理员</a> </div>
        <?php if(!empty($UserList)){?>       
        <table width="100%"  class="tables">
	          <tr>
	               <th>用户名</th>
			       <th>昵称</th>
			       <th>状态</th>
			       <th>登录次数</th>
			       <th>最后登录时间</th>
			       <th>最后登录IP</th>
			       <th>修改时间</th>
			       <th>添加时间</th>
			       <th>操作</th>
	          </tr>
           <?php foreach ($UserList as $v){ ?>
		       <tr>
		       <td><?php echo $v['account'];?></td>
		       <td><?php echo $v['nickname'];?></td>
		       <td><?php echo empty($v['status'])?'禁用':'正常';?></td>
		       <td><?php echo $v['login_count'];?></td>
		       <td><?php echo date("Y-m-d H:i:s",$v['last_login_time']);?></td>
		       <td><?php echo $v['last_login_ip'];?></td>
		       <td><?php echo date("Y-m-d H:i:s",$v['update_time']);?></td>
		       <td><?php echo date("Y-m-d H:i:s",$v['create_time']);?></td>
		       <td >
		                  <a class="btn_blue float" href="<?php echo __URL__.'/edit/id/'.$v['id'];?>">编辑</a> 
		                  <a class="btn_red float" href="<?php echo __URL__.'/delete/id/'.$v['id'];?>">删除</a>
		                  <a class="btn_blue float" href="<?php echo __URL__.'/role/id/'.$v['id'];?>">角色</a>
		       </td>
		       </tr>
        <?php }?>
        </table>
        <div class="page"><?php echo $page;?></div>
        <?php }?>
  </div>
</div>
<?php include_once './App/Tpl/Public/footer.php';?>