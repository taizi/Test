<?php
class HubPositionModel extends Model{
	
	public function add_newsPosition($data){
		return $this->data($data)->add();
	}
	
	public function del_newsPosition($where){
		return $this->where($where)->delete();
	}
	
	public function update_newsPosition($data){
		$this->del_newsPosition($data['where']);
		if(!empty($data['position'])){
			foreach($data['position'] as $k => $v_position){
				$this->add_newsPosition(array('news_id'=>$data['where']['news_id'],'position_id'=>$v_position));
			}
		}
	}
	
	
}