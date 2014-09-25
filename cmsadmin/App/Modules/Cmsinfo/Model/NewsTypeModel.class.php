<?php
class NewsTypeModel extends Model{
	public function getType($where=array(),$order='sort asc'){
		return $this->where($where)->field('id,type_name,sort')->order($order)->select();
	}
	
	public function _count($where){
		return $this->where($where)->count();
	}
	
	public function _list($data){
		return $this->where($data['where'])->field('id,type_name,description,status,sort')->limit($data['firstRow'],$data['listRows'])->order($data['order'])->select();
	}
	
	public function find_type($where){
		return $this->where($where)->find();
	}
	
	public function add_type($data){
		return $this->data($data)->add();
	}
	
	public function del_type($where){
		return $this->where($where)->delete();
	}
	
	public function update_type($data){
		return $this->where($data['where'])->data($data['type'])->save();
	}
	
}