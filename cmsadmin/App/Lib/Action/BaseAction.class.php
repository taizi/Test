<?php
class BaseAction extends AdminAccessAction{
	var $admin_login_info;
    function _initialize() {
    	$ref=$this->_AccessDecision();
        if(empty($ref['status'])){
        	if(IS_AJAX){
        	   $ref['status']=0;
        	   $ref['info']='操作失败，您没有此操作权限';
        	  echo json_encode($ref);die;
        	}else{
        	  $this->error('暂无权限，或登录超时','/');
        	}
        }
        $this->_ReSetLogin();
        $admin=$this->_GetLoginInfo();
    	$this->admin_login_info=$admin['ref'];   
        $this->assign("admin_login_info", $this->admin_login_info);
        if(!empty($this->admin_login_info['menu'][0])){
        	$this->assign("admin_login_role_id", $this->admin_login_info['menu'][0]['role_id']);
        }
        $this->write_log();
        if(!IS_AJAX){
        	$accessList=!empty($ref['menu'])?$ref['menu']:0;
        	$menu=array();
        	if(!empty($accessList)){
	        	import("ArrayNode",LIB_PATH.'Util');
	        	$tree=new ArrayNode($accessList);
	        	if($tree){
	        		$menu=$tree->getResult();
	        	}
        	}
           $this->left_menu=$menu;
        }        
    }
    
    function write_log(){
    	$data['url']=__SELF__;
    	$data['node1']=GROUP_NAME;
    	$data['node2']=MODULE_NAME;
    	$data['node3']=ACTION_NAME;
    	$info=array();
    	if(!empty($_GET)){	$info['get']=$_GET;}
    	if(!empty($_POST)){ $info['post']=$_POST; }   
    	$info=json_encode($info);
    	$data['data']=$info;
    	if(IS_POST){
    	   $data['reqtype']='POST';
    	}else if(IS_GET){
    		$data['reqtype']='GET';
    	}else if(IS_AJAX){
    		$data['reqtype']='AJAX';
    	}else{
    		$data['reqtype']='未知';
    	}
    	
    	$data['username']=$this->admin_login_info['info']['account']; 
    	$data['truename']=$this->admin_login_info['info']['nickname'];
    	$data['create_time']=strtotime("now");
    	$data['ip']=get_client_ip();
    	D('AdminLog')->data($data)->add();
    }
    
}