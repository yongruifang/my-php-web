<?php
/**函数库
  * 1. Redirect($url): 重定向
  * 2. C($name)      : 获取配置信息
  * 3. I($var, $method='post', $type='html', $def=''): 过滤INPUT
  * 4. E($msg)       : 错误弹窗
  * 5. Session($name, $value='', $type='get')： 写session
  * 6. New_model($name) : 实例化模型
  * 7. New_null_model() : 空模型
  * 8. ToHtml($str)  : 字符串转HTML
  * 9. Salt()        : 生成盐值
  * 10.Add_salt($pwd,$salt) : 加盐
  * 11.Token_get()   : 获取Token
  * 12.Token_check($token='') : 验证Token
 **/
//1 重定向
function Redirect($url){
	header("Location:$url");
	exit;
}

//2 配置文件操作C-config
function C($name){
	static $config = null; //保存项目中的设置
	if(!$config){          //函数首次被调用时载入配置文件
		$config = require COMMON_PATH.'config.php';
	}
	return isset($config[$name]) ? $config[$name] : '';
}

/**
 * 3 接收INPUT变量，并进行过滤
 * @param string $var 变量名
 * @param array|string $method 待过滤的数组，或表示超全局变量的字符串
 * @param string $type 过滤类型
 * @param mixed $def 默认值
 * @return 过滤后的结果
 */
function I($var, $method='post', $type='html', $def=''){
	switch($method){
		case 'get':    $method = $_GET;    break;
		case 'post':   $method = $_POST;   break;
		case 'server': $method = $_SERVER; break;
		case 'cookie': $method = $_COOKIE; break;
	}
	$value = isset($method[$var]) ? $method[$var] : $def;
	if($type){
		switch($type){
			case 'string': //字符串 不进行过滤
				$value = is_string($value) ? $value : '';
			break;
			case 'html': //字符串 进行HTML转义 单行文本
				$value = is_string($value) ? toHTML($value) : '';
			break;
			case 'int': //整数
				$value = (int)$value;
			break;
			case 'uint': //无符号整数
				$value = max((int)$value, 0);
			break;
			case 'page': //页码
				$value = max((int)$value, 1);
			break;
			case 'float': //浮点数
				$value = (float)$value;
			break;
			case 'bool': //布尔型
				$value = (bool)$value;
			break;
			case 'array': //数组型
				$value = is_array($value) ? $value : [];
			break;
			case 'money': //金额（正数，保留两位小数，不四舍五入）
				$value =  floor(max($value, 0) * 100) / 100;
			break;
		}
	}
	return $value;
}
//4 遇到致命错误，输出错误信息并停止运行（考虑以弹窗的形式）
function E($msg, $debug=''){
	$msg .= APP_DEBUG ? $debug : '';
	//exit('<pre>'.htmlspecialchars($msg).'</pre>');
	$msg = str_replace('&nbsp;', ' ', $msg);
	$msg = str_replace('&lt;', '<', $msg);
	$msg = str_replace('&gt;', '>', $msg);
	$msg = str_replace('<br />', '\\r\\n', $msg);
	$msg = str_replace('<b>', ' ', $msg);
	$msg = str_replace('</b>', ' ', $msg);
    $address = $_SERVER['HTTP_REFERER'];
    exit("<script type=\"text/javascript\">
    window.location.href = \"$address\";
    alert(\"$msg\");
    </script>");
}
//5 写Session
function Session($name, $value='', $type='get'){
	$prefix = C('SESSION_PREFIX');
	isset($_SESSION[$prefix]) || $_SESSION[$prefix] = [];
	switch($type){
		case 'get':
			return isset($_SESSION[$prefix][$name]) ? $_SESSION[$prefix][$name] : '';
		case 'isset':
			return isset($_SESSION[$prefix][$name]);
		case 'save':
			$_SESSION[$prefix][$name] = $value;
		break;
		case 'unset':
			unset($_SESSION[$prefix][$name]);
		break;
	}
}

// 6 实例化模型
function New_model($name){
	static $Model = [];
	$name = strtolower($name); //统一转换为小写
	if(!isset($Model[$name])){
		$class_name = ucwords($name).'Model';
		$Model[$name] = is_file(MODEL_PATH."$class_name.class.php") ? new $class_name($name) : new Model($name);
	}
	return $Model[$name];
}
//7 实例化空模型
function New_null_model(){
	static $Model = null;
	$Model || $Model = new Model();
	return $Model;
}

//8 字符串转HTML
function ToHTML($str){
	$str = trim(htmlspecialchars($str, ENT_QUOTES));
	return str_replace(' ', '&nbsp;', $str);
}
//9 生成密钥, 盐就是一串随机数
function Salt(){
	return substr(uniqid(), -6);
}
//10 密码加密，配合密钥（盐）一起食用
function Add_salt($password, $salt){
	return md5(md5($password).$salt);
}
//11 生成/获取令牌，也用到md5
function Token_get(){
	if(session('token', '', 'isset')){
		$token = session('token');
	}else{
		$token = md5(microtime(true));
		session('token', $token, 'save');
	}
	return $token;
}

//验证令牌
function Token_check($token=''){
	if(!$token){ //自动取出token
		$token = I('token', 'get', 'string');
	}
	return token_get() == $token;
}