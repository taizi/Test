<?php
// +----------------------------------------------------------------------
// | Description:用户登录与退出控制器
// +----------------------------------------------------------------------
// | Copyright (c) 2013 宝苑国际  All rights reserved.
// +----------------------------------------------------------------------
// | Author: xuezheng.chang <xuezheng.chang@hotmail.com>
// +----------------------------------------------------------------------
class IndexAction extends AdminAccessAction{
    function index(){
    	if(IS_POST){
    		if($_SESSION['verify']==md5(trim($this->_post('verify')))){
		     $data['account']=$this->_post('username',true);
		     $data['password']=$this->_post('password',true);
		     $admin=$this->_Login($data);
		     if(!empty($admin['status'])){
		     	redirect('/home');
		     }else{
		     	$this->error("用户名或密码错误",__ACTION__);
		     }
    		}else{
    			$this->error("验证码错误",__ACTION__);
    		}
    	}
    	$this->display();
    }
    function verify(){
    	import('ORG.Util.Image');
    	Image::buildImageVerify(4);
    }
    function logout(){
    	$value = session ( C ( "ADMIN_AUTH_COOKIE_KEY" ), '', array (
    			'expire' => C ( "ADMIN_AUTH_COOKIE_EXPIRE" ),
    			'prefix' => C ( 'ADMIN_AUTH_COOKIE_PREFIX' )
    	) );
    	S($value.'_login',NULL);
    	cookie(null);
    	session(null);
    	redirect("/Login/index");
    }
}