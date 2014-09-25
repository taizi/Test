<?php
class SystemlogAction extends BaseAction{
	public function index(){
		import("Page",LIB_PATH.'Util');
		$act=A("SystemLog","Event");
		$where=$act->_get_where(); 
		$count=$act->_count($where);
		if($count>0){
			$Page = new Page($count, C('PAGE_SIZE'));
			$data['where']=$where;
			$data['firstRow']=$Page->firstRow;
			$data['listRows']=$Page->listRows;
			$list=$act->_list($data);
			$Page->setConfig('header', '条数据');
			$Page->setConfig('first', '<<');
			$Page->setConfig('last', '>>');
			$page = $Page->show();
			$this->assign("where", $where);
			$this->assign("page", $page);
			$this->assign("List", $list);
		}
		$this->display();
	}
	
	function delete($id=0){
		$status=0;
		$info='删除失败';
		if(!empty($id)){
			$act=A("SystemLog","Event");
			$map['id']  = array('in',$id);
			$act->_delete($map);
			$status=1;
			$info='ok';
		}
		$this->ajaxReturn('',$info,$status,"JSON");
	}
}