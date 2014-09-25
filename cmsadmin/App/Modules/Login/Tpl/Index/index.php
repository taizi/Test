<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商城后台管理中心登录入口</title>
<link href="<?php echo C('THEME_PATH');?>/Css/skin.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery-1.7.1.min.js'></script>
<style>
body{background:#330000;}
</style>
</head>
<body>
<div id="login_main"> 
	<div style="height:42px;"></div>
  <div class="login_m"> 
  <div class="login_con">
  <div class="login_logo"></div>
        <div class="login_c">
          <h2 class="f_tit">登录网站后台管理系统</h2></h2>
<form action="<?php echo __ACTION__;?>" id="login_form" method="post">
          <table class="list-table" width="96%" border="0" cellspacing="3" cellpadding="0">
            <tr>
              <td>管理员：</td>
              <td><input name="username" id="username" type="text" class="input_s" /></td>
            </tr>
            <tr>
              <td>密&nbsp;&nbsp;码：</td>
              <td><input name="password" id="password" type="password" class="input_s" /></td>
            </tr>
            <tr>
              <td>验证码：</td>
              <td>
              <input class="input_s" name="verify" type="text" style="width:70px;" /><img id="yzmreload" src='<?php echo __URL__;?>/verify' style="cursor:pointer" />
              </td>
            </tr>
          </table>
		<div class="l_submit">
        <p class="submit"> <span class="btn_type1"><a href="javascript:;" id="logincmd" class="font_14">登录</a></span> <span class="btn_type1" ><a href="javascript:;" id="cecmd" class="font_14">取消</a></span> </p>
        
        </div>
        </form>
      </div>
       </div>
     </div>
</div>

<script type="text/javascript"> 
$(document).ready(function(){ 
	  if($("#password").length>0){
	     $("#password").keydown(function(e){
			   var event = $.event.fix(e); 
			      if (event.keyCode==13){
			    	  $("#logincmd").click();
	               }  
		  });
	  }
	  if($("#username").length>0){
		     $("#username").keydown(function(e){
				   var event = $.event.fix(e); 
				      if (event.keyCode==13){
				    	  $("#password").focus();
		              }  
			  });
	 }
	 $("#logincmd").click(function(){
			if($("#username").attr('value')=='' || $("#pssword").attr('value')==''){
				alert('请输入用户名和用户密码');
	            return;
			}
			$("#login_form").submit();
	 });
	 $("#cecmd").click(function(){
		window.location.reload();
	 });
	 $("#yzmreload").click(function(){
		    var url="<?php echo __URL__;?>/verify";
		    var url=url+"?prams="+parseInt(100*Math.random());
		   $(this).attr("src",url);
	 });

});
</script> 
</body>
</html>