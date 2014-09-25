<?php
class ArticleClassEvent extends Action {
	/*条件*/
	function _get_where(){
		$name=$this->_request('keyword');
		$where=array();
		if(!empty($name)){
			$where['name'] = array('like',"%$name%");
		}
		return $where;
	}
    /**
	 * 增加
	 * @access protected
	 * @param int  
	 * @return int 
	 */
    function _insert($data){
    	if(!is_array($data)){ return false; }
    	$data['create_time']=strtotime("now");   
    	return D('ArticleClass')->data($data)->add();
    }
    /**
     * 修改
     * @access protected
     * @param  $data,$id
     * @return 
     */
    function _edit($data,$where){
    	if(!is_array($data)){ return false; }
    	unset($data['id']);
    	return D('ArticleClass')-> where($where)->setField($data);
    }
        
    /**
     * 删除
     * @access protected
     * @param array $data 
     * @return 
     */
    function _delete($where){
    	if(!is_array($where)){ return false;}
    	return D("ArticleClass")->where($where)->delete();
    }
    
    /**
     * 取1
     * @access protected
     * @param array $where 条件
     * @return array
     */
    function _row($where){
    	if(!is_array($where)){ return false;}
    	return D('ArticleClass')->where($where)->find();
    }
    /**
     * 取数量
     * @access protected
     * @param array $where 条件
     * @return int
     */
    function _count($where){
    	if(count($where)<1){$where=array();}
    	return D('ArticleClass')->where($where)->count();
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
    	return D('ArticleClass')->where($data['where'])->limit($data['firstRow']. ',' . $data['listRows'])->order('id desc')->select();
    }
}