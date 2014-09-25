(function($,window,cache){ 
    $.fn.selectors=function(options){
    	//debug(this);
    	return this.each(function(){
    		 new init(this,options);
    	});
    };

	function init(obj,options){
		var parames=$.extend({}, defaults, options),
			$this=$(obj),
			selector1=$(parames.selector1),
			selector2=$(parames.selector2),
			selector3=$(parames.selector3);
		var da=parames.jsonData;
		if(da==null){
			return false;
		}
		$.data(cache,'domobj',{
			selector1:parames.selector1,
			selector2:parames.selector2,
			selector3:parames.selector3,
			minfee:parames.minfee,
			maxlong:parames.maxlong
		});
        $.data(cache,'info',da);
        
        
		loadData(1,parames.selector1_selected);
		loadData(2,parames.selector2_selected);
		loadData(3,parames.selector3_selected);
		
		selector1.change(function(event) {
			/* Act on the event */
            selector2.empty();
            selector3.empty();
            $(parames.minfee).html('');
            $(parames.maxlong).html('');
            
            $('#remark').val('');
            
            loadData(2);
           //var code= methods.createCode(parames.codeurl);
            //$(parames.code).html(code);
            //$(parames.code).next().val(code);
		});
		selector2.change(function(event) {
			/* Act on the event */
             selector3.empty();
             $(parames.minfee).html('');
             $(parames.maxlong).html('');
             loadData(3);
             $('#remark').val($(selector2).find('option:selected').text());
		});
		selector3.change(function(event) {
			/* Act on the event */
            var i=$(this).get(0).selectedIndex;//选择的索引值
            var arr=htmlDate(i-1);
            $(parames.minfee).html(arr['minfee']);
            $(parames.maxlong).html(arr['long']);
            
    		$('#minfee').val(arr['minfee']);
    		$('#long').val(arr['long']);
		});
	};
	//填充数据
    loadData=function (level,val){
        var data=$.data(cache,'info');
        
    	if(level==1){
    		methods.selector1Data(data,val);
    	}
        if(level==2){
            methods.selector2Data(data,val);
        }
        if(level==3){
            methods.selector3Data(data,val);
        }
    }
    htmlDate=function(i){
        var data=$.data(cache,'info'), 
            obj=$.data(cache,'domobj'),
            arr=[],
            sec=$(obj.selector2).val(),
            fir=$(obj.selector1).val();
            arr['minfee']=data[fir][sec].minfee[i];
            arr['long']=data[fir][sec].long;
            return arr;
    }

	var methods={
	    	//获取第一个SELECT的数据
	    	selector1Data:function(data,val){
	    		var obj=$.data(cache,'domobj');
	    		var textstr,selected='';
	    		var str='<option value="">请选择代金券类型</option>';
	    		for (var i in data){
                    textstr=methods.replaceType(i);
                    if(val!= null) selected=methods.isSelected(i,val);
        		    str+='<option '+selected+' value="'+i+'">'+textstr+'</option>';
        		}
        		$(obj.selector1).empty().append(str);
	    	},
            //获取第2个SELECT的数据
            selector2Data:function(data,val){
            	var obj=$.data(cache,'domobj');
                var selected='',fir=$(obj.selector1).val();
                if(!fir){return false;}
                var str='<option value="">请选择代金券属性</option>';
                for (var i in data[fir]){
                    if(val!= null) {
                    	//selected=methods.isSelected(i,val);
                    	selected=data[fir][i].name==val?' selected ':'';
                    }
                    str+='<option '+selected+' value="'+i+'">'+data[fir][i].name+'</option>';
                }
                
                $(obj.selector2).empty().append(str);
                if(val!= null){
                	$('#remark').val($(obj.selector2).find('option:selected').text());
                }
               
            },
            //获取第3个SELECT的数据
            selector3Data:function(data,val){
            	var obj=$.data(cache,'domobj');
                var selected='',
                sec=$(obj.selector2).val(),
                fir=$(obj.selector1).val();
                if(!fir){return false;}
                var str='<option value="">请选择代金券金额</option>';
                for (var i in data[fir][sec].fee){
                    if(val!= null) selected=methods.isSelected(data[fir][sec].fee[i],val);
                    str+='<option '+selected+' value="'+data[fir][sec].fee[i]+'">'+data[fir][sec].fee[i]+'</option>';
                }
                $(obj.selector3).empty().append(str);
                if(val!= null){
                	//var i=
                	//htmlDate($(obj.selector3).get(0).selectedIndex-1);
                	//$(obj.selector3).trigger('change');
                	var i=$(obj.selector3).prop('selectedIndex');//选择的索引值
                    var arr=htmlDate(i-1);
                    $(obj.minfee).html(arr['minfee']);
                    $(obj.maxlong).html(arr['long']);
                    
            		$('#minfee').val(arr['minfee']);
            		$('#long').val(arr['long']);
                }
                
                
                
            },
            replaceType:function(i){
                var str='';
                if(i==1) str='A券';
                if(i==2) str='B券';
                return str;
            },
            isSelected:function(i,val){
                return i==val?' selected ':'';
            },
	    	//获取编码
	    	createCode:function (url){
	    		var obj=$.data(cache,'domobj');
                var pos='&type='+$(obj.selector1).val();
                var data='';
	    		$.ajax({
                        type: "get",
                        url: url,
                        data:pos,
                        dataType:'json',
                        async: false,
                        success: function(ref){
                            data=ref.data;
                        }
                   });
                return data;
	       }
    }
    var defaults={
        jsonData:null,
        selector1:'#selector1',
        selector1_selected:null,
        selector2:'#selector2',
        selector2_selected:null,
        selector3:'#selector3',
        selector3_selected:null,
        minfee:'#minfee-text',
        maxlong:'#long-text',
        code:'#code',
        codeurl:'/Coupon/Coupon/createCode'
    }

    // private function for debugging    
      function debug(obj) {    
        if (window.console && window.console.log)    
          window.console.log('debug for: ' + obj);    
      };
     
	

})(jQuery,window,{});

