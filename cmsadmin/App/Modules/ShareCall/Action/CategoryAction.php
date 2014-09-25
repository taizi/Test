<?php
class CategoryAction extends ProductCategoryAction{
    function getNodeList($id=1){
    	$data='';
    	$status=0;
    	$info='false';
    	$row=$this->_getNodeInfo(array($id));
    	if(!empty($row)){
    		$data=$this->_whereChild($row);
    		$info='true';
    		$status=1;
    	}
    	$this->ajaxReturn($data,$info,$status,"JSON");
    }
}