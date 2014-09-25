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
       		<?php if(!empty($message)){?>
       		<fieldset class="fieldset">
		  		<legend>消息</legend>
		  		<p><?php echo $message;?></p>
			</fieldset>
			<?php }?>
      		<fieldset class="fieldset">
		 		<legend>错误</legend>
		  		<p style=" line-height:24px;"><?php echo $error;?></p>
		  		<p style=" line-height:24px;">页面自动 <a id="href" href="<?php echo($jumpUrl); ?>" style="color:#fff;">立即登录</a> 等待时间： <b id="wait" style='color:#fff;'><?php echo($waitSecond); ?></b>秒</p>
		  		<div><a class="btn_blue" href="javascript:;" onclick="window.history.back();">返回</a> </div>
			</fieldset>
		</div>
		<script type="text/javascript">
			(function(){
				var wait = document.getElementById('wait'),href = document.getElementById('href').href;
				var interval = setInterval(function(){
					var time = --wait.innerHTML;
					if(time == 0) {
						location.href = href;
						clearInterval(interval);
					};
				}, 1000);
			})();
		</script>
		<?php include_once './App/Tpl/Public/footer.php';?>
		