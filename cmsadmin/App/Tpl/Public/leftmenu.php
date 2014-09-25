<div class="index_left">
	<?php if(!empty($left_menu)){
		foreach ($left_menu as $k=>$app){ ?>
		<h1 >
		<?php if(empty($k)){?>
			<a href="<?php echo __APP__.'/'.$app['name']?>" ><?php echo $app['title'];?></a>
		<?php }else{?>
			<a href="javascript:;"><?php echo $app['title'];?></a>
		<?php }?>
		</h1>
		<?php  if(!empty($app['children'])){?>
			<div class="content" id="left_<?php echo strtolower($app['name']); ?>">
				<span><img src="<?php echo C('THEME_PATH');?>/images/menu_topline.gif" width="182" height="5" /></span>
				<ul class="menu">
					<?php foreach ($app['children'] as $model){
					if($model['name']!='index'){ ?>
						<li id="<?php echo strtolower($model['name']);?>"><a href="<?php echo __APP__;?>/<?php echo $app['name'];?>/<?php echo $model['name'];?>/index" ><?php echo $model['title'];?></a></li>
					<?php }
					} ?>
				</ul>
			</div>
		<?php } ?>
	<?php } } ?>
</div>
<script>
$(document).ready(function(){
	if($(".index_left").length > 0){
		$(".index_left .content").css({"display":"none"});
		$(".index_left h1").click(function(){
			 $(this).next('.content').css({"display":"block"});
		});
	}
	$("#left_<?php echo strtolower(GROUP_NAME);?>").css({"display":"block"});
	$("#left_<?php echo strtolower(GROUP_NAME);?> #<?php echo strtolower(MODULE_NAME);?>").find("a").css({"color":"#f00","font-weight":"bold"});
});
</script>
