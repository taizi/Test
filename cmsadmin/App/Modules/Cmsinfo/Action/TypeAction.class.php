<?php
class TypeAction extends BaseAction{
	public function index(){
		$newsType = D('NewsType');
		import("Page",LIB_PATH.'Util');
		$type_page = $this->_request('page')?$this->_request('page'):1;
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
			$where['type_name'] = array('like','%'.$this->_request('search_name').'%');
		}
		
		$count = $newsType->_count($where);
		if($count > 0){
			$Page = new Page($count, C('PAGE_SIZE'));
			$data['where'] = $where;
			$data['firstRow'] = $Page->firstRow;
			$data['listRows'] = $Page->listRows;
			$data['order'] = 'id desc';
			$list = $newsType->_list($data);
			if(!empty($list)){
				foreach($list as $k => $v_list){
					switch ($v_list['status']){
						case 0:
							$list[$k]['type_status'] = '未审核';
							break;
						case 1:
							$list[$k]['type_status'] = '已启用';
							break;
						case 2:
							$list[$k]['type_status'] = '已禁用';
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
			$this->assign('type_page',$type_page);
			$this->assign('type_list',$list);
		}
		$this->display();
	}
	
	public function insert(){
		$this->display();
	}
	
	public function add_type(){
		$newsType = D('NewsType');
		$data['type_name'] = $this->_post('t_name');
		$data['description'] = $this->_post('t_desc');
		$data['sort'] = $this->_post('t_sort');
		$data['update_user'] = $this->getUser();
		$data['create_time'] = time();
		if(!empty($data['type_name'])){
			$res = $newsType->find_type(array('type_name'=>$data['type_name']));
			if(empty($res)){
				$add_res = $newsType->add_type($data);
			}
		}
		echo "<script type='text/javascript'>window.parent.location.href='/Cmsinfo/Type/index'</script>";
	}
	
	public function edit(){
		$newsType = D('NewsType');
		$type_id = $this->_get('tid');
		$type_page = $this->_get('page');
		if(!empty($type_id)){
			$type = $newsType->find_type(array('id'=>$type_id));
			$this->assign('type',$type);
		}
		$this->assign('type_page',$type_page);
		$this->display();
	}
	
	public function update_type(){
		$newsType = D('NewsType');
		$type_id = $this->_post('t_id');
		$type_page = $this->_post('page');
		$data['where'] = array('id'=>$type_id);
		$data['type']['type_name'] = $this->_post('t_name');
		$data['type']['description'] = $this->_post('t_desc');
		$data['type']['sort'] = $this->_post('t_sort');
		$data['type']['update_user'] = $this->getUser();
		$data['type']['update_time'] = time();
		if(!empty($type_id) && !empty($data['type']['type_name'])){
			$res = $newsType->find_type(array('type_name'=>$data['type']['type_name']));
			if(empty($res)){
				$update_res = $newsType->update_type($data);
			}else{
				if($res['id'] == $type_id){
					$update_res = $newsType->update_type($data);
				}
			}
		}
		echo "<script type='text/javascript'>window.parent.location.href='/Cmsinfo/Type/index?page=".$type_page."'</script>";
	}
	
	public function delete(){
		$newsType = D('NewsType');
		$hubType = D('HubType');
		$type_id = $this->_get('id');
		$type_page = $this->_get('page');
		if(!empty($type_id) && $type_id != 0){
			$del_res = $newsType->del_type(array('id'=>$type_id));
			if($del_res){
				$hubType->del_newsType(array('type_id'=>$type_id));
			}
		}
		$this->redirect('/Cmsinfo/Type/index?page='.$type_page);
	}
	
	public function detect_name(){
		$newsType = D('NewsType');
		$type_name = $this->_post('t_name');
		$type_id = $this->_post('t_id');
		$type_act = $this->_post('t_act');
		switch ($type_act){
			case 'insert':
				if(!empty($type_name)){
					$res = $newsType->find_type(array('type_name'=>$type_name));
					if(empty($res)){
						echo json_encode('empty');
					}else{
						echo json_encode($res);
					}
				}
				break;
			case 'edit':
				if(!empty($type_name) && !empty($type_id)){
					$res = $newsType->find_type(array('type_name'=>$type_name));
					if(empty($res)){
						echo json_encode('empty');
					}else{
						if($res['id'] == $type_id){
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
		$newsType = D('NewsType');
		$type_id = $this->_get('id');
		$type_page = $this->_get('page');
		$user = $this->getUser();
		$data['where'] = array('id'=>$type_id);
		$data['type'] = array('status'=>1,'update_time'=>time(),'update_user'=>$user);
		if(!empty($type_id) && $type_id != 0){
			$verify_res = $newsType->update_type($data);
		}
		$this->redirect('/Cmsinfo/Type/index?page='.$type_page);
	}
	
	public function disable(){
		$newsType = D('NewsType');
		$type_id = $this->_get('id');
		$type_page = $this->_get('page');
		$user = $this->getUser();
		$data['where'] = array('id'=>$type_id);
		$data['type'] = array('status'=>2,'update_time'=>time(),'update_user'=>$user);
		if(!empty($type_id) && $type_id != 0){
			$disable_res = $newsType->update_type($data);
		}
		$this->redirect('/Cmsinfo/Type/index?page='.$type_page);
	}
	
	public function undisable(){
		$newsType = D('NewsType');
		$type_id = $this->_get('id');
		$type_page = $this->_get('page');
		$user = $this->getUser();
		$data['where'] = array('id'=>$type_id);
		$data['type'] = array('status'=>0,'update_time'=>time(),'update_user'=>$user);
		if(!empty($type_id) && $type_id != 0){
			$undisable_res = $newsType->update_type($data);
		}
		$this->redirect('/Cmsinfo/Type/index?page='.$type_page);
	}
	
	private function getUser(){	//获取操作者账号
		$adm = $this->_GetLoginInfo();
		if(!empty($adm['ref']['info'])){
			$user = $adm['ref']['info']['account'];
		}
		return $user;
	}	

	
}