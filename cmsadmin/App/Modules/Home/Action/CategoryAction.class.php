<?php
class CategoryAction extends Action{
     function getChildNode($id=1){
       $model=D("Category");
       $data=array();
       $status=0;
       $info='false';
       $row=$model->getNodeInfo(array($id));
       if(!empty($row)){
       	 $data=$model->whereChild($row);
       	 if($data){
       	 $info='true';
       	 $status=1;
       	 }
       }
       $this->ajaxReturn($data,$info,$status,"JSON");
     }
    
}