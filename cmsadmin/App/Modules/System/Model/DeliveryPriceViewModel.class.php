<?php
class DeliveryPriceViewModel extends ViewModel{
	public $viewFields = array(
			'DeliveryPrice'=>array('id'=>'rid','price'=>'delivery_price','replenish'=>'delivery_replenish','create_time','_type'=>'left'),
			'Delivery'=>array('id'=>'delivery_id','name'=>'delivery_name','remark'=>'delivery_remark','_on'=>'DeliveryPrice.delivery_id=Delivery.id','_type'=>'left'),
			'Areas'=>array('area_name','_on'=>'Areas.area_id=DeliveryPrice.area_id','_type'=>"left"),
			'DeliveryCompany'=>array('name'=>'company_name','_on'=>'DeliveryCompany.id=DeliveryPrice.company_id')
	);
}