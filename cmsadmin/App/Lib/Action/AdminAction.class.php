<?php
class AdminAction extends BaseAction{
	/**
	 * 管理员信息
	 * @access protected
	 * @param  $data 管理员
	 * @param  $method 操作方法( _Insert,_Edit,_Delete,_GetRow,_GetList,_SetRole{设置角色})
	 * @return array  status  0: 失败，1:成功  info:消息,ref:返回数组
	 */
	function AdminUser($data,$method){
         $info=A("AdminUserInfo","Event",true);
		 return $info->$method($data);
		
	}	
	/**
	 * 管理结点信息
	 * @access protected
	 * @param $op $data 管理结点
	 * @param  $method 操作方法( _Insert,_Edit,_Delete,_GetRow,_GetList)
	 * @return array  status  0: 失败，1:成功  info:消息,ref:返回数组
	 */
	function AdminNode($data,$method){
		$info=A("AdminNodeInfo","Event",true);
		return $info->$method($data);
	}
	/**
	 * 管理员角色信息
	 * @access protected
	 * @param $op $data 管理角色
	 * @param  $method 操作方法( _Insert,_Edit,_Delete,_GetRow,_GetList,_Authority{权限})
	 * @return array  status  0: 失败，1:成功  info:消息,ref:返回数组
	 */
	function AdminRole($data,$method){
		$info=A("AdminRoleInfo","Event",true);
		return $info->$method($data);
	}	
	
	
    
}