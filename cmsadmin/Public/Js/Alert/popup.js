
/**
 * 获取Iframe页面
 * @param  {[type]} url [description]
 * @param  {[type]} o   [description]
 * @return {[type]}     [description]
 */
function byIframe(url,o){
	var o=o||{};
	o.content= "iframe:"+url;
	Util.Dialog(o);
}
 
/**
 * 加载页面  并附带参数   //"url:get?BY_Dialog/index222.php?kkk"
 * @param  {[type]} url [description]
 * @param  {[type]} o   [description]
 * @return {[type]}     [description]
 */
function byAjax(url,o){
	var o=o||{};
	o.content = "url:get?"+url;
	Util.Dialog(o);
}

/**
 * 不带标题的提示框
 * @param  {[type]} str [description]
 * @param  {[type]} o   [description]
 * @return {[type]}     [description]
 */
function byTips(content,o){
	var o=o||{};
	o.fixed = true;
	o.boxID= "dialog-byTips";
	o.position={top: "-80px"};
	//content='正在努力加载...';
	if(!content){
		var imgpath='BY_Dialog/loading.gif';
		o.content = "img:"+imgpath;
		o.width=80;
		o.height=30;
	}else{
		o.content = "text:"+content;
		o.width=100;
		o.height=40;
	}
	o.ofns= function(){
		$("#dialog-byTips").animate({top: '+100px'}, 600);
	};
	o.showtitle = false;
	o.showbg=true;
	Util.Dialog(o);
}

/**
 * loadding状态（图片）
 * @param  {[type]} title [description]
 * @return {[type]}       [description]
 */
function byLoading(title,img){
	var o=o||{};
	var imgpath=img?img:'BY_Dialog/loading.gif';
	o.fixed = true;
	o.title=title;
	o.content = "img:"+imgpath;
	o.bybg=true;
	Util.Dialog(o);
}

/**
 * 普通弹出窗口
 * @param  {[type]} text [description]
 * @param  {[type]} o    [description]
 * @param  {[type]} fn1  确定的回调函数  如果返回ture 关闭窗口  返回false 不关闭窗口 
 * @param  {[type]} fn2  取消的回调函数
 * @return {[type]}      [description]
 */
function byMsg(text,o,fn1,fn2){
	var o=o||{};
	if($.isArray(fn1)){
		o.yesBtn=fn1;
	}else{
		o.yesBtn=['',function(){
			return true;
		}];
	}
	if($.isArray(fn2)){
		o.noBtn=fn2;
	}
	o.width=o.width?o.width:300;//制定宽度  自动换行   不指定则设定宽度为auto
	//o.height=o.height?o.height:50;
	o.content= "text:"+text;
	Util.Dialog(o);
}
/**
 * 窗口动画
 * @param  {[type]} o       [description]
 * @param  {[type]} openFn  打开窗口时的动画
 * @param  {[type]} closeFn 关闭窗口时的动画
 * @return {[type]}         [description]
 */
function byDong(o,openFn,closeFn){
	var o=o||{};
	if($.isFunction(openFn)){
		o.ofns=openFn;
	}
	if($.isFunction(closeFn)){
		o.animateClose=closeFn;
	}
	Util.Dialog(o);
}

//ajax提交回调函数
function urlto(url){
	if(!url) window.location.reload(); else  window.location.href=url;	
}

/**
 * 加入购物车
 * @param  {[type]} num [description]
 * @param  {[type]} fee [description]
 * @param  {[type]} url [description]
 * @return {[type]}     [description]
 */
function byCart(num,fee,url){
	var style='.y_close{ height:25px;}';
	style+='.y_close img{ float:right; margin-right:2px; margin-top:2px;}';
	style+='.y_ok{ margin:0 auto; width:350px; text-align:center; line-height:50px; }';
	style+='.y_ok img{ margin:2px 3px;}';
	style+='.y_layout1 .y_font{ margin:0 auto; width:350px; line-height:70px; text-align:center;}';
	style+='#cart-box-buttons{text-align:center; width: 240px; height: 50px; margin: 0 auto}';
	style+='#cart-box-buttons a{ background: #e9e9e9; width:100px; height: 35px; line-height: 35px; }';
	style+='#cart-box-buttons a:hover{text-decoration: none}';


	var str='<div id="dd" class="y_layout1">';
	str+='<div class="y_close"></div>';
	str+='<div class="y_ok">';
	str+='<span><img src="/Public/Images/y_ok.gif" style="vertical-align:middle" title="ok" /></span>';
	str+='<span style="font-size:14px; font-weight:bold">商品已成功放入购物袋</span>';
	str+='</div>';
	str+='<div class="y_font"><img src="/Public/Images/bagimg_1105.gif" style="vertical-align:middle">&nbsp;&nbsp;购物袋共有<span style=" font-size:18px; color:#C00; font-weight:bold;">'+num+'</span>件商品&nbsp;&nbsp;&nbsp;&nbsp;合计：<span style=" font-size:18px; color:#C00; font-weight:bold;">￥'+fee+'</span> </div>';
	str+='<div id="cart-box-buttons" >';
	str+='<a  id="CartGoon" style="float: left" onclick="return closeBox(\'my-cart-box\');"  href="javascript:;">继续购物</a>';
	str+='<a id="toCart"  style="float: right; background:#c00; color:#fff" href="'+url+'">查看购物袋</a>';
	str+='</div></div>';
	byDong({content:'text:'+str,title: "<font color='red'>每天美提示您</font>",boxID: "my-cart-box",width:400,height:200},function(){
		Util.addStyleToId('cart-box-style','content_0510',style);
		get_total_of_cart();
	},function(){
		$('#cart-box-style').remove();
	});
}

/**
 * 按弹框ID关闭
 * @param  {[type]} boxID [description]
 * @return {[type]}       [description]
 */
function closeBox(boxID){
	Util.Dialog.close(boxID);
}

/**
 * 关闭所有弹窗
 * @return {[type]} [description]
 */
function closeAll(){
	var id;
	$('.ui_dialog_wrap').find('.ui_dialog').each(function(){
		 id= $(this).attr('id');
		 closeBox(id);
	});
}