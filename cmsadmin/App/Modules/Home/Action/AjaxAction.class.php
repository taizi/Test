<?php
class AjaxAction extends Action{
     function area($pid=1){
     	$Info=array('parent_id'=>$pid);
     	$data=D('Areas')->where($Info)->select();
     	$status=0;
     	if(!empty($data)){
     	     $status=1;
     	}
     	$this->ajaxReturn($data,'',$status,"JSON");
     }
  
}