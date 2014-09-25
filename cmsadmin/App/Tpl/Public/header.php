<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CMS后台管理</title>
		<link href="<?php echo C('THEME_PATH');?>/Css/skin.css" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.js'></script>
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.lazyload.min.js'></script>
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/Alert/BY_Base.js'></script>
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/Alert/BY_Dialog.js'></script>
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/Alert/popup.js'></script>
		<style> body{ background:#efefef;}</style>
		<script>
			$(document).ready(function(){
				$(".lazy").lazyload({ effect : "fadeIn"}); 
			});
		</script>
	</head>
	<body>
		<div id="index_head">
			<span class="in_header"></span>
			<span class="in_con">
				您好，欢迎您的登录，祝工作愉快。
				<a href="<?php echo __APP__.'/Login/index/logout'?>" class="font_white">安全退出</a>
			</span>
		</div>
		