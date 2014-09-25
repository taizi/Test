<?php
class AreasInfoAction extends BaseAction{
	//获取根结点
	 function getRoot($id=1){
		$row=$this->_getNode($id);
		$row['isParent']=false;
		if(!empty($row)){
			$nums=$this->_getChildNum($row['area_id']);
			if($nums>0){
				$row['isParent']=true;
				$row['open']=true;
				$row['pId']=0;
				$list=array(0=>$row);
				$ref=$this->_getChildList($id);
				$row=array_merge_recursive($list,$ref);
			}
		}
		return $row;
	}
	function _getChildList($id){
		$ref=$this->_getChild($id);
		if(!empty($ref)){
			foreach ($ref as $k=>$v){
				$ref[$k]['isParent']=false;
				if($v['nums']>0){
					$ref[$k]['isParent']=true;
				}
			}
		}
		return $ref;
	}
	function _getPareng($id){
		
	}	
	function _getChild($id=0){
		return D('Areas')->query("select area_id as id,area_name as name,parent_id as pId,(select count(area_id) from ".D('Areas')->getTableName()." where parent_id=a.area_id) as nums from ".D('Areas')->getTableName()." a where parent_id=$id");
		//return D('Areas')->where("parent_id=$id")->field("area_id as id,area_name as name,parent_id as pId")->select();
	}	
	function _getNode($id=0){
		return D('Areas')->where("area_id=$id")->field("*,area_id as id,area_name as name,parent_id as pId")->find();
	}
	function _getChildNum($id=0){
		return D('Areas')->where("parent_id=$id")->count();
	}
	function _insert($data){
		return D('Areas')->data($data)->add();
	}
	function _edit($id,$data){
		return D('Areas')->where("area_id=$id")->setField($data);
	}
	function _deleteNode($id){
		return D('Areas')->where("area_id=$id")->field();
	}	
	
}