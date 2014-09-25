<?php
class TestModel extends Model {
    public $_validate = array(
        array('account','require','用户名称必须填写'),
    	array('nickname','require','昵称必须填写')
    );
    protected $insertFields = array('account','password','nickname','create_time');
    protected $updateFields = array('password','nickname');
    
    public $_auto		=	array(
        array('create_time','time',self::MODEL_INSERT,'function')
     );

  
}