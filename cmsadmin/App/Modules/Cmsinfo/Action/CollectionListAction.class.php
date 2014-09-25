<?php
class CollectionListAction extends BaseAction{
	public function index(){
		import("Page",LIB_PATH.'Util');
		$collection = D('NewsCollection');
		if($this->_request('status')){
			$where['un_status'] = $this->_request('status');
		}
		$count = $collection->_count($where);
		$un_page = $this->_request('page');
		if($count > 0){
			$Page = new Page($count, C('PAGE_SIZE'));
			$data['where'] = $where;
			$data['order'] = 'id desc';
			$data['firstRow']=$Page->firstRow;
			$data['listRows']=$Page->listRows;
			$list = $collection->_list($data);
			
			if(!empty($list)){
				foreach($list as $k => $v_list){
					$list[$k]['un_title'] = $this->clearTag($v_list['un_title']);
					$list[$k]['un_content'] = $this->clearTag($v_list['un_content']);
					switch ($v_list['un_status']){
						case 0:
							$list[$k]['status'] = '未入库';
							break;
						case 1:
							$list[$k]['status'] = '已入库';
							break;
						case 2:
							$list[$k]['status'] = '禁止入库';
							break;
					}
				}
			}
			
			$Page->setConfig('header', '条数据');
			$Page->setConfig('first', '<<');
			$Page->setConfig('last', '>>');
			$page = $Page->show();
			$this->assign('un_page',$un_page);
			$this->assign('page', $page);
			$this->assign('list', $list);
			
		}
		$this->display('CollectionList:index');
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
	
	public function delete(){	//删除单条文章
		$id = $this->_get('id');
		$page = $this->_get('page');
		$collection = D('NewsCollection');
		if(!empty($id)){
			$collection->del_news(array('id'=>$id));
		}
		$this->redirect('/Cmsinfo/CollectionList/index?page='.$page);
	}
	
	public function delete_all(){
		$collection = D('NewsCollection');
		$sql = 'TRUNCATE TABLE `webcms_news_collection`;';
		$collection->execute($sql);
		$this->redirect('/Cmsinfo/CollectionList/index');
	}
	
	public function insert(){	//单条文章入库
		$collection = D('NewsCollection');
		$news = D('News');
		$newsDetails = D('NewsDetails');
		$hubType = D('HubType');
		$user = $this->getUser();
		$un_page = $this->_get('page');
		$where['id'] = $this->_get('id');
		$un_news = $collection->un_news($where);
		if(!empty($un_news)){
			$news_id = $news->add_news(array('title'=>$un_news['un_title'],'summary'=>$un_news['un_summary'],'keyword'=>$un_news['un_keyword'],'original_cover'=>$un_news['un_cover'],'update_user'=>$user));
			if($news_id){
				$details_id = $newsDetails->add_details(array('nid'=>$news_id,'content'=>$un_news['un_content'],'author'=>$un_news['un_author'],'source'=>$un_news['un_source'],'date'=>$un_news['un_date'],'update_user'=>$user));
				$hub_type = $hubType->add_newsType(array('news_id'=>$news_id));
			}
			if($details_id){
				$collection->change_status(array('id'=>$un_news['id']),$user);
			}
		}
		$this->redirect('/Cmsinfo/CollectionList/index?page='.$un_page);
	}
	
	public function re_insert(){	//单条文章重新入库
		$collection = D('NewsCollection');
		$news = D('News');
		$newsDetails = D('NewsDetails');
		$hubType = D('HubType');
		$user = $this->getUser();
		$un_page = $this->_get('page');
		$where['id'] = $this->_get('id');
		$un_news = $collection->un_news($where);
		if(!empty($un_news)){
			$news_id = $news->add_news(array('title'=>$un_news['un_title'],'summary'=>$un_news['un_summary'],'keyword'=>$un_news['un_keyword'],'original_cover'=>$un_news['un_cover'],'update_user'=>$user));
			if($news_id){
				$details_id = $newsDetails->add_details(array('nid'=>$news_id,'content'=>$un_news['un_content'],'author'=>$un_news['un_author'],'source'=>$un_news['un_source'],'date'=>$un_news['un_date'],'update_user'=>$user));
				$hub_type = $hubType->add_newsType(array('news_id'=>$news_id));
			}
		}
		$this->redirect('/Cmsinfo/CollectionList/index?page='.$un_page);
	}
	
	public function insert_all(){	//文章批量入库
		$collection = D('NewsCollection');
		$news = D('News');
		$newsDetails = D('NewsDetails');
		$hubType = D('HubType');
		$user = $this->getUser();
		$un_page = $this->_get('page');
		$nid_list = $this->_post('nid_list');
		
		if(!empty($nid_list)){
			$nid = implode(',',$nid_list);
		}
		$where['id'] = array('in',$nid);
		$un_list = $collection->un_news_list($where);
		
		if(!empty($un_list)){
			foreach($un_list as $k => $v_un){
				$news_id = null;
				$details_id = null;
				$hub_type = null;
				$news_id = $news->add_news(array('title'=>$v_un['un_title'],'summary'=>$v_un['un_summary'],'keyword'=>$v_un['un_keyword'],'original_cover'=>$v_un['un_cover'],'update_user'=>$user));
				if($news_id){
					$details_id = $newsDetails->add_details(array('nid'=>$news_id,'content'=>$v_un['un_content'],'author'=>$v_un['un_author'],'source'=>$v_un['un_source'],'date'=>$v_un['un_date'],'update_user'=>$user));
					$hub_type = $hubType->add_newsType(array('news_id'=>$news_id));
				}
				if($details_id){
					$collection->change_status(array('id'=>$v_un['id']),$user);
				}
			}
		}
		$this->redirect('/Cmsinfo/CollectionList/index?page='.$un_page);
	}
	
	private function getUser(){	//获取操作者账号
		$adm = $this->_GetLoginInfo();
		if(!empty($adm['ref']['info'])){
			$user = $adm['ref']['info']['account'];
		}
		return $user;
	}
	
	
	
	
}