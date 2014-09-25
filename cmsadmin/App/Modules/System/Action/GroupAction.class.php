<?php
class GroupAction extends AdminAction {
   public function index(){       
	   	$ref=$this->AdminRole('', '_GetListAll');
	   	if(!empty($ref['status'])){
	   		$list=$ref['ref'];
	   		import("Tree",LIB_PATH.'Util');
	   		$tree = new Tree($list);
	   		if($tree){
	   			$str="<span class='file'>\$name</span> 
	   			<a class='btn  btn-info' href='__URL__/insert/id/\$id' >新增</a> 
	   			<a class='btn  btn-danger' href='__URL__/edit/id/\$id'>修改</a>  
	   			<a class='btn btn-danger' href='__URL__/delete/id/\$id'>删除</a> 
	   			<a class='btn btn-success' href='__URL__/auth/id/\$id'>权限</a>  ";
	   			$str2="<span class='folder'>\$name</span> 
	   			<a class='btn  btn-info'  href='__URL__/insert/id/\$id'>新增</a> 
	   			<a class='btn  btn-danger'  href='__URL__/edit/id/\$id'>修改</a>  
	   			<a class='btn  btn-danger' href='__URL__/delete/id/\$id'>删除</a> 
	   			<a class='btn btn-success' href='__URL__/auth/id/\$id'>权限</a>  ";
	   			$list=$tree->get_treeview(0,'tree_class',$str,$str2);
	   			$this->assign("RoleList", $list);
	   		}
	   	}
        $this->display(); 
    }
 function insert($id=0){
       if(IS_POST){
    		$data=$this->_post('pos',true);
    		$ref=$this->AdminRole($data, '_Insert');    		
    		if ($ref['status']>0){
    			redirect(__APP__.'/system/group');
    		}else{
    			$this->error($ref['info']);
    		}
    	}else{
    		$ref=$this->AdminRole(array('id'=>$id), '_GetRow');
    		if($ref['status']>0){
    			$this->assign("row", $ref['ref']);
    		}else{
    			$this->assign("row",array('pid'=>0));
    		}
    	}
    	$this->display();
    }
   
    function edit($id=0){
      if(IS_POST){
    		$data=$this->_post('pos',true);     	
    		$ref=$this->AdminRole($data, '_Edit');
    		if ($ref['status']>0) {
    			redirect(__APP__.'/system/group');
    		} else {
    			$this->error($ref['info']);
    		}
    	}else if(!empty($id)){
    		$ref=$this->AdminRole(array('id'=>$id), '_GetRow');    		
    		if($ref['status']>0){
    			$this->assign("row", $ref['ref']);
    		}else{
    			$this->error($ref['info']);
    		}
    	}
    	$this->display();
    }
   
    function delete($id){
        if(!empty($id)) {
    		$ref=$this->AdminRole(array('id'=>$id), '_Delete');
    		 redirect(__APP__.'/system/group');
    	} else {
    		$this->error('ID错误！');
    	}
    }
   
   public function auth($id=0){
   	if(empty($id)){
   		$this->error('ID不能为空');
   	}
   	$ref=$this->AdminRole(array('id'=>$id), '_GetRow');
   	if($ref['status']>0){
   		$vo=$ref['ref'];
   		if(empty($vo)){
   			$this->error('信息不存在');
   		}
   	}else{
   		$this->error($ref['info']);
   	}
   	
   	if(IS_POST){
   		$ref=$this->AdminRole(array('role_id'=>$id), '_DeleteAccess');
   		$node_id=$this->_post('node_id');
   		if(!empty($node_id)){
   			$str='';
   			foreach ($node_id as $k=>$v){
   				if(!empty($v)){
   					$str=$str."($id,$v),";
   				}
   			}
   			if(!empty($str)){
   				$str=substr($str, 0,strlen($str)-1);
   				$ref=$this->AdminRole(array('values'=>$str), '_ExeAddAccess');
   			}
   		}
   		redirect(__URL__.'/auth/id/'.$id);die;
   	}
   	
   	$ref=$this->AdminRole(array('role_id'=>$id), '_GetAdminAccess');
   	$SelNode=array();
   	if($ref['status']>0){
   		$vo=$ref['ref'];
   		foreach ($vo as $v){
   			$SelNode[]=$v['node_id'];
   		}
   		unset($vo);
   	}
   	$ref=$this->AdminRole(array(),'_GetAccessALL');
   	$list   = $ref['ref'];
   	
   	import("Tree",LIB_PATH.'Util');
   	$tree = new Tree($list);
   	$tree->selid=$SelNode;
   	if($tree){
   		$str="<span class='file'>\$name</span> <span><input type='checkbox' value='\$id' name='node_id[]' \$checked/></span>";
   		$str2="<span class='folder'>\$name</span> <span><input type='checkbox' value='\$id' name='node_id[]'  \$checked /></span>";
   		$list=$tree->get_treeview(0,'tree_class',$str,$str2);
   	}
   	$this->assign("id", $id);
   	$this->assign("NodeList", $list);
   	$this->display();
   }
  
}