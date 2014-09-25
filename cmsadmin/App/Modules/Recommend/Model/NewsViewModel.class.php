<?php
class NewsViewModel extends ViewModel{
	public $viewFields = array(
			'News'=>array('id'=>'news_id','title'=>'news_title','cover','summary','keyword','status'=>'news_status','sort'=>'news_sort','_type'=>'left'),
			'NewsDetails'=>array('subject'=>'details_subject','content'=>'details_content','author'=>'details_author','source'=>'details_source','date'=>'details_date','_on'=>'News.id=NewsDetails.nid','_type'=>'left')
	);
	
	public function _list($data){
		return $this->where($data['where'])->field('news_id,news_title,summary,keyword,news_status,news_sort,details_subject,details_content,details_author,details_source,details_date')->limit($data['firstRow'],$data['listRows'])->order($data['order'])->select();  
	}
	
	public function _count($where){
		return	$this->where($where)->count();
	}
	

}