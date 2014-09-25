<?php
class NewsPositionModel extends Model{
	public function getPosition($where=array(),$order='sort asc'){
		return $this->where($where)->field('id,position_name,sort')->order($order)->select();
	}
	
	public function _list($data=array()){
		return $this->where($data['where'])->field('id,position_name,description,status,sort,create_time')->limit($data['firstRow'],$data['listRows'])->order($data['order'])->select(); 
	}
	
	public function _count($where){
		return $this->where($where)->count();
	}
	
	public function add_position($data){
		return $this->data($data)->add();
	}
	
	public function find_position($where){
		return $this->where($where)->find();
	}
	
	public function update_position($data){
		return $this->where($data['where'])->data($data['position'])->save();
	}
	
	public function del_position($where){
		return $this->where($where)->delete();
	}
	
	
}