<?php
class DeliverypriceAction extends BaseAction{
	public function index(){ 
		import("Page",LIB_PATH.'Util');
		$act=A("DeliveryPrice","Event");
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
			$act=A("DeliveryPrice","Event");
			$status=0;
			$info='请求错误';
			$data='';
			$pos=$this->_post('pos',true);
			$where['delivery_id']=$pos['delivery_id'];
			$where['area_id']=$pos['area_id'];
			$where['company_id']=$pos['company_id'];
			$row=$act->_row($where);
			if(!empty($row)){
				$info='指定城市和公司存在相同的配送方式';
			}else{
			  unset($pos['areaid']);
			  $act->_insert($pos);
			  $status=1;$info='ok';
			}
			$this->ajaxReturn($data,$info,$status,"JSON");
			die;
		}
		$Info['where']=array();
		$Info['firstRow']=0;
		$Info['listRows']=50;
		$city['where']=array('parent_id'=>1);
		$city['firstRow']=0;
		$city['listRows']=50;
		$this->assign("areas",A("Areas","Event")->_list($city));
		$this->assign("company",D("DeliveryCompany")->select());
		$this->assign("delivery",A("Delivery","Event")->_list($Info));
		$this->display();
	}
	
	function edit($id=0){
		if(IS_POST){
			$act=A("DeliveryPrice","Event");
			$status=0;
			$info='请求错误';
			$data='';
			$pos=$this->_post('pos',true);
			$id=$pos['id'];
			$where['delivery_id']=$pos['delivery_id'];
			$where['area_id']=$pos['area_id'];
			$where['company_id']=$pos['company_id'];
			$where['id']=array('neq',$id);
			$row=$act->_row($where);
			if(!empty($row)){
				$info='指定城市和公司存在相同的配送方式2';
			}else{
				unset($pos['areaid']);
				unset($pos['id']);
				$act->_edit($pos,array('id'=>$id));
				$status=1;$info='ok';
			}
			$this->ajaxReturn($data,$info,$status,"JSON");
			die;
		}
		
		$row=A('DeliveryPrice','Event')->_row(array('id'=>$id));
		$Info['where']=array();
		$Info['firstRow']=0;
		$Info['listRows']=50;
		$city['where']=array('parent_id'=>1);
		$city['firstRow']=0;
		$city['listRows']=50;
		$this->assign("areas",A("Areas","Event")->_list($city));
		$this->assign("company",D("DeliveryCompany")->select());
		$this->assign("delivery",A("Delivery","Event")->_list($Info));
		$this->assign("row",$row);
		$this->display();
	}
	
	function delete($id=0){
		$status=0;
		$info='删除失败';
		if(!empty($id)){
			$act=A("DeliveryPrice","Event");
			$map['id']  = array('in',$id);
			$act->_delete($map);
			$status=1;
			$info='ok';
		}
		$this->ajaxReturn('',$info,$status,"JSON");
	}
}