<?php
class RecommendNewsAction extends BaseAction{
	public function index(){
		import("Page",LIB_PATH.'Util');
		$hubPositionView = D('HubPositionView');
		$newsPosition = D('NewsPosition');
		$rec_page = $this->_request('page')?$this->_request('page'):1;
		$position_list = $newsPosition->_list(array('where'=>array('status'=>1,'id'=>array('neq',0)),'order'=>'id desc'));
		
		if($this->_request('search_style')){
			$where['hp_pid'] = $this->_request('search_style');
		}
		
		if($this->_request('search_name')){
			$where['n_title'] = array('like','%'.$this->_request('search_name').'%');
		}
		
		$count = $hubPositionView->_count($where);
		if($count > 0){
			$Page = new Page($count, C('PAGE_SIZE'));
			$data['where'] = $where;
			$data['firstRow'] = $Page->firstRow;
			$data['listRows'] = $Page->listRows;
			$data['order'] = 'HubPosition.sort asc';
			$list = $hubPositionView->_list($data);
			if(!empty($list)){
				foreach($list as $k => $v_list){
					$list[$k]['n_content'] = $this->clearTag(htmlspecialchars_decode($v_list['n_content']));
				}
			}
			$Page->setConfig('header', '条数据');
			$Page->setConfig('first', '<<');
			$Page->setConfig('last', '>>');
			$page = $Page->show();
			$this->assign('page', $page);
			$this->assign('rec_list',$list);
		}
		$this->assign('style_list',$position_list);
		$this->assign('rec_page',$rec_page);
		$this->display();
	}
	
	public function delete(){
		$hp_id = $this->_get('id');
		$hp_page = $this->_get('page');
		$hubPosition = D('HubPosition');
		if(!empty($hp_id)){
			$del_res = $hubPosition->del_hp(array('id'=>$hp_id));
		}
		$this->redirect('/Recommend/RecommendNews/index?page='.$hp_page);
	}
	
	public function insert(){
		$hubPosition = D('HubPosition');
		$newsView = D('NewsView');
		$newsPosition = D('NewsPosition');
		$position_id = $this->_request('pid');
		$act = $this->_request('act');
		switch ($act){
			case 'position_pass':
				if(!empty($position_id)){
					echo "<script type='text/javascript'>window.parent.location.href='/Recommend/RecommendNews/insert?act=viewNews&pid=".$position_id."'</script>";
				}else{
					echo "<script type='text/javascript'>window.parent.location.href='/Recommend/RecommendNews/insert'</script>";
				}
				break;
			case 'viewNews':
				if(!empty($position_id)){
					$hp_res = $hubPosition->get_newsId(array('position_id'=>$position_id));
					if($hp_res){
						foreach($hp_res as $v_nid){
							$newsId .= $v_nid['news_id'].',';
						}
						$newsId = substr($newsId,0,-1);
						$where['news_id'] = array('not in',$newsId);
					}
					$position = $newsPosition->find_position(array('id'=>$position_id));
					import("Page",LIB_PATH.'Util');
					$where['news_status'] = array('eq',1);
					$count = $newsView->_count($where);
					if($count > 0){
						$Page = new Page($count, C('PAGE_SIZE'));
						$data['where'] = $where;
						$data['firstRow'] = $Page->firstRow;
						$data['listRows'] = $Page->listRows;
						$data['order'] = 'NewsDetails.date desc';
						$list = $newsView->_list($data);
						if(!empty($list)){
							foreach($list as $k => $v_list){
								$list[$k]['details_content'] = $this->clearTag(htmlspecialchars_decode($v_list['details_content']));
							}
						}
						$Page->setConfig('header', '条数据');
						$Page->setConfig('first', '<<');
						$Page->setConfig('last', '>>');
						$page = $Page->show();
						$this->assign('page', $page);
						$this->assign('news_list',$list);
					}
					if(!empty($position)){
						$this->assign('position',$position);
					}
				}
				$this->display();
				break;
			default:
				$this->display();
				break;
		}
	}
	
	public function add_recNews(){
		$nid_list = $this->_post('nid_list');
		$position_id = $this->_post('pid');
		$stime = strtotime($this->_post('stime'));
		$etime = strtotime($this->_post('etime'));
		$user = $this->getUser();
		$hubPosition = D('HubPosition');
		
		$nlist_count = count($nid_list);
		if($nlist_count > 0){
			foreach($nid_list as $k => $v_nid){
				$sort_list[$v_nid] = @(int)$this->_post('sort_'.$v_nid);
			}
		}
		
		if(empty($stime)){
			$stime = time();
		}
		if(!empty($nid_list) && !empty($position_id)){
			if($stime < $etime){
				foreach($nid_list as $v_nid){
					$hubPosition->add_hp(array('news_id'=>$v_nid,'position_id'=>$position_id,'sort'=>$sort_list[$v_nid],'start_time'=>$stime,'end_time'=>$etime,'create_time'=>time(),'create_user'=>$user));
				}	
			}
		}
		
		$this->redirect('/Recommend/RecommendNews/index');
	}
	
	public function edit_sort(){
		$hp_id = $this->_get('hp_id');
		$hp_page = $this->_get('hp_page');
		$hubPositionView = D('HubPositionView');
		if(!empty($hp_id)){
			$hp_res = $hubPositionView->_find(array('hp_id'=>$hp_id));
			if($hp_res){
				$this->assign('rec_news',$hp_res);
			}	
		}
		//echo "<pre>";print_r($hp_res);echo "</pre>";exit;
		$this->assign('rec_page',$hp_page);
		$this->display();
	}
	
	public function update_sort(){
		$rec_id = $this->_post('r_id');
		$rec_page = $this->_post('r_page');
		$rec_sort = @(int)$this->_post('r_sort');
		$hubPosition = D('HubPosition');
		if(!empty($rec_id) && !empty($rec_sort)){
			$hubPosition->update_sort(array('where'=>array('id'=>$rec_id),'rec_news'=>array('sort'=>$rec_sort)));
		}
		echo "<script type='text/javascript'>window.parent.location.href='/Recommend/RecommendNews/index?page=".$rec_page."'</script>";
	}
	
	public function position_choose(){
		$newsPosition = D('NewsPosition');
		$position_list = $newsPosition->_list(array('where'=>array('status'=>1,'id'=>array('neq',0)),'order'=>'id desc'));
		$this->assign('p_list',$position_list);
		$this->display();
	}

	public function clearTag($str){
		$str = trim($str);	//清除字符串两边的空格
		$str = strip_tags($str);	//利用php自带的函数清除html格式
		$str = htmlspecialchars($str);
		$str = preg_replace('/\t/','',$str);	//使用正则表达式匹配需要替换的内容，如空格和换行，并将替换为空
		$str = preg_replace('/\r\n/','',$str);
		$str = preg_replace('/\r/','',$str);
		$str = preg_replace('/\n/','',$str);
		$str = preg_replace('/ /','',$str);
		$str = preg_replace('/ /','',$str);	//匹配html中的空格
		$str = preg_replace('/　　/','',$str);
		return trim($str);	//返回字符串
	}
	
	private function getUser(){	//获取操作者账号
		$adm = $this->_GetLoginInfo();
		if(!empty($adm['ref']['info'])){
			$user = $adm['ref']['info']['account'];
		}
		return $user;
	}

	
	
}
