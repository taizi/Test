<?php
class Mysql {
	private $db_host; //数据库主机
	private $db_user; //数据库用户名
	private $db_pwd; //数据库用户名密码
	private $db_database; //数据库名
	private $conn; //数据库连接标识;
	private $result; //执行query命令的结果资源标识
	private $sql; //sql执行语句
	private $row; //返回的条目数
	private $coding; //数据库编码，GBK,UTF8,gb2312
	// 查询表达式参数
	protected $options          =   array();
	private $table; //表名称
	private $table_fix='webshop_'; //表前缀
		
/*构造函数*/
public function __construct($db_host='localhost', $db_user='root', $db_pwd='root', $db_database='web_shop', $conn='', $coding='UTF8') {
	$this->db_host = $db_host;
	$this->db_user = $db_user;
	$this->db_pwd = $db_pwd;
	$this->db_database = $db_database;
	$this->conn = $conn;
	$this->coding = $coding;
	$this->connect();
	}

/*数据库连接*/	
public function connect() {
	if ($this->conn == "pconn") { //永久链接
		$this->conn = mysql_pconnect($this->db_host, $this->db_user, $this->db_pwd);
	} else { //即使链接
		$this->conn = mysql_connect($this->db_host, $this->db_user, $this->db_pwd);
	}
	if (!mysql_select_db($this->db_database, $this->conn)) {
		
			echo "数据库不可用：", $this->db_database;
		
	}
	mysql_query("SET NAMES $this->coding");
}


/*数据库执行语句，可执行查询添加修改删除等任何sql语句*/
public function query($sql) {
	//echo $sql;die;
	$this->sql = $sql;
	$result = mysql_query($this->sql, $this->conn);
	if (!$result) { //调试中使用，sql语句出错时会自动打印出来
		echo "错误SQL语句：", $this->sql; die;
	} else {
		$this->result = $result;
	}
	return $this->result;
}



/*取得记录集,获取数组-索引和关联,使用$row['content'] */
private function fetch_array() {
	return mysql_fetch_array($this->result);
}

public function count(){
	$this->options['field']=' COUNT(*) AS tp_count ';
	$nums=$this->select();
	return $nums[0]['tp_count'];
}

public function select(){
	$sql=$this->_parseOptions($this->options);
	//echo $sql;die;
	$this->query($sql);
	$arr=array();
	while ($row=$this->fetch_array()){
		$arr[]=$row;
	}
	$this->result=$arr;
	return $this->result;
}


public function save($data=array()){
	if(count($data)<1){ echo '数据不能为空';die;}
	
	$sql="UPDATE $this->table SET ";
	$str='';
	while(list($key,$value)=each($data)){
		$str.= "`".$key."`=".$value.",";
	}
	$sql.=rtrim($str,',');
	
	$where=$this->_paramsWhere($this->options);
	$sql.=$where;
	return $this->query($sql);
}


public function add($data=array()){
 if(count($data)<1){ echo '数据不能为空';die;}
	    $sql="INSERT INTO $this->table (";
		$vals='';
		foreach ($data as $k => $v){
			$arr=array_keys($v);
			$fields=implode(',',$arr);
			$arr=array_values($v);
			$vals.='('.implode(',',$arr).'),';
		}
		$sql.=  $fields.') VALUES ';
		$sql.= rtrim($vals,',').';';
		//ECHO $sql;die; 
		$this->query($sql);
		$lastid=$this->query('SELECT LAST_INSERT_ID()');
		return $lastid;
} 		

public function table($table){
	if($table==''){
 		echo '没有指定表名';die;
 	}else{
 		$this->table=$this->table_fix.strtolower($table);
 	} 
 	return $this;
}

public function limit($offset,$length=null){
        $this->options['limit'] =   is_null($length)?$offset:$offset.','.$length;
        return $this;
}

public function field($field='*'){
	$this->options['field']=$field;
	return $this;
}

public function where($where){
	if(isset($this->options['where'])){
		$this->options['where'] =   array_merge($this->options['where'],$where);
	}else{
		$this->options['where'] =   $where;
	}
	return $this;
}


public function order($field='id'){
	$this->options['order']=$field;
	return $this;
}

protected function _paramsWhere($options){
	$condition='';
	if(isset($options['where']) && is_array($options['where'])) {
		$condition.=' Where ';
		foreach ($options['where'] as $key=>$val){
			$key            =   trim($key);
			$exp='';
			if(is_array($val)){  //表达式
				$exp=$this->exp($key, $val,$options['where']);
			}else{ //字符串
				$exp=" $key=$val and ";
			}
			$condition.=$exp;
		}
			
		if(strrchr($condition,'and')){
			$condition=substr($condition, 0,-4);
		}
	}
	
	return $condition;
}


//整合查询时的sql语句参数
protected function _parseOptions($options=array()) {
 	if(is_array($options)) $options =  array_merge($this->options,$options);
 	// 查询过后清空sql表达式组装 避免影响下次查询
 	$this->options  =   array();
 	$condition=$this->_paramsWhere($options);
 	$field=isset($options['field'])? $options['field']:'*';
 	$limit=isset($options['limit'])?' LIMIT '.$options['limit']:'';
 	$order=isset($options['order'])?' ORDER BY '.$options['order']:'';
 	$sql="SELECT $field FROM $this->table $condition $order $limit";
 	return $sql;
 }
 //where条件 表达式
 protected function exp($key,$val,$keyarray){ 
    
 	switch (strtoupper($val[0])){
 		case 'EQ':
 			$str='= '.$val[1];
 		break;
 		case 'NEQ':
 			$str='<> '.$val[1];
 		break;
 		case 'GT':
 			$str='> '.$val[1];
 		break;
 		case 'EGT':
 			$str='>= '.$val[1];
 		break;
 		case 'LT':
 			$str='< '.$val[1];
 		break;
 		case 'ELT':
 			$str='<= '.$val[1];
 		break;
 		case 'BETWEEN':		
 			if(is_array($val[1])){
 				$str=' BETWEEN '.$val[1][0].' and '.$val[1][1];
 			}else{
 				$str=' BETWEEN '.$val[1];
 			}
 		break;
 		case 'IN':
 			$str='IN'.' ('.$val[1].')';
 		break;
 		case 'LIKE':
 			$str='LIKE '.$val[1];
 		break;
 	}

 	return $key.' '.$str.' and ';
 }
 
 

}


