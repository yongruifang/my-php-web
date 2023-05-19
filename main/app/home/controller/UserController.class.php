<?php
/**
 * 1. __construct
 * 2. registerAction
 * 3. loginAction
 * 4. logoutAction
 * 5. captchaAction
 * 6. _checkCaptcha
 * 7. _input
 * 8. indexAction
 * 9. buyAction
 */
class UserController extends CommonController{
    //构造方法-检查用户登录
	public function __construct() {
		parent::__construct();
		if(!IS_LOGIN && !in_array(ACTION, ['register','login','captcha'])){
			$this->redirect('/?c=user&a=login');
		}
	}
	//用户注册
	public function registerAction(){
		$this->title = '用户注册';
		if(IS_POST){
			$input = [];
			try{
				$this->_input('captcha');
				$input['name'] = $this->_input('name');
				$input['password'] = $this->_input('password');
				$input['email'] = $this->_input('email');
				//判断用户名是否已经注册
				if(New_model('user')->exists(['name'=>$input['name']])){
					throw new Exception('注册失败，用户名已经存在。');
				}
			}catch(Exception $e){
				$this->name = I('name', 'post', 'html');
				$this->email = I('email', 'post', 'html');
				$this->tips(false, $e->getMessage());
				$this->display();
			}
			$input['salt'] = Salt();
			$input['password'] = Add_salt($input['password'], $input['salt']);
			if($id = New_model('user')->add($input)){
				//注册成功，保存到Session
				Session('user', ['id'=>$id, 'name'=>$input['name']], 'save');
				//跳转到首页
				$this->redirect('?p=home&c=index&a=index');
			}
			$this->tips(false, '注册失败，无法添加到数据库。');
		}
		$this->name = '';
		$this->email = '';
		$this->display();
	}
	//用户登录
	public function loginAction(){
		$this->title = '用户登录';
		if(IS_POST){
			try{
				$this->_input('captcha');
				$name = $this->_input('name');
				$password = $this->_input('password');
				//实现用户登录
				$userinfo = New_model('user')->login($name, $password);
			}catch(Exception $e){
				$this->name = I('name', 'post', 'html');
				$this->tips(false, $e->getMessage());
				$this->display();
			}
			//登录成功，保存到Session
			Session('user', $userinfo, 'save');
			//跳转到首页
			$this->redirect('?p=home&c=index&a=index');
		}
		$this->display();
	}
	//用户退出
	public function logoutAction(){
		//清除Session
		Session('user', '', 'unset');
		//返回首页
		$this->redirect('?p=home&c=index&a=index');
	}
	//生成验证码
	public function captchaAction(){
		//生成验证码
		$code = Captcha::create();
		//输出验证码
		Captcha::show($code);
		//将验证码保存到Session中
		Session('captcha', $code, 'save');	
	}
	//检查验证码
	private function _checkCaptcha($code){
		$captcha = Session('captcha');
		if(!empty($captcha)){
			Session('captcha', '', 'unset');  //清除验证码，防止重复验证
			return strtoupper($captcha) == strtoupper($code); //不区分大小写
		}
		return false;
	}
	//接收表单并进行验证
	private function _input($name){
		switch($name){
			case 'captcha': //验证码
				$value = I('captcha', 'post', 'string');
				if(!$this->_checkCaptcha($value)){
					throw new Exception('登录失败，验证码输入有误');
				}
			break;
			case 'name'://用户名
				$value = I('name', 'post', 'html');
				if(!preg_match('/^[\w\x{4e00}-\x{9fa5}]{2,20}$/u',$value)){
					throw new Exception('用户名不合法(2~20位, 可以是汉字、英文、数字、下划线)');
				}
			break;
			case 'password'://密码
				$value = I('password', 'post', 'string');
				if(!preg_match('/^\w{6,20}$/',$value)){
					throw new Exception('密码不合法(6-20位,英文、数字、下划线）。');
				}
			break;
			case 'email': //邮箱地址
				$value = I('email', 'post', 'html');
				if(($value=="" || isset($value[30])) || !preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',$value)){
					throw new Exception('邮箱格式不正确(1-30个字符)。');
				}
			break;
		}
		return $value;
	}
	//用户中心
	public function indexAction(){
		$this->title = '用户中心';
		$this->display();
	}
	//确认购买
	public function buyAction(){
		$this->display();
	}
}