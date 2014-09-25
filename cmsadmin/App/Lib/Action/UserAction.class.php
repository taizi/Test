<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends Action {
	
    public function info(){
      $p = A('Test',true); //调用公共分组必须加 第三个参数  true;  调用默认控制器
	  $p = A('User','Event',true); //调用公共分组必须加 第三个参数  true;
	  $model=X('Users','Logic',true);  //模型分层-逻辑
	  echo $model->test();
	  return $p->test(); 
    }
    
    function news($data,$method){
    	$info=A("News","Event",true);
    	return $info->$method($data);
    }
    
    
    
    
}