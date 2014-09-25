<?php
function AdvertiseType($key=0){
	$array=array(
			1=>'图片',
			2=>'文字',
			3=>'FLASH',
			4=>'HTML'
	);
	if(!empty($key)){
		return $array[$key]; 
	}
	return $array;
}

//返回商品策略类型
function ProductsStrategyType($key=0){
	$array=array(
			1=>'上架',
			2=>'下架',
			3=>'上线',
			4=>'下线'
	);
	if(!empty($key)){
		return $array[$key];
	}
	return $array;
}
//返回商品策略执行状态
function ProductsStrategyExe($key=0){
	$array=array(
			1=>'未执行',
			2=>'执行中',
			3=>'已完成'
	);
	if(!empty($key)){
		return $array[$key];
	}
	return $array;
}
//虚拟POST
function SendPost($postData=array(),$url=''){
	if(empty($url) || count($postData)<1){
		return false;
	}
	$str="";
	foreach ($postData as $k=>$v){
		$str.= "$k=".urlencode($v)."&";
	}
	$postData=substr($str,0,-1);
	
	$c = curl_init();
	curl_setopt($c, CURLOPT_POST,1);
	curl_setopt($c,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_HEADER,0);
	curl_setopt($c, CURLOPT_URL,$url);
	curl_setopt($c, CURLOPT_POSTFIELDS, $postData);
	$result = curl_exec($c);
	
	if(curl_errno($c)){
		Log::write('模拟POST出错'.json_encode(curl_error($c)));
	}
	return $result;
}
//AJAX上传文件加密码
function GetAjaxPostFilePassJson($code=''){
	import('ORG.Util.String');
	if(empty($code)){
		$code=String::randString(10);
	}
	$arr[C("UPLOAD_ENCRYPT_PARAMRTER_CODE")]=$code;
    $arr[C("UPLOAD_ENCRYPT_PARAMRTER_NAME")]=md5($arr[C("UPLOAD_ENCRYPT_PARAMRTER_CODE")].C("UPLOAD_ENCRYPT_PARAMRTER_KEY"));
    return $arr;
}

/*
 * 独立分组时，模型调用
 * 
 */
function X($name='',$layer='',$common=false) {
	if(empty($name)) return new Model;
	static $_model  =   array();
	$layer          =   $layer?$layer:C('DEFAULT_M_LAYER');
	if(strpos($name,'://')) {// 指定项目
		$name       =   str_replace('://','/'.$layer.'/',$name);
	}else{
		$name       =   C('DEFAULT_APP').'/'.$layer.'/'.$name;
	}
	if(isset($_model[$name]))   return $_model[$name];
	
	if($common){ // 独立分组情况下 加载公共目录类库
		import(str_replace('@/','',$name).$layer,LIB_PATH);
	}else{
		import($name.$layer);
	}

	$class          =   basename($name.$layer);
	if(class_exists($class)) {
		$model      =   new $class();
	}else {
		$model      =   new Model(basename($name));
	}
	$_model[$name]  =  $model;
	return $model;
}

/*
 * 信息加密,与解密码
 * */
function AuthCode($string, $operation = 'DECODE', $key = '', $expiry = 0){
	$ckey_length = 4;
	$key = md5($key ? $key : COOKIE_INFO_PASS);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	}else{
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}