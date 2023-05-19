<?php
/**
 * 前台公共控制器
 * 1. __construct: +启用布局, 调用导航栏+检查登录
 * * 2. _nav: 获取栏目
 * * 3. _checkLogin: 检查登录，$this->user的赋值
*/
class CommonController extends Controller{
	//构造方法
	public function __construct(){
		parent::__construct();
		//启用布局
		$this->layout(COMMON_VIEW.'layout.html');
		//检查登录
		$this->_checkLogin();
		//获取导航栏数据
		$this->_nav();
	}
	//获取导航栏栏目
	private function _nav(){
		//$this->nav = D('category')->getByPid(0);
	}
	//检查用户登录
	private function _checkLogin(){
		//判断session中是否有用户名信息
		define('IS_LOGIN', session('user', '', 'isset'));
		//如果登录，则取出Session
		if(IS_LOGIN){
			$this->user = session('user');
		}
	}
}