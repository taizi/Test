<?php
class NewsPositionModel extends Model{
	public function _list($data=array()){
		return $this->where($data['where'])->field('id,position_name,description,status,sort')->order($data['order'])->select(); 
	}
	
	public function find_position($where){
		return $this->where($where)->find();
	}
	
}