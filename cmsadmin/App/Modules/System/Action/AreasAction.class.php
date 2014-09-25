<?php
class AreasAction extends AreasInfoAction{
	//分类管理首页
     function index(){        	
     	if(IS_POST){
     		$id=$this->_request('id',true);
    		if(empty($id)){
    			$ref= $this->getRoot(1);
    		}else if(is_numeric($id)){
    			$ref= $this->_getChildList($id);
    		}
    		echo json_encode($ref);
    		die;
    	} 
    	$this->display();
    }
    function insert(){
    	$this->display();
    }
    function edit(){
    	$this->display();
    }
    function delete(){
    	$this->display();
    }
}