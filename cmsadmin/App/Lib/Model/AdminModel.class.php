<?php
class AdminModel extends Model {
   // 自动验证设置
    protected $_validate	 =	 array(
        array('account','require','用户名必须填写！',),
        array('password','require','用户密码必须填写！'),
    	array('account','','帐号名称已经存在！',0,'unique',1),
        );
    // 自动填充设置
    protected $_auto	 =	 array(
        array('status','1',self::MODEL_INSERT),
    	array('password','md5',self::MODEL_BOTH,'function'),
        array('create_time','time',self::MODEL_INSERT,'function'),
    	array('update_time','time',self::MODEL_UPDATE,'function'),
        );
    
    protected $insertFields = array('account','password','nickname','create_time');
    protected $updateFields = array('password','nickname');
   
    protected $tableName = 'user';
}