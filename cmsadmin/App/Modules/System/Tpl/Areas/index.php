<?php include_once './App/Tpl/Public/header.php';?>
<link rel="stylesheet" href="<?php echo C('THEME_PATH');?>/ztree/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="<?php echo C('THEME_PATH');?>/ztree/js/jquery.ztree.core-3.5.js"></script>
<script type="text/javascript" src="<?php echo C('THEME_PATH');?>/ztree/js/jquery.ztree.excheck-3.5.js"></script>
<script type="text/javascript" src="<?php echo C('THEME_PATH');?>/ztree/js/jquery.ztree.exedit-3.5.js"></script>
<style type="text/css">
.ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}
</style>
<div id="index_main">
  <?php include_once './App/Tpl/Public/leftmenu.php';?> 
  <div class="con_right">
     <div class="location">系统管理   > 城市管理 </div>
       	<style type="text/css">
.ztree li span{text-decoration:none}
.ztree li span.demoIcon{padding:0 2px 0 10px;}
.ztree li span.button.icon01{margin:0; background: url(<?php echo C('THEME_PATH');?>/ztree/zTreeStyle/img/diy/picture_add.png) no-repeat scroll 0 0 transparent; vertical-align:top; *vertical-align:middle}
.ztree li span.button.icon02{margin:0; background: url(<?php echo C('THEME_PATH');?>/ztree/zTreeStyle/img/diy/sitemap.png) no-repeat scroll 0 0 transparent; vertical-align:top; *vertical-align:middle}
</style>
       <div class="system_tree">
           <ul id="category_tree" class="ztree"></ul>           
       </div>
  </div>
