<?php
class NewsCoverModel extends Model{
	public function add_cover($data){
		return $this->data($data)->add();
	}
	
	public function news_cover($where){
		return $this->where($where)->find();
	}
	
	public function update_cover($data){
		return $this->where($data['where'])->data($data['cover'])->save();
	}
	
}