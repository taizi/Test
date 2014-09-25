<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>后台管理</title>
		<link href="<?php echo C('THEME_PATH');?>/Css/skin.css" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.js'></script>
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/openwindow.js'></script> 
		<script type='text/javascript' src='<?php echo C('THEME_PATH');?>/Js/jquery.lazyload.min.js'></script> 
		<style>
			body{ background:#efefef;}
		</style>
		<script> 
			$(document).ready(function(){
				$(".lazy").lazyload({ effect : "fadeIn"}); 
			});
		</script>
	</head>
	<body>
		<div id="show_window" class="show_window">
			<div id="show_window_bj" class="show_window_bj"></div>
			<div id="show_html" class="show_html"></div>
		</div>
