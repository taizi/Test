<?php
class ManageAction extends AdminAction {
	
	public function index(){		
		import("Page",LIB_PATH.'Util');
		$where=array();
		$ref=$this->AdminUser($where, '_GetCount');
		
		if(!empty($ref['status'])){
			$count=$ref['ref'];
			$Page = new Page($count, C('PAGE_SIZE'));
			$data['where']=$where;
			$data['firstRow']=$Page->firstRow;
			$data['listRows']=$Page->listRows;
			$list=$this->AdminUser($data, '_GetList');			
			// 设置分页显示
			$Page->setConfig('header', '条数据');
			$Page->setConfig('first', '<<');
			$Page->setConfig('last', '>>');
			$page = $Page->show();
			$this->assign("page", $page);
			if(!empty($list['status'])){
				$this->assign("UserList", $list['ref']);
			}
		}
		$this->display();
	}
    
    public function edit($id=0){
    	if(IS_POST){
    		$data=$this->_post('pos',true);    		
    		if(empty($data['password'])){
    			unset($data['password']);
    		}
    		$ref=$this->AdminUser($data, '_Edit');
    		if ($ref['status']>0) {
    			redirect(__APP__.'/system/manage');
    		} else {
    			$this->error($ref['info']);
    		}
    	}else if(!empty($id)){
    		$ref=$this->AdminUser(array('id'=>$id), '_GetRow');    		
    		if($ref['status']>0){
    			$this->assign("row", $ref['ref']);
    		}else{
    			$this->error($ref['info']);
    		}
    	}
    	$this->display();
    }
    
    public function insert() {
    	if(IS_POST){
    		$data=$this->_post('pos',true);
    		$ref=$this->AdminUser($data, '_Insert');    		
    		if ($ref['status']>0){
    			redirect(__APP__.'/system/manage');
    		}else{
    			$this->error($ref['info']);
    		}
    	}
       $this->display();
    }
    
    public function delete($id=0){
    	if(!empty($id)) {
    		$ref=$this->AdminUser(array('id'=>$id), '_Delete');
    		 redirect(__APP__.'/system/manage');
    	} else {
    		$this->error('ID错误！');
    	}
    }
    
    public function role($id=0){    	
    	if(empty($id)){
    		$this->error('ID不能为空');
    	}    	
    	$ref=$this->AdminUser(array('id'=>$id), '_GetRow');
    	//echo "<pre>";print_r($ref);echo "</pre>";
    	if($ref['status']>0){
    		$vo=$ref['ref'];
    		if(empty($vo)){  $this->error('用户不存在'); }
    	}else{
    		 $this->error($ref['info']);
    	}    	
    	
    	if(IS_POST){
    		$ref=$this->AdminUser(array('user_id'=>$id), '_DeleteRole');    		
    		$role_id=$this->_post('role_id');
    		if(!empty($role_id)){
    			$str='';
    			foreach ($role_id as $k=>$v){
    				if(!empty($v)){
    					$str=$str."($id,$v),";
    				}
    			}
    			if(!empty($str)){
    				$str=substr($str, 0,strlen($str)-1);    				
    				$ref=$this->AdminUser(array('values'=>$str), '_ExeAddRole');    				
    			}
    		}
    		redirect(__URL__.'/role/id/'.$id);die;
    	}
    	
    	$ref=$this->AdminUser(array('where'=>array('user_id'=>$id)), '_GetAdminRole');
    	
    	if($ref['status']>0){
    		$SelRole=array();
    		$vo=$ref['ref'];
    		foreach ($vo as $v){
    			$SelRole[]=$v['role_id'];
    		}
    		unset($vo);
    	}
    	$ref=$this->AdminUser(array(),'_GetRoleALL');
    	$list   = $ref['ref'];  
    	import("Tree",LIB_PATH.'Util');
    	$tree = new Tree($list);
    	$tree->selid=$SelRole;
    	if($tree){
    		$str="<span class='file'>\$name</span> <span><input type='checkbox' value='\$id' name='role_id[]' \$checked/></span>";
    		$str2="<span class='folder'>\$name</span> <span><input type='checkbox' value='\$id' name='role_id[]'  \$checked /></span>";
    		$list=$tree->get_treeview(0,'tree_class',$str,$str2);
    	}
    	$this->assign("id", $id);
    	$this->assign("RoleList", $list);    	
    	$this->display();
    }
    
    
}