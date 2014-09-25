<?php
class HubTypeModel extends Model{
	
	public function add_newsType($data){
		return $this->data($data)->add();
	}
	
	public function del_newsType($where){
		return $this->where($where)->delete();
	}
	
	public function update_newsType($data){
		$this->del_newsType($data['where']);
		if(!empty($data['type'])){
			foreach($data['type'] as $k => $v_type){
				$this->add_newsType(array('news_id'=>$data['where']['news_id'],'type_id'=>$v_type));
			}
		}
	}
	
	
}