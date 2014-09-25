<?php
// +----------------------------------------------------------------------
// | Description:管理结点控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2013 宝苑国际  All rights reserved.
// +----------------------------------------------------------------------
// | Author: xuezheng.chang <xuezheng.chang@hotmail.com>
// +----------------------------------------------------------------------
class NodeAction extends AdminAction{
    function index(){
    	$ref=$this->AdminNode('', '_GetListAll');
    	if(!empty($ref['status'])){
    		$list=$ref['ref'];
    		import("Tree",LIB_PATH.'Util');
    		$tree = new Tree($list);
    		if($tree){
    			$str="<span class='file'>\$name</span> <a class='btn  btn-info' href='__URL__/insert/id/\$id' >新增</a> <a class='btn  btn-danger' href='__URL__/edit/id/\$id'>修改</a>  <a class='btn btn-danger' href='__URL__/delete/id/\$id'>删除</a>";
    			$str2="<span class='folder'>\$name</span> <a class='btn  btn-info'  href='__URL__/insert/id/\$id'>新增</a> <a class='btn  btn-danger'  href='__URL__/edit/id/\$id'>修改</a>  <a class='btn  btn-danger' href='__URL__/delete/id/\$id'>删除</a>";
    			$list=$tree->get_treeview(0,'tree_class',$str,$str2);
    			$this->assign("NodeList", $list);
    		}
    	}    	
        $this->display();
    }
    
    function insert($id=0){
       if(IS_POST){
    		$data=$this->_post('pos',true);
    		$ref=$this->AdminNode($data, '_Insert');    		
    		if ($ref['status']>0){
    			redirect(__APP__.'/system/node');
    		}else{
    			$this->error($ref['info']);
    		}
    	}else{
    		$ref=$this->AdminNode(array('id'=>$id), '_GetRow');
    		if($ref['status']>0){
    			$this->assign("row", $ref['ref']);
    		}else{
    			$this->assign("row",array('pid'=>0,'level'=>0));
    		}
    	}
    	$this->display();
    }
   
    function edit($id=0){
      if(IS_POST){
    		$data=$this->_post('pos',true);     	
    		$ref=$this->AdminNode($data, '_Edit');
    		if ($ref['status']>0) {
    			redirect(__APP__.'/system/node');
    		} else {
    			$this->error($ref['info']);
    		}
    	}else if(!empty($id)){
    		$ref=$this->AdminNode(array('id'=>$id), '_GetRow');    		
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
    		$ref=$this->AdminNode(array('id'=>$id), '_Delete');
    		 redirect(__APP__.'/system/node');
    	} else {
    		$this->error('ID错误！');
    	}
    }
}