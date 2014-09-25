<?php
class NewsDetailsModel extends Model{
	
	public function add_details($data){
		if(empty($data['content'])){
			$data['content'] = '未知';
		}else{
			$data['content'] = trim($data['content']);
		}
		if(empty($data['date'])){
			$data['date'] = 0;
		}
		$data['source'] = trim($data['source']);
		$data['create_time'] = time();
		return $this->data($data)->add();
	}
	
	public function find_details($where){
		return $this->where($where)->find();
	}
	
	public function del_details($where){
		return $this->where($where)->delete();
	}

	public function update_details($data){
		return $this->where($data['where'])->data($data['details'])->save();
	}
	
	
	
	
}