</div>
<SCRIPT type="text/javascript">
		<!--
		var tree_tid="";
		var setting = {
			async: {
				enable: true,
				url:"<?php echo __ACTION__;?>",
				autoParam:["id", "name=n", "level=lv"],
				dataFilter: filter
			},
			view: {expandSpeed:"" //,
				//addHoverDom: addHoverDom,
				//removeHoverDom: removeHoverDom,
				//selectedMulti: false
			},
			edit: {				
				enable: false,
				removeTitle: "删除结点",
				showRemoveBtn: true,
				renameTitle:"编辑结点",
				showRenameBtn:true,
				drag: {
					autoExpandTrigger: true,
					isMove:true
				}
			},
			data: {
				simpleData: {
					enable: true
				}
			},
			callback: {
				beforeRemove: beforeRemove,
				beforeRename: beforeRename,
				beforeEditName:zTreeBeforeEditName,
				beforeDrag: beforeDrag,
				beforeDrop: beforeDrop,
				onAsyncSuccess:zTreeOnAsyncSuccess
			}
		};
		var movestat=0;
		var IDMark_A = "_a";
		function zTreeOnAsyncSuccess(event, treeId, treeNode, msg) {
		  //  alert(msg);
		};
		function beforeDrop(treeId, treeNodes, targetNode, moveType){	
			if(targetNode==null){	return false;  }
			if(moveType=='inner' || moveType=='prev' || moveType=='next'){
				  $.ajax({
		            type: "POST",
				    url: "<?php echo __URL__.'/move';?>",
				    data:"pos[sourceid]="+treeNodes[0].id+"&pos[targetid]="+targetNode.id+"&pos[movetype]="+moveType,
				    dataType:'json',
				    async:false,
				    success: function(ref){
		               if(ref.status<1){
			               alert(ref.info);
			               movestat=false;
			           }else{
			        	   movestat=true;
				       }
		            },
	                error: function(XMLHttpRequest, textStatus, errorThrown){
	                    alert(XMLHttpRequest.status);
	                    alert(XMLHttpRequest.readyState);
	                    alert(textStatus);
	                    movestat=false;
	                }
		         });
		    }
			return movestat;
		};
		function beforeDrag(treeId, treeNodes){
			 if(treeNodes.length<1){return false;}
			 for (var i=0,l=treeNodes.length; i<l; i++) {
				if (treeNodes[i].drag === false) {
					return false;
				}
			 }
			if(confirm("确认移动此分类吗？")){
		        return true;
			}else{
				return false;
			}
		};
		function zTreeBeforeEditName(treeId, treeNode){
			$.ajax({
	            type: "GET",
			    url: "<?php echo __URL__.'/edit/id/';?>"+treeNode.id,
			    success: function(html){
			    	 $("#show_html").css({"background":"#fff"});
			    	 tree_tid=treeNode.tId;
					 $.Smarts.showWindow(400,210,html);
	            },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
	         });
           return false;
		};
		function saveNode(){
			if(!chkFromCategory("edit_form")){
	              return false;
	        }
        	$.ajax({
	            type: "POST",
			    url: "<?php echo __URL__.'/edit';?>",
			    data:$("#edit_form").serialize(),
			    dataType:'json',
			    success: function(ref){
	               if(ref.status<1){
		               alert(ref.info);
		           }else{
		        	   var zTree = $.fn.zTree.getZTreeObj("category_tree");
		        	   var nodes = zTree.getNodeByTId(tree_tid);
		        	   nodes.name=ref.data.name;
		        	   zTree.updateNode(nodes);
		        	   $.Smarts.closeWindow();
			       }
	            },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
	         });
        };
		function filter(treeId, parentNode, childNodes) {
			if (!childNodes) return null;
			for (var i=0, l=childNodes.length; i<l; i++) {
				childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
			}
			return childNodes;
		};
        function RemoveNode(treeId,treeNode){
        	$.ajax({
	            type: "POST",
			    url: "<?php echo __URL__.'/delete';?>",
			    data:"pos[id]="+treeNode.id,
			    dataType:'json',
			    success: function(ref){
	               if(ref.status<1){
		              alert(ref.info);
		           }else{
		        	   var zTree = $.fn.zTree.getZTreeObj(treeId);
			  		       zTree.selectNode(treeNode);
		        	   var nodes = zTree.getSelectedNodes();
		        	   for (var i=0, l=nodes.length; i < l; i++) {
		        		   zTree.removeNode(nodes[i]);
		        	   }
			       }
	            },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
	         });
        };
		
		function beforeRemove(treeId, treeNode) {
			if(treeNode.tId==treeId+'_1'){
                 alert('根不能被删除');return false;
			}
			if(confirm("确认删除 “" + treeNode.name + "”分类吗？")){
				RemoveNode(treeId,treeNode);
		        return false;
			}
			return false;
		};
		
		function beforeRename(treeId, treeNode, newName) {
			if (newName.length == 0){
				alert("节点名称不能为空.");
				return false;
			}
			return true;
		};

		var newCount = 1;
		function addHoverDom(treeId, treeNode) {
			var sObj = $("#" + treeNode.tId + "_span");
			if ($("#addBtn_"+treeNode.id).length>0) return;
			var addStr = "<span class='button add' id='addBtn_" + treeNode.id
				+ "' title='新增子类' onfocus='this.blur();'></span>";
			sObj.append(addStr);
			var btn = $("#addBtn_"+treeNode.id);
			if (btn) btn.bind("click", function(){
				getAddNodeHtml(treeNode);
			});

			var aObjs = $("#" + treeNode.tId + IDMark_A);
			if ($("#diyBtn_"+treeNode.id).length>0) return;
			var editStr = "<span id='diyBtn_space_" +treeNode.id+ "' >&nbsp;</span><span class='button icon01' id='diyBtn_" +treeNode.id+ "' title='"+treeNode.name+"' onfocus='this.blur();'></span>";
			aObjs.append(editStr);
			var btns = $("#diyBtn_"+treeNode.id);
			if (btns) btns.bind("click", function(){
				getUpImgHtml(treeNode);				
			});


		
			if ($("#diyBtns_"+treeNode.id).length>0) return;
			var editStr = "<span id='diyBtns_space_" +treeNode.id+ "' >&nbsp;</span><span class='button icon02' id='diyBtns_" +treeNode.id+ "' title='"+treeNode.name+"' onfocus='this.blur();'></span>";
			aObjs.append(editStr);
			var btns = $("#diyBtns_"+treeNode.id);
			if (btns) btns.bind("click", function(){
				getExtattrinfoHtml(treeNode);				
			});
			
		};
		function getExtattrinfoHtml(treeNode){
			 var htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
		     htmls=htmls+"<iframe frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"<?php echo __URL__.'/selextattinfo/pid/'?>"+treeNode.id+"\" ></iframe>";
		     $("#show_html").css({"background":"#fff"});
		     $.Smarts.showWindow(700,400,htmls);
		}
		function getUpImgHtml(treeNode){
			 var htmls="<span class=\"closecmd\" onclick=\"$.Smarts.closeWindow()\">X</span>"; 
			     htmls=htmls+"<iframe frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"<?php echo __URL__.'/extend/pid/'?>"+treeNode.id+"\" ></iframe>";
			     $("#show_html").css({"background":"#fff"});
			     $.Smarts.showWindow(600,300,htmls);
	    }
		function getAddNodeHtml(treeNode){
        	$.ajax({
	            type: "GET",
			    url: "<?php echo __URL__.'/insert/id/';?>"+treeNode.id,
			    success: function(html){
			    	 $("#show_html").css({"background":"#fff"});
					 $.Smarts.showWindow(400,210,html);
					 tree_tid=treeNode.tId;
	            },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
	         });
        };
        function chkFromCategory(frm){
            if($("#"+frm).length>0){
                if($("#"+frm+" #name").attr("value")=="" || $("#"+frm+" #c6_code").attr("value")==""){
                    alert("请输入完整的信息");
                }else{
                    return true;
                }
            }
            return false;
        };
        
        function addNode(){
            if(!chkFromCategory("add_form")){
              return false;
            }
        	$.ajax({
	            type: "POST",
			    url: "<?php echo __URL__.'/insert';?>",
			    data:$("#add_form").serialize(),
			    dataType:'json',
			    success: function(ref){
	               if(ref.status<1){
		               alert(ref.info);
		           }else{
		        	   var zTree = $.fn.zTree.getZTreeObj("category_tree");
		        	   var nodes = zTree.getNodeByTId(tree_tid);
		        	   zTree.addNodes(nodes, ref.data);
		        	   tree_tid='';
		        	   $.Smarts.closeWindow();
			       }
	            },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
	         });
        };
		
		function removeHoverDom(treeId, treeNode) {
			$("#addBtn_"+treeNode.id).unbind().remove();
			$("#diyBtn_"+treeNode.id).unbind().remove();
			$("#diyBtn_space_" +treeNode.id).unbind().remove();
			$("#diyBtns_"+treeNode.id).unbind().remove();
			$("#diyBtns_space_" +treeNode.id).unbind().remove();
		};
        
		$(document).ready(function(){
			$.fn.zTree.init($("#category_tree"), setting);
		});
		//-->
	</SCRIPT>

<?php include_once './App/Tpl/Public/footer.php';?>