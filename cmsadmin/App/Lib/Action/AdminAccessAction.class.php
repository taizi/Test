<?php
class AdminAccessAction extends Action {
	/**
	 * 用户登录
	 *
	 * @access protected
	 * @param array $data
	 *        	用户登录信息
	 * @return array status 0: 失败，1:成功 info:消息
	 */
	function _Login($data) {
		$ref ['ref'] = '';
		if (! is_array ( $data )) {
			$ref ['status'] = 0;
			$ref ['info'] = '参数错误';
			return $ref;
		}
		$admin = D ( 'Admin' );
		$ref ['info'] = '失败';
		$data ['status'] = 1; // 必须是非禁用的用户
		$admin_user = $admin->where ( "account='" . $data ['account'] . "' and status=1" )->find ();
		if (! empty ( $admin_user ) && md5 ( $data ['password'] ) == $admin_user ['password']) {
			$ref ['status'] = 1;
			$ref ['info'] = '已成功登录';
			$this->_SetLoginInfo ( $admin_user );
			// 保存登录信息
			$time = time ();
			$data = array ();
			$data ['id'] = $admin_user ['id'];
			$data ['last_login_time'] = time ();
			$data ['login_count'] = array (
					'exp',
					'login_count+1' 
			);
			$data ['last_login_ip'] = get_client_ip ();
			$admin->save ( $data );
		} else {
			$ref ['info'] = '用户不存在或密码错误';
		}
		return $ref;
	}
	//重新设置登录信息
	function _ReSetLogin(){ 
		$value = session ( C ( "ADMIN_AUTH_COOKIE_KEY" ), '', array (
				'expire' => C ( "ADMIN_AUTH_COOKIE_EXPIRE" ),
				'prefix' => C ( 'ADMIN_AUTH_COOKIE_PREFIX' )
		) );
		session ( C ( "ADMIN_AUTH_COOKIE_KEY" ), $value, array (
		'expire' => C ( "ADMIN_AUTH_COOKIE_EXPIRE" ),
		'prefix' => C ( 'ADMIN_AUTH_COOKIE_PREFIX' )
		) );
	}
	/**
	 * 设置管理员登录cookie
	 *
	 * @access protected
	 * @param array $data
	 *        	cookie 信息
	 * @return array status 0: 失败，1:成功 info:消息
	 */
	function _SetLoginInfo($data) {
		$userid=$data['id'];
		$admin['info']=$data;
		$ref=$this->_GetAccessList($userid);
		if($ref['status']>0){
		  $admin['menu']=$ref['ref'];
		}
		
		$account=$data['account'];
		S($data['account'].'_login',$admin);
		$value = AuthCode ( $account, 'ENCODE', C ( "COOKIE_AUTH_PASS_CODE" ) );
		session ( C ( "ADMIN_AUTH_COOKIE_KEY" ), $value, array (
				'expire' => C ( "ADMIN_AUTH_COOKIE_EXPIRE" ),
				'prefix' => C ( 'ADMIN_AUTH_COOKIE_PREFIX' ) 
		) );
		return array (
				'status' => 1,
				'info' => '成功' 
		);
	}
	/**
	 * 获取管理员登录cookie
	 *
	 * @access protected
	 * @return array status 0: 失败，1:成功 info:消息 ref:返回的COOKIE信息
	 */
	function _GetLoginInfo() {
		$value = session ( C ( "ADMIN_AUTH_COOKIE_KEY" ), '', array (
				'expire' => C ( "ADMIN_AUTH_COOKIE_EXPIRE" ),
				'prefix' => C ( 'ADMIN_AUTH_COOKIE_PREFIX' ) 
		) );
		$ref ['status'] = 0;
		$ref ['info'] = '无登录信息';
		$ref ['ref'] = '';
		if (! empty ( $value )) {
			$value = AuthCode ( $value, 'DECODE', C ( "COOKIE_AUTH_PASS_CODE" ) );
			$data=S($value.'_login');
			$ref ['status'] = 1;
			$ref ['info'] = '成功';
			$ref ['ref'] = $data;
		}
		return $ref;
	}
	
	/**
	 * 获取管理员权限列表
	 *
	 * @access protected
	 * @param integer $authId
	 *        	管理员id
	 * @return array status 0: 失败，1:成功 info:消息
	 */
	function _GetAccessList($authId) {
		$ref ['status'] = 0;
		$ref ['info'] = '参数错误';
		$ref ['ref'] = '';
		if (empty ( $authId )) {
			return $ref;
		}
		$model = M ();
		$table = array (
				'role' => C ( 'ADMIN_ROLE_TABLE' ),
				'user' => C ( 'ADMIN_USER_TABLE' ),
				'access' => C ( 'ADMIN_ACCESS_TABLE' ),
				'node' => C ( 'ADMIN_NODE_TABLE' ) 
		);
		$sql = "SELECT  distinct access.node_id, access.role_id,node.name,node.title,node.pid,node.level FROM
              " . $table ['access'] . " as access left join
              " . $table ['node'] . " as node  on node.id=access.node_id
				WHERE access.role_id
				IN (
				    SELECT role_id
				    FROM  " . $table ['user'] . "
					    WHERE user_id =$authId
					    ) and node.status=1 order by level asc,sort asc";
		//echo $sql;die;
		$list = $model->query ( $sql );
		
		if ($list) {
			$ref ['status'] = 1;
			$ref ['info'] = '完成';
			$ref ['ref'] = $list;
		}
		return $ref;
	}
	
	/**
	 * 管理员权限认证过虑器
	 *
	 * @access protected
	 * @param string $appName
	 *        	分组名称
	 * @return array status 0: 失败，1:成功 info:消息,ref:空
	 */
	function _AccessDecision() {
		$admin_user = $this->_GetLoginInfo ();
		$ref ['status'] = 0;
		$ref ['info'] = '没有权限';
		$ref ['ref'] = '';
		if (empty ( $admin_user ['status'] )) { 
			return $ref;
		} else {
			$accessList = $admin_user['ref']['menu'];
			
			if (empty ( $accessList )) { 				
				$tmp = $this->_GetAccessList($admin_user ['id']);	
				if (! empty ( $tmp ['status'] )) {
					$accessList = $tmp ['ref'];
				} else {
					return $ref;
				}
			}
			//echo GROUP_NAME.'<br/>';echo MODULE_NAME.'<br/>';echo ACTION_NAME;
			//echo "<pre>";print_r($accessList);echo "</pre>";
			$authstat = false;
			$app = $module = $action = 0;
			
			foreach ( $accessList as $v ) {
				if (strtoupper ( $v ['name'] ) == strtoupper ( GROUP_NAME ) && $v ['level'] == 1) {
					$app = $v ['node_id'];
					//echo '1'.'<br>';
				} else if (strtoupper ( $v ['name'] ) == strtoupper ( MODULE_NAME ) && $v ['level'] == 2 && $v ['pid'] == $app) {
					$module = $v ['node_id'];
					//echo '2'.'<br>';
				} else if (strtoupper ( $v ['name'] ) == strtoupper ( ACTION_NAME ) && $v ['level'] == 3 && $v ['pid'] == $module) {
					$action = $v ['node_id'];
					//echo '3'.'<br>';
				}
				if (! empty ( $app ) && ! empty ( $module ) && ! empty ( $action )) {
					break;
				}
			}
			
			//echo $app.'<br/>';echo $module.'<br/>';echo $action;exit;
			if (! empty ( $app ) && ! empty ( $module ) && ! empty ( $action )) {
				$authstat = true;
			} else if (! empty ( $app ) && ! empty ( $module ) && strtoupper ( ACTION_NAME ) == 'INDEX') {
				$authstat = true;
			} else if (strtoupper ( GROUP_NAME ) == 'INDEX' && strtoupper ( MODULE_NAME ) == 'INDEX' && strtoupper ( ACTION_NAME ) == 'INDEX') {
				$authstat = true;
			} else {
				$authstat = false;
			}
			
			if($authstat){
				$ref ['status'] = 1;
				$ref ['info'] = '完成';
				$ref ['ref'] = '';
				$ref ['menu']=$accessList;
			}
			
			return $ref;
		}
	}

}
