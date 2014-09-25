<?php
class HubPositionModel extends Model{
	
	public function add_hp($data){
		return $this->data($data)->add();
	}
	
	public function del_hp($where){
		return $this->where($where)->delete();
	}
	
	public function get_newsId($where){
		return $this->where($where)->field('news_id')->select();
	}
	
	public function update_sort($data){
		return $this->where($data['where'])->data($data['rec_news'])->save();
	}
	
}
