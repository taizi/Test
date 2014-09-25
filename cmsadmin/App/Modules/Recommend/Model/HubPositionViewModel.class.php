<?php
class HubPositionViewModel extends ViewModel{
	public $viewFields = array(
			'HubPosition'=>array('id'=>'hp_id','news_id'=>'hp_nid','position_id'=>'hp_pid','sort'=>'hp_sort','start_time'=>'hp_stime','end_time'=>'hp_etime','_type'=>'left'),
			'NewsPosition'=>array('position_name'=>'p_name','description'=>'p_description','status'=>'p_status','_on'=>'HubPosition.position_id=NewsPosition.id','_type'=>'left'),
			'News'=>array('title'=>'n_title','_on'=>'HubPosition.news_id=News.id','_type'=>'left'),
			'NewsDetails'=>array('content'=>'n_content','date'=>'n_date','_on'=>'News.id=NewsDetails.nid','_type'=>'left')
	);
	
	public function _list($data){
		return $this->where($data['where'])->field('hp_id,n_title,n_content,n_date,p_name,p_description,hp_stime,hp_etime,hp_sort')->limit($data['firstRow'],$data['listRows'])->order($data['order'])->select();  
	}
	
	public function _count($where){
		return	$this->where($where)->count();
	}
	
	public function _find($where){
		return $this->where($where)->find();
	}

}