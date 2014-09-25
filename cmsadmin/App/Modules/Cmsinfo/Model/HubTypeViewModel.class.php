<?php
class HubTypeViewModel extends ViewModel{
	public $viewFields = array(
			'HubType'=>array('news_id'=>'nid','_type'=>'left'),
			'NewsType'=>array('id'=>'type_id','type_name'=>'news_type','_on'=>'HubType.type_id=NewsType.id','_type'=>'left')
	);
	
	public function type_list($data){
		return $this->where($data['where'])->field('news_type,type_id')->order('NewsType.sort asc')->select();
	}
	
	
	
	
	
}