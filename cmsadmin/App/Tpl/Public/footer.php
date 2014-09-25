		<div class="clear"></div>
		<div class="footer">
			<a href="#" class="font_white">宝苑国际</a> CMS  V1.0版
		</div>
		<script>
			$("#table_list tr").mouseover(function(){
				var index = $("#table_list tr").index($(this));
				if(index > 0){
					$(this).find('td').css({"background":"#FDD9F2"});
				}
			});

			$("#table_list").find('tr').mouseout(function(){
				var index = $("#table_list tr").index($(this));
				if(index > 0){
					$(this).find('td').css({"background":"#fff"});
				}
			});
		</script>
	</body>
</html>