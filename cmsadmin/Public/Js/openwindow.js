jQuery.Smarts={
    setAreaCenter:function(obj){
          var window_height=$(window).height();
          var window_width=$(window).width();
          if($("#"+obj).length>0){
	          var area_height=$("#"+obj).height();
	          var area_width=$("#"+obj).width();
	          var scroll_top=$(window).scrollTop();
	          new_area_height="0";
	          new_area_width="0";	         
	          if(window_height>area_height){
	            new_area_height=parseInt((window_height/2)-(area_height/2)+scroll_top);
	          }
	          if(window_width>area_width){
	            new_area_width=parseInt((window_width/2)-(area_width/2));
	          }
	          $("#"+obj).css({"left":new_area_width+"px","top":new_area_height+"px"});
          }
    },
    showWindow:function(w,h,html){
       var border=20;
       var n_w=(w+border*2);var n_h=(h+border*2);
       $("#show_window").css({"width":n_w,"height":n_h});
       $("#show_window_bj").css({"width":n_w,"height":n_h});
       $("#show_html").css({"width":w,"height":h,"top":border,"left":border});
       $("#show_html").html(html);
       $.Smarts.setAreaCenter("show_window");
       $("#show_window").show();
    },
    closeWindow:function(){
         $("#show_html").html("");
         $("#show_window").hide(); 
    },
    setSize:function(w,h){
    	 var border=20;
         var n_w=(w+border*2);var n_h=(h+border*2);
         $("#show_window").css({"width":n_w,"height":n_h});
         $("#show_window_bj").css({"width":n_w,"height":n_h});
         $("#show_html").css({"width":w,"height":h,"top":border,"left":border});
         $.Smarts.setAreaCenter("show_window");
    }    
};


jQuery.Sysoper={
		 showUserLogin:function(){  //显示用户登录
			 var htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
				 htmls=htmls+"<div align=\"center\"><img src=\"http://image.22kk.com/themes/img/loading.gif\" style=\"width:50px;height:50px;\"></div>";
				$("#show_html").css({"background":"#fff"});
				$.Smarts.showWindow(400,200,htmls);
				 $.ajax({
					   type: "GET",
					   url: "http://www.22kk.com/club/user/login_ajax_html",
					   dataType:'jsonp',
					   jsonp:"callback",
					   success: function(result){
						   htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
						   htmls=htmls+result.html;
						   $("#show_html").html(htmls);
					   }
				  });
		 },
		 userLogout:function(){ //用户退出 
			 var htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
			 htmls=htmls+"<div align=\"center\" style=\"color:#06c;line-height:22px;font-size:12px;font-weight:bold;\"><img src='http:\/\/image.22kk.com\/themes\/img\/loading.gif' width='50' height='50'><br><span style='color:#f30;'>您好，系统正在退出，请您稍等...<\/span><br>我们期待与您，下次再会...<\/div>";
			 $("#show_html").css({"background":"#fff"});
			 $.Smarts.showWindow(400,100,htmls);
			 $.ajax({
				   type: "GET",
				   url: "http://www.22kk.com/club/user/logout_ajax",
				   dataType:'jsonp',
				   jsonp:"callback",
				   success: function(result){
					   window.setTimeout('window.location.href="http://22kk.com"',1000); 
				   }
			  });
		 }
}
$(window).resize(function(){ $.Smarts.setAreaCenter('show_window'); });
$(window).scroll(function(){ $.Smarts.setAreaCenter('show_window'); });