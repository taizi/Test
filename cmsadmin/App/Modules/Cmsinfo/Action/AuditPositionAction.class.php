<?php
class AuditPositionAction extends BaseAction{
	public function index(){
		$newsPosition = D('NewsPosition');
		import("Page",LIB_PATH.'Util');
		$position_page = $this->_request('page')?$this->_request('page'):1;
		if($this->_request('search_style')){
			switch ($this->_request('search_style')){
				case 1:
					$where['status'] = array('eq',1);
					break;
				case 2:
					$where['status'] = array('eq',2);
					break;
				case 3:
					$where['status'] = array('eq',0);
					break;
				default:
					break;
			}
		}
		
		if($this->_request('search_name')){
			$where['position_name'] = array('like','%'.$this->_request('search_name').'%');
		}
		
		$count = $newsPosition->_count($where);
		if($count > 0){
			$Page = new Page($count, C('PAGE_SIZE'));
			$data['where'] = $where;
			$data['firstRow'] = $Page->firstRow;
			$data['listRows'] = $Page->listRows;
			$data['order'] = 'id desc';
			$list = $newsPosition->_list($data);
			if(!empty($list)){
				foreach($list as $k => $v_list){
					switch ($v_list['status']){
						case 0:
							$list[$k]['position_status'] = '未审核';
							break;
						case 1:
							$list[$k]['position_status'] = '已启用';
							break;
						case 2:
							$list[$k]['position_status'] = '已禁用';
							break;
						default:
							break;
					}
				}
			}
			$Page->setConfig('header', '条数据');
			$Page->setConfig('first', '<<');
			$Page->setConfig('last', '>>');
			$page = $Page->show();
			$this->assign('page',$page);
			$this->assign('position_page',$position_page);
			$this->assign('position_list',$list);
		}
		$this->display();
	}
	
	public function verify(){
		$newsPosition = D('NewsPosition');
		$position_id = $this->_get('id');
		$position_page = $this->_get('page');
		$user = $this->getUser();
		$data['where'] = array('id'=>$position_id);
		$data['position'] = array('status'=>1,'update_time'=>time(),'update_user'=>$user);
		if(!empty($position_id) && $position_id != 0){
			$verify_res = $newsPosition->update_position($data);
		}
		$this->redirect('/Cmsinfo/AuditPosition/index?page='.$position_page);
	}
	
	public function disable(){
		$newsPosition = D('NewsPosition');
		$position_id = $this->_get('id');
		$position_page = $this->_get('page');
		$user = $this->getUser();
		$data['where'] = array('id'=>$position_id);
		$data['position'] = array('status'=>2,'update_time'=>time(),'update_user'=>$user);
		if(!empty($position_id) && $position_id != 0){
			$disable_res = $newsPosition->update_position($data);
		}
		$this->redirect('/Cmsinfo/AuditPosition/index?page='.$position_page);
	}
	
	public function undisable(){
		$newsPosition = D('NewsPosition');
		$position_id = $this->_get('id');
		$position_page = $this->_get('page');
		$user = $this->getUser();
		$data['where'] = array('id'=>$position_id);
		$data['position'] = array('status'=>0,'update_time'=>time(),'update_user'=>$user);
		if(!empty($position_id) && $position_id != 0){
			$undisable_res = $newsPosition->update_position($data);
		}
		$this->redirect('/Cmsinfo/AuditPosition/index?page='.$position_page);
	}
	
	private function getUser(){	//获取操作者账号
		$adm = $this->_GetLoginInfo();
		if(!empty($adm['ref']['info'])){
			$user = $adm['ref']['info']['account'];
		}
		return $user;
	}
	
	
}