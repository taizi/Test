<?php
class AuditAction extends BaseAction{
	public function index(){
		import("Page",LIB_PATH.'Util');
		$newsView = D('NewsView');
		$news_page = $this->_request('page');
		
		if($this->_request('search_style')){
			switch ($this->_request('search_style')){
				case 1:
					$where['news_status'] = array('eq',1);
					break;
				case 2:
					$where['news_status'] = array('eq',2);
					break;
				case 3:
					$where['news_status'] = array('eq',0);
					break;
				default:
					break;
			}
		}
		
		if($this->_request('search_filter')){
			switch ($this->_request('search_filter')){
				case 'name':
					if($this->_request('search_name')){
						$where['news_title'] = array('like','%'.$this->_request('search_name').'%');
					}
					break;
				case 'num':
					if($this->_request('search_name')){
						$nid = $this->_request('search_name');
						$where['news_id'] = array('eq',@(int)$nid);
					}
					break;
				default:
					if($this->_request('search_name')){
						$where['news_title'] = array('like','%'.$this->_request('search_name').'%');
					}
					break;
			}
		}
		
		$count = $newsView->_count($where);
		if($count > 0){
			$Page = new Page($count, C('PAGE_SIZE'));
			$data['where'] = $where;
			$data['firstRow'] = $Page->firstRow;
			$data['listRows'] = $Page->listRows;
			$list = $newsView->_list($data);
			if(!empty($list)){
				foreach($list as $k => $v_list){
					switch ($v_list['news_status']){
						case 0:
							$list[$k]['status'] = '未审核';
							break;
						case 1:
							$list[$k]['status'] = '已启用';
							break;
						case 2:
							$list[$k]['status'] = '已禁用';
							break;
					}
				}
			}
			$Page->setConfig('header', '条数据');
			$Page->setConfig('first', '<<');
			$Page->setConfig('last', '>>');
			$page = $Page->show();
			$this->assign("page", $page);
			$this->assign("news_list", $list);
			$this->assign('news_page',$news_page);
		}
		$this->display();
	}
	
	public function full(){
		$newsView = D('NewsView');
		$news_page = $this->_request('page');
		$news_id = $this->_get('id');
		if(!empty($news_id)){
			$list = $newsView->_list(array('where'=>array('news_id'=>$news_id)));
			if(!empty($list)){
				foreach($list as $k => $v_list){
					switch ($v_list['news_status']){
						case 0:
							$list[$k]['status'] = '未审核';
							break;
						case 1:
							$list[$k]['status'] = '已通过';
							break;
						case 2:
							$list[$k]['status'] = '已禁用';
							break;
					}
				}
				$this->assign('news_list',$list[0]);
			}
		}
		$this->assign('page',$news_page);
		$this->display();
	}
	
	public function verify(){
		$news_id = $this->_post('news_id');
		$news_page = $this->_post('news_page');
		$news_status = $this->_post('news_status');
		$user = $this->getUser();
		$news = D('News');
		if(!empty($news_id)){
			$param_news['where'] = array('id'=>$news_id);
			$param_news['news'] = array('status'=>1,'verify_user'=>$user,'verify_time'=>time());
			if($news_status == 0){
				$news->update_news($param_news);
			}
		}
		$this->redirect('/Cmsinfo/Audit/index?page='.$news_page);
	}
	
	public function disable(){
		$news_id = $this->_get('id');
		$news_page = $this->_get('page');
		$news = D('News');
		$user = $this->getUser();
		if(!empty($news_id)){
			$param_news['where'] = array('id'=>$news_id);
			$param_news['news'] = array('status'=>2,'verify_user'=>$user,'verify_time'=>time());
			$news->update_news($param_news);
		}
		$this->redirect('/Cmsinfo/Audit/index?page='.$news_page);
	}
	
	public function undisable(){
		$news_id = $this->_get('id');
		$news_page = $this->_get('page');
		$news = D('News');
		$user = $this->getUser();
		if(!empty($news_id)){
			$param_news['where'] = array('id'=>$news_id);
			$param_news['news'] = array('status'=>0,'verify_user'=>$user,'verify_time'=>time());
			$news->update_news($param_news);
		}
		$this->redirect('/Cmsinfo/Audit/index?page='.$news_page);
	}
	
	private function getUser(){	//获取操作者账号
		$adm = $this->_GetLoginInfo();
		if(!empty($adm['ref']['info'])){
			$user = $adm['ref']['info']['account'];
		}
		return $user;
	}
	
	
}