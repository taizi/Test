<?php
class CrossDomainUploadAction extends Action{
     function index($para=''){
        $data='';
        $status=0;
        $info='未知错误';
     	if(!empty($para)){
       	 $para=urldecode($para);
       	 $para=unserialize($para);
       	 $status=$para['status'];
       	 $info=$para['info'];
       	 $data=$para['data'];       	 
        }
        $this->ajaxReturn($data,$info,$status,"JSON");
     }
    
}