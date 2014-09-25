/* citys select area by  xuezheng.chang 2013.6.6
 * 参数说明
 *CityName:城市管理框的名称
 *CityVars:城市选择框标识
 *CitySelectObjectID:在哪个区域显示城市选择
 *CityLoading:装载完成前的提示信息
 *CityObject:当前对象的名称
 *CityAjaxUrl:请求URL地址 返回JSON格式  status:1|0  data城市记录  area_id,area_name;
 *CitySelLevelArray:选择框层级
 *CitySelValueArray:选择框层级上下级关系
*/     
var SelectCitys = {
        CityName:'cityid[]',
        CityVars:'selectcity',
        CitySelectObjectID:'selectcityarea',
        CityLoading:'',
        CityObject:'', 
        CityAjaxUrl:'',
        CitySelLevelArray:[],
        CitySelValueArray:[],
　　　　 CreateNew: function(){
			　　　　　　var obj = {};
			            obj.isArray = function (obj) {
						    return obj && !(obj.propertyIsEnumerable('length')) && typeof obj === 'object' && typeof obj.length === 'number';
						};
						obj.search = function(pid){
							 var tmp;
							 for(key in SelectCitys.CitySelLevelArray){
								 tmp=key;
								 if(SelectCitys.CitySelLevelArray[tmp]==pid){
									 return SelectCitys.CitySelValueArray[tmp];
								 }
							 }
							 return 0;
						};
			           obj.set=function(options){
			        	   var tmp;
			        	   for(key in options){
			        		   tmp=key;
			        		   if(obj.isArray(options[tmp])){
			        			   eval("SelectCitys."+tmp+"=["+options[tmp]+"]");
			        		   }else{
			        		       eval("SelectCitys."+tmp+"='"+options[tmp]+"'");
			        		   }
			        	   }
			        	   if(SelectCitys.CitySelLevelArray.length>0){
				        	   for(var i=0;i<SelectCitys.CitySelLevelArray.length;i++){
				      			 this.get(SelectCitys.CitySelLevelArray[i],'');
				      		   }
			        	   }else{			        		   
			        		     this.get(1,'');
			        	   }
			           };
			　　　　　　obj.get = function(pid,me){
				              if(me!=''){  this.clear(me); }
				              if(!pid)return;
				              pid=parseInt(pid);
				              if(SelectCitys.CityLoading!=''){
				                 $(SelectCitys.CityLoading).css({"display":""});
				              }
				              $.ajax({
				  				type: "GET",
				  				url: SelectCitys.CityAjaxUrl+pid,
				  				dataType: "json",
				  				async:false,
				  				success: function(res){
				  						var option = "";
				  						if(res.status>0){
				  							    option += "<option value=\"\">请选择</option>";
				  							    var tmpid=obj.search(pid);
				  							    var str='';
				  								for(var j =0;j < res.data.length; j++){
				  									str='';
				  									if(tmpid==res.data[j].area_id){
				  										str='selected';
				  									}
				  									option += "<option "+str+" value=\"" + res.data[j].area_id + "\">" + res.data[j].area_name + "</option>";
				  								}
				  								var pro="name=\""+SelectCitys.CityName+"\" vars=\""+SelectCitys.CityVars+"\"";
				  								var eve="onchange=\""+SelectCitys.CityObject+".get(this.options[this.selectedIndex].value,this)\"";
				  								var str="<select "+pro+" "+eve+" ></select>";
				  								var select_obj = $(str);
				  							   $(select_obj).html(option);
				  							   $(SelectCitys.CitySelectObjectID).append($(select_obj));
				  						}
				  				}	
				  		     });	
				              
			           };
			           obj.clear=function(me){
			        	   if($("[vars='"+SelectCitys.CityVars+"']").length>0){
			        			var obj=$("[vars='"+SelectCitys.CityVars+"']");
			        			var nums=obj.length;
			        		    var index=$(obj).index($(me));
			        		    if(index>-1){
			        		    	index=index+1;
			        		    	for(i=index;i<nums;i++){
			        			      $(obj).eq(i).remove();
			        			    }
			        		    }
			        		}
			           };
			　　　　　　return obj;
　　　　                            }
};