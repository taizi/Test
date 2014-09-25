<?php
class AdminNodeInfoEvent extends BaseAction {
    /**
	 * 结点增加
	 * @access protected
	 * @param array $data 结点信息
	 * @return array status  0: 加入失败，1:成功  info:消息
	 */
    function _Insert($data){
    	if(!is_array($data)){ $ref['status']=0; $ref['info']='参数错误';return $ref; }
    	$model = D('AdminNode');
    	$ref['status']=0;
        $data['status']=1;
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
     * 结点修改
     * @access protected
     * @param array $data 结点信息
     * @return array status  0: 失败，1:成功  info:消息
     */
    function _Edit($data){
    	if(!is_array($data)){ $ref['status']=0; $ref['info']='参数错误';return $ref; }
    	$model = D('AdminNode');
    	$ref['status']=0;
    	$id=$data['id'];
    	unset($data['id']);   
    	
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
     * 删除结点
     * @access protected
     * @param array $data 删除结点条件
     * @return array status  0: 失败，1:成功  info:消息
     */
    function _Delete($where){
    	if(!is_array($where)){ $ref['status']=0; $ref['info']='参数错误';return $ref;}
    	$ref['status']=0;
    	$ref['info']='';   
    	$model=D("AdminNode");
    	$model->where($where)->delete();
    	if($model->getError()){
    		$ref['info']=$model->getError();
    	}else{    	
    		D("AdminAccess")->where('node_id='.$where['id'])->delete();
    		$ref['status']=1;
    		$ref['info']='删除完成';
    	}
    	return $ref;    	
    }
    
    /**
     * 返回一个结点信息
     * @access protected
     * @param array $where 条件
     * @return array status  0: 失败，1:成功  info:消息,ref: 返回数组
     */
    function _GetRow($where){
    	if(!is_array($where)){ return 0;}
    	$ref['status']=0;$ref['info']='';
    	$model=D('AdminNode');
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
     * 返回所有结点数组
     * @access protected
     * @return array status  0: 失败，1:成功  info:消息,ref: 返回数组
     */
    function _GetListAll($where=array()){
    	$ref['status']=0;$ref['info']='';
    	$model=D('AdminNode');    	
    	$r=$model->order('sort asc')->getField('id,title as name,pid as parent_id');
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
}