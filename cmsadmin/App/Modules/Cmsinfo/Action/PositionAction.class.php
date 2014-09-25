<?php
class PositionAction extends BaseAction{
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
			$this->assign('page', $page);
			$this->assign('position_page',$position_page);
			$this->assign('position_list',$list);
		}
		$this->display();
	}
	
	public function insert(){
		$this->display();
	}
	
	public function add_position(){
		$newsPosition = D('NewsPosition');
		$user = $this->getUser();
		$data['position_name'] = $this->_post('p_name');
		$data['description'] = $this->_post('p_desc');
		$data['sort'] = $this->_post('p_sort');
		$data['update_user'] = $user;
		$data['create_time'] = time();
		if(!empty($data['position_name'])){
			$res = $newsPosition->find_position(array('position_name'=>$data['position_name']));
			if(empty($res)){
				$add_res = $newsPosition->add_position($data);
			}
		}
		echo "<script type='text/javascript'>window.parent.location.href='/Cmsinfo/Position/index'</script>";
	}
	
	public function edit(){
		$position_id = $this->_get('pid');
		$position_page = $this->_get('page');
		$newsPosition = D('NewsPosition');
		if(!empty($position_id)){
			$position = $newsPosition->find_position(array('id'=>$position_id));
			$this->assign('position',$position);
		}
		$this->assign('position_page',$position_page);
		$this->display();
	}
	
	public function update_position(){
		$newsPosition = D('NewsPosition');
		$user = $this->getUser();
		$position_id = $this->_post('p_id');
		$position_page = $this->_post('page');
		$data['position']['position_name'] = $this->_post('p_name');
		$data['position']['description'] = $this->_post('p_desc');
		$data['position']['sort'] = $this->_post('p_sort');
		$data['position']['update_user'] = $user;
		$data['position']['update_time'] = time();
		$data['where'] = array('id'=>$position_id);
		if(!empty($position_id) && !empty($data['position']['position_name'])){
			$res = $newsPosition->find_position(array('position_name'=>$data['position']['position_name']));
			if(empty($res)){
				$update_res = $newsPosition->update_position($data);
			}else{
				if($res['id'] == $position_id){
					$update_res = $newsPosition->update_position($data);
				}
			}
		}
		echo "<script type='text/javascript'>window.parent.location.href='/Cmsinfo/Position/index?page=".$position_page."'</script>";
	}
	
	public function delete(){
		$newsPosition = D('NewsPosition');
		$hubPosition = D('HubPosition');
		$position_id = $this->_get('id');
		$position_page = $this->_get('page');
		if($position_id && $position_id != 0){
			$del_res = $newsPosition->del_position(array('id'=>$position_id));
			if($del_res){
				$hubPosition->del_newsPosition(array('position_id'=>$position_id));
			}
		}
		$this->redirect('/Cmsinfo/Position/index?page='.$position_page);
	}
	
	private function getUser(){	//获取操作者账号
		$adm = $this->_GetLoginInfo();
		if(!empty($adm['ref']['info'])){
			$user = $adm['ref']['info']['account'];
		}
		return $user;
	}
	
	public function detect_name(){
		$newsPosition = D('NewsPosition');
		$position_name = $this->_post('p_name');
		$position_act = $this->_post('p_act');
		$position_id = $this->_post('p_id');
		switch ($position_act){
			case 'insert':
				if(!empty($position_name)){
					$res = $newsPosition->find_position(array('position_name'=>$position_name));
					if(empty($res)){
						echo json_encode('empty');
					}else{
						echo json_encode($res);
					}
				}
				break;
			case 'edit':
				if(!empty($position_name) && !empty($position_id)){
					$res = $newsPosition->find_position(array('position_name'=>$position_name));
					if(empty($res)){
						echo json_encode('empty');
					}else{
						if($res['id'] == $position_id){
							echo json_encode('empty');
						}else{
							echo json_encode($res);
						}
					}
				}
				break;
			default:
				break;
		}
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
		$this->redirect('/Cmsinfo/Position/index?page='.$position_page);
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
		$this->redirect('/Cmsinfo/Position/index?page='.$position_page);
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
		$this->redirect('/Cmsinfo/Position/index?page='.$position_page);
	}
	
}