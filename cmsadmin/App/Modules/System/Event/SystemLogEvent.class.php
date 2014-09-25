<?php
class SystemLogEvent extends Action {

    /**
     * 删除
     * @access protected
     * @param array $data 
     * @return 
     */
    function _delete($where){
    	if(!is_array($where)){ return false;}
    	return D("AdminLog")->where($where)->delete();
    }
    
    function _get_where(){
    	$pos=$this->_request('pos');
    	$where=array();
    	if(!empty($pos['keyword'])){
    		$where['node3|username|truename|reqtype'] = array('like',"%".$pos['keyword']."%");
    	}
    	if(!empty($pos['stime']) && !empty($pos['etime'])){
    		$where['create_time']=array('between',array(strtotime($pos['stime']),strtotime($pos['etime'])));
    	}
    	return $where;
    }     
    /**
     * 取数量
     * @access protected
     * @param array $where 条件
     * @return int
     */
    function _count($where){
    	if(count($where)<1){$where=array();}
    	return D('AdminLog')->where($where)->count();
    }
    /**
     * 取列表
     * @access protected
     * @return array status 
     */
    function _list($data=array()){
    	if(count($data['where'])<1){
    		$data['where']=array();
    	}	
    	return D('AdminLog')->where($data['where'])->limit($data['firstRow']. ',' . $data['listRows'])->order('id desc')->select();
    }
}