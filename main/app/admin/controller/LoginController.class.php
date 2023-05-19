<?php
class LoginController extends CommonController{
	//用户登录
	public function indexAction(){
		if(IS_POST){
			//接收变量
			$name = I('name', 'post', 'html');
			$password = I('password', 'post', 'string');
			$captcha = I('captcha', 'post', 'string');
			$this->name = $name;
			//判断验证码
			if(!$this->_checkCaptcha($captcha)){
				$this->tips(false, '验证码输入有误');
				$this->display(); //显示信息并退出
			}
			try{ //实现用户登录
				$userinfo = New_model('admin')->login($name, $password);
			}catch(Exception $e){
				$this->tips(false, $e->getMessage());
				$this->display(); //显示信息并退出
			}
			//登录成功，保存到Session
			session('admin', $userinfo, 'save');
			//跳转
			$this->redirect('?p=admin&c=index&a=index');
		}
		if('logout'==I('tips', 'get', 'string')){
			$this->tips(true, '您已经成功退出。');
		}
		$this->name = '';
		$this->display();
	}
	//生成验证码
	public function captchaAction(){
		//生成验证码
		$code = Captcha::create();
		//输出验证码
		Captcha::show($code);
		//将验证码保存到Session中
		session('captcha', $code, 'save');	
	}
	//检查验证码
	private function _checkCaptcha($code){
		$captcha = session('captcha');
		if(!empty($captcha)){
			session('captcha', '', 'unset');  //清除验证码，防止重复验证
			return strtoupper($captcha) == strtoupper($code); //不区分大小写
		}
		return false;
	}
	//退出登录
	public function logoutAction(){
		session('admin', '', 'unset');
		$this->redirect('?p=admin&c=login&tips=logout');
	}
}