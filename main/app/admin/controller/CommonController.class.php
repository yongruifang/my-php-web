<?php
//后台公共控制器
class CommonController extends Controller{
	public function __construct(){
		parent::__construct();
		//检查用户是否登录
		$this->_checkLogin();
	}
	private function _checkLogin(){
		//判断session中是否有管理员信息
		if(session('admin', '', 'isset')){
			$this->user = session('admin');
		}
	}	
}