<?php
return array(
	'URL_CASE_INSENSITIVE' =>true,     //忽略大小写
    'URL_MODEL'                 =>  2, // 如果你的环境不支持PATHINFO 请设置为3
    'DB_TYPE'                   =>  'mysql',
    'DB_HOST'                   =>  '127.0.0.1',
    'DB_NAME'                   =>  'web_cms',
    'DB_USER'                   =>  'root',
    'DB_PWD'                    =>  '55139273',
    'DB_PORT'                   =>  '3306',
    'DB_PREFIX'                 =>  'webcms_',
    'APP_AUTOLOAD_PATH'         =>  '@.TagLib',
    'APP_GROUP_LIST'            =>  'Home,System,Login,Cmsinfo,Recommend',
    'DEFAULT_GROUP'             =>  'Login',
    'APP_GROUP_MODE'            =>  1,
	'OUTPUT_ENCODE'             =>  FALSE, 
    'SHOW_PAGE_TRACE'           =>  TRUE,//显示调试信息
    
    'TMPL_ENGINE_TYPE'          =>'PHP',
    'TMPL_TEMPLATE_SUFFIX'      =>'.php',
		
	'COOKIE_EXPIRE'             =>  3600,// Coodie有效期（秒）  3600
	'COOKIE_DOMAIN'             =>  '.bymtm.com', //Cookie有效域名	改为newbymtm,更新时间20131011
	'COOKIE_PATH'               =>  '/', //Cookie路径  /
	'COOKIE_PREFIX'             =>  'cms_',//Cookie前缀  /
	'COOKIE_AUTH_PASS_CODE'     =>  '455340190', //加密码密钥
	
	'ADMIN_AUTH_COOKIE_KEY'     =>  'admin_cms_user',	
	'ADMIN_AUTH_COOKIE_EXPIRE'  =>  0, //管理员登录超时时间
	'ADMIN_AUTH_COOKIE_PREFIX'  =>  'admin_',
	
			
	'ADMIN_ROLE_TABLE'          =>  'webcms_role',
	'ADMIN_USER_TABLE'          =>  'webcms_role_user',
	'ADMIN_ACCESS_TABLE'        =>  'webcms_access',
	'ADMIN_NODE_TABLE'          =>  'webcms_node',	
	'LOG_RECORD'                =>true,
	'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR,WARN,NOTICE,INFO,DEBUG,SQL',
	'LOG_TYPE' =>3,
		
		
	'THEME_PATH'               =>'/Public',
    'PAGE_SIZE'                =>30,
    'VAR_PAGE'                  =>'page',

	//上传相关的配置
	'UPLOAD_ENCRYPT_PARAMRTER_KEY'          =>'455340190', //上传加密KEY
	'UPLOAD_ENCRYPT_PARAMRTER_NAME'         =>'upverify',  //上传加密码参数名称
	'UPLOAD_ENCRYPT_PARAMRTER_CODE'         =>'random',    //上传加密附码参数名称
	'UPLOAD_FILES_SWF'                      =>'http://upload.dev.admin.newbymtm.cn/Public/swfupload/swfupload.swf',
		
    'MESSAGE_SEND_NUMS'=>100,//每次即时发送站内信的条数
    'TMPL_ACTION_ERROR' => TMPL_PATH.'/Public/error.php',   //错误跳转模板
    'TMPL_ACTION_SUCCESS' => TMPL_PATH.'/Public/success.php', //正确跳转模板
    'UEDITOR'=>'http://upload.dev.admin.newbymtm.cn/ueditor/' 		
);
