<?php
class DeliveryAction extends BaseAction{
	public function index(){
		import("Page",LIB_PATH.'Util');
		$act=A("Delivery","Event");
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
	function insert(){
		if(IS_POST){
			$act=A("Delivery","Event");
			$status=0;
			$info='请求错误';
			$data='';
			$pos=$this->_post('pos',true);
			$where['name']=$pos['name'];
			$row=$act->_row($where);
			if(!empty($row)){
				$info='存在同名的配送方式';
			}else{
			  $act->_insert($pos);
			  $status=1;$info='ok';
			}
			$status=1;
			$this->ajaxReturn($data,$info,$status,"JSON");
			die;
		}
		$this->display();
	}
	
	function edit($id=0){
		$act=A("Delivery","Event");
		if(IS_POST){ 
			$status=0;
			$info='修改错误';
			$pos=$this->_post('pos',true);
			$where['name']=$pos['name'];
			$where['id']=array('NEQ',$pos['id']);
			$row=$act->_row($where);
			if(empty($row)){
				unset($where);
				$where['id']=$pos['id'];unset($pos['id']);			
				$act->_edit($pos,$where);
				$status=1;
				$info='修改成功';
			}else{
				$info='存在同名的配送方式';
			}
			$this->ajaxReturn('',$info,$status,"JSON");
		}
		if(!empty($id)){
			$this->assign("row", $act->_row(array('id'=>$id)));
		}
		$this->display();
	}
	
	function delete($id=0){
		$status=0;
		$info='删除失败';
		if(!empty($id)){
			$act=A("Delivery","Event");
			$map['id']  = array('in',$id);
			$act->_delete($map);
			$status=1;
			$info='ok';
		}
		$this->ajaxReturn('',$info,$status,"JSON");
	}
}