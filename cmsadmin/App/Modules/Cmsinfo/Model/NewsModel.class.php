<?php
class NewsModel extends Model{
	public function add_news($data){
		$data['title'] = trim($data['title']);
		$data['create_time'] = time();
		return $this->data($data)->add();
	}
	
	public function _count($where){
		return $this->where($where)->count();
	}
	
	public function find_news($where){
		return $this->where($where)->find();
	}
	
	public function del_news($where){
		return $this->where($where)->delete();
	}
	
	public function update_news($data){
		return $this->where($data['where'])->data($data['news'])->save();
	}
	
	
	
}