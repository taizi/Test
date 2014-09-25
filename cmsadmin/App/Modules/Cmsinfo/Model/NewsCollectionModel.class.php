<?php
class NewsCollectionModel extends Model{
	public function add_news($title,$summary,$content,$author,$source,$date,$keyword,$cover,$user){
		$date = str_replace(array('年','月'),'-',trim($date));
		$date = str_replace('日',' ',$date);
		$un_date = strtotime($date);
		
		$keyword = strip_tags($keyword);	//利用php自带的函数清除html格式
		$keyword = htmlspecialchars($keyword);
		
		$source = strip_tags($source);
		$source = htmlspecialchars($source);
		
		$data['un_title'] = trim($title);	//标题
		$data['un_summary'] = trim($summary);	//简介
		$data['un_content'] = trim($content);	//内容
		$data['un_author'] = trim($author);	//作者
		$data['un_source'] = trim($source);	//来源
		$data['un_date'] = $un_date;	//日期
		$data['un_keyword'] = trim($keyword);	//关键字
		$data['un_cover'] = trim($cover);	//封面图
		$data['create_time'] = time();	//创建时间
		$data['create_user'] = $user;	//操作账号
		return $this->data($data)->add();
	}
	
	public function del_news($where){
		return $this->where($where)->delete();
	}

	public function _count($where){	//查询文章数量
		return $this->where($where)->count();
	}

	public function _list($data){
		if(empty($data['order'])){
			$data['order'] = 'un_date desc';
		}
		return $this->where($data['where'])->limit($data['firstRow'],$data['listRows'])->order($data['order'])->select();
	}

	public function un_news($where){
		return $this->where($where)->find();
	}
	
	public function un_news_list($where,$order='un_date desc'){
		return $this->where($where)->order($order)->select();
	}
	
	public function change_status($where,$user){
		$data['un_status'] = 1; 
		$data['create_user'] = $user;
		return $this->data($data)->where($where)->save();
	}
	
}