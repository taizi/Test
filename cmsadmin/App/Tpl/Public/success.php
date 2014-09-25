<!DOCTYPE html>
<html>
	<head>
		<title>后台管理中心</title>
		<meta charset="UTF-8" />
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery-1.7.1.min.js'></script> 
		<link rel="stylesheet" href="<?php echo C('THEME_PATH');?>/Css/main.css" />
	</head>
	<body>  
		<div class="error">
			<h1><?php echo $msgTitle;?></h1>
			<fieldset class="fieldset">
				<legend>消息</legend>
				<p><?php echo $message;?></p>
				<p>
					系统将在 <span id="wait" style="color:blue;font-weight:bold"><?php echo $waitSecond;?></span>
					秒后自动跳转,如果不想等待,直接点击 <a id="href" href="<?php echo $jumpUrl;?>" class="btn btn-warning btn-big">这里</a>跳转
          		</p>
			</fieldset>
			<div><a class="btn_blue" href="javascript:;" onclick="window.history.back();">返回</a></div>
		</div>

		<script type="text/javascript">
			(function(){
				var wait = document.getElementById('wait'),href = document.getElementById('href').href;
				var interval = setInterval(function(){
					var time = --wait.innerHTML;
					(time == 0) && (location.href = href);
				}, 1000);	
			})();
		</script>
		<?php include_once './App/Tpl/Public/footer.php';?>
		