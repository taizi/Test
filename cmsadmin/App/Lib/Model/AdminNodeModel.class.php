<?php
class AdminNodeModel extends Model {
   // 自动验证设置
    protected $_validate	 =	 array(
        array('name','require','名称必须填写！',),
    	array('name','checkNode','节点已经存在',0,'callback'),
        array('title','require','标题必须填写！')
        );
    // 自动填充设置
    protected $_auto	 =	 array(
        array('status','1',self::MODEL_INSERT)
        );
    protected $tableName = 'node';
    
    public function checkNode() {
    	$map['name']	 =	 $_POST['name'];
    	$map['pid']	=	isset($_POST['pid'])?$_POST['pid']:0;
    	$map['status'] = 1;
    	if(!empty($_POST['id'])) {
    		$map['id']	=	array('neq',$_POST['id']);
    	}
    	$result	=	$this->where($map)->field('id')->find();
    	if($result) {
    		return false;
    	}else{
    		return true;
    	}
    }
}