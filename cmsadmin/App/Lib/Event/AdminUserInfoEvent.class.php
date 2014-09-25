<?php
class AdminUserInfoEvent extends BaseAction {
    /**
	 * 管理员增加
	 * @access protected
	 * @param array $data 结点信息
	 * @return array status  0: 加入失败，1:成功  info:消息
	 */
    function _Insert($data){
    	if(!is_array($data)){ $ref['status']=0; $ref['info']='参数错误';return $ref; }
    	$ref['status']=0;
    	$data['update_time']=$data['create_time']=strtotime("now");    	
    	if(!empty($data['password'])){
    		$data['password']=md5($data['password']);
    	}
    	
    	$model = D('Admin');    	
    	$admin=$this->_GetCount(array('account'=>$data['account']));
    	if($admin['status']>0){
    		$ref['info']='用户有重名';
    		return $ref;
    	}
    	$model->data($data)->add();
    	
    	if($model->getError()){
    		$ref['info']=$model->getError();
    	}else{
    		$ref['status']=1;
    		$ref['info']='完成';
    	}
    	return $ref;
    }
    /**
     * 管理员修改
     * @access protected
     * @param array $data 结点信息
     * @return array status  0: 失败，1:成功  info:消息
     */
    function _Edit($data){
    	if(!is_array($data)){ $ref['status']=0; $ref['info']='参数错误';return $ref; }
    	$model = D('Admin');
    	$ref['status']=0;
    	$id=$data['id'];unset($data['id']);
    	$data['update_time']=strtotime("now");
    	if(!empty($data['password'])){
    		$data['password']=md5($data['password']);
    	}
    	$model-> where('id='.$id)->setField($data);
    	if($model->getError()){
    		$ref['info']=$model->getError();
    	}else{    	
    		$ref['info']='完成';
    		$ref['status']=1;
    	}
    	return $ref;
    }
        
    /**
     * 删除管理员
     * @access protected
     * @param array $data 删除结点条件
     * @return array status  0: 失败，1:成功  info:消息
     */
    function _Delete($where){
    	if(!is_array($where)){ $ref['status']=0; $ref['info']='参数错误';return $ref;}
    	$ref['status']=0;
    	$ref['info']='';   
    	$model=D("Admin");
    	$model->where($where)->delete();
    	if($model->getError()){	
    		$ref['info']=$model->getError();
    	 }else{
    	 	D("AdminRoleUser")->where('user_id='.$where['id'])->delete();
    	 	$ref['status']=1;
    	 	$ref['info']='删除完成';
    	 }
    	return $ref;
    }
    
    /**
     * 返回一个管理员信息
     * @access protected
     * @param array $where 条件
     * @return array status  0: 失败，1:成功  info:消息,ref: 返回数组
     */
    function _GetRow($where){
    	if(!is_array($where)){ return 0;}
    	$ref['status']=0;$ref['info']='';
    	$model=D('Admin');
    	$r=$model->where($where)->find();
    	if($r){
    		$ref['status']=1;
    		$ref['ref']=$r;
    	}else if($model->getError()){
    		$ref['info']=$model->getError();
    	}else{
    		$ref['info']='无信息';
    	}
    	return $ref;
    }
    /**
     * 返回统计数
     * @access protected
     * @param array $where 条件
     * @return array status  0: 失败，1:成功  info:消息,ref:返回整数
     */
    
    function _GetCount($where){
    	$ref['status']=0;$ref['info']='';
    	$model=D('Admin');
    	if(count($where)<1){$where=array();}
    	$r=$model->where($where)->count();
    	if($r>0){
    		$ref['status']=1;
    		$ref['ref']=$r;
    	}else if($model->getError()){
    		$ref['info']=$model->getError();
    	}else{
    		$ref['info']='无信息';
    	}
    	return $ref;
    }
    
    /**
     * 返回管理列表
     * @access protected
     * @return array status  0: 失败，1:成功  info:消息,ref: 返回数组
     */
    function _GetList($data=array()){
    	$ref['status']=0;$ref['info']='';
    	$model=D('Admin');
    	if(count($data['where'])<1){
    		$data['where']=array();
    	}	
    	$r   = $model->where($data['where'])->limit($data['firstRow']. ',' . $data['listRows'])->order('id desc')->select();
    	
    	if($r){
    		$ref['status']=1;
    		$ref['ref']=$r;
    	}else if($model->getError()){
    		$ref['info']=$model->getError();
    	}else{
    		$ref['info']='无信息';
    	}
    	return $ref;
    }
    
    /**
     * 返回管理列表
     * @access protected
     * @return array status  0: 失败，1:成功  info:消息,ref: 返回数组
     */
   function _GetAdminRole($data=array()){
		   	$ref['status']=0;$ref['info']='';
		   	$model=D('AdminRoleUser');
		   	if(count($data['where'])<1){
		   		$data['where']=array();
		   	}
		   	$r   = $model->where($data['where'])->field('role_id')->select();
		   	
		   	if($r){
		   		$ref['status']=1;
		   		$ref['ref']=$r;
		   	}else if($model->getError()){
		   		$ref['info']=$model->getError();
		   	}else{
		   		$ref['info']='无信息';
		   	}
		   	return $ref;
   }
   
   /**
    * 返回管理组
    * @access protected
    * @return array status  0: 失败，1:成功  info:消息,ref: 返回数组
    */
   function _GetRoleALL($data=array()){
	   	$ref['status']=0;$ref['info']='';$ref['ref']='';
	   	$model=D('AdminRole');
	   	if(count($data['where'])<1){
	   		$data['where']=array();
	   	}
	   	$r=$model->order('id asc')->getField('id,name,pid as parent_id');
	   	if($r){
	   		$ref['status']=1;
	   		$ref['ref']=$r;
	   	}else if($model->getError()){
	   		$ref['info']=$model->getError();
	   	}else{
	   		$ref['info']='无信息';
	   	}
	   	return $ref;
   }
   
   /**
    * 清除管理员组
    * @access protected
    * @param array $where 
    * @return array status  0: 失败，1:成功  info:消息
    */
   function _DeleteRole($where){
   	if(!is_array($where)){
   		$ref['status']=0; $ref['info']='参数错误';return $ref;
   	}
   	$ref['status']=0;
   	$ref['info']='';
   	$model=D("AdminRoleUser");
   	$model->where($where)->delete();
   	if($model->getError()){
   		$ref['info']=$model->getError();
   	}else{   		
   		$ref['status']=1;
   		$ref['info']='完成';
   	}
   	return $ref;
   }
   
   /**
    * 增加管理员组
    * @access protected
    * @param array $data
    * @return array status  0: 失败，1:成功  info:消息
    */
   function _ExeAddRole($data){
   	if(!is_array($data)){
   		$ref['status']=0; $ref['info']='参数错误';return $ref;
   	}
   	$ref['status']=0;
   	$ref['info']='';
   	$string=$data['values'];   	
   	$m =  D('AdminRoleUser');
   	$m->query("insert  __TABLE__(user_id,role_id)values $string");   
   	if($m->getError()){
   		$ref['info']=$m->getError();
   	}else{
   		$ref['status']=1;
   		$ref['info']='完成';
   	}
   	return $ref;
   }
   
   
}