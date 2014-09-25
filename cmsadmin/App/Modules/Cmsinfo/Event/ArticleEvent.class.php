<?php
class ArticleEvent extends Action {
	/*条件*/
	function _get_where(){
		$name=$this->_request('keyword');
		$cid1=$this->_request('cid1');
		$cid2=$this->_request('cid2');
		$where=array();
		if(!empty($name)){
			$where['title|subtitle|key'] = array('like',"%$name%");
		}
		if(!empty($cid1)){
			$where['cid1'] = $cid1;
		}
		if(!empty($cid2)){
			$where['cid2'] = $cid2;
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
    	return D('Article')->data($data)->add();
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
    	return D('Article')-> where($where)->setField($data);
    }
        
    /**
     * 删除
     * @access protected
     * @param array $data 
     * @return 
     */
    function _delete($where){
    	if(!is_array($where)){ return false;}
    	return D("Article")->where($where)->delete();
    }
    /**
     * 取1
     * @access protected
     * @param array $where 条件
     * @return array
     */
    function _row($where){
    	if(!is_array($where)){ return false;}
    	return D('Article')->where($where)->find();
    }
    /**
     * 取数量
     * @access protected
     * @param array $where 条件
     * @return int
     */
    function _count($where){
    	if(count($where)<1){$where=array();}
    	return D('Article')->where($where)->count();
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
    	return D('Article')->field('id,title,sort,status,subtitle,create_time')->where($data['where'])->limit($data['firstRow']. ',' . $data['listRows'])->order('id desc')->select();
    }
}