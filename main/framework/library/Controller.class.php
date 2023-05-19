<?php
/**
 * 基础控制器
 * 1. __construct
 * 2. __call($name,$args)
 * 3. __get($name) :读模板数据
 * 4. __set($name,$val):写模板数据
 * 5. display: 清空+视图
 * 6. layout($layout)
 * 7. redirect($url)
 * 8. tips($flag=false, $tips='')
 * 9. ajaxReturn($arr)
*/
class Controller{
	private $_data = [];      //模板变量
	private $_tips = '';      //提示信息
	private $_layout = false; //布局开关
	//1 构造方法
	public function __construct(){
		//对写操作自动进行令牌验证
		if((IS_POST || isset($_GET['exec'])) && !token_check()){
			E('操作失败: 令牌错误, 清除Cookie后重试。');
		}
	}
	//2 方法不存在时报错退出
	public function __call($name, $args){
		E('您访问的操作不存在！', $name);
	}
	//3 通过对象取出模板数据
	public function __get($name){
		return isset($this->_data[$name]) ? $this->_data[$name] : null;
	}
	//4 通过对象赋值模板数据
	public function __set($name, $value){
		$this->_data[$name] = $value;
	}
	//5 显示视图
	protected function display(){
		extract($this->_data);	//释放模板变量
		$this->_data = [];		//释放成员属性
		require $this->_layout ? $this->_layout : ACTION_VIEW; //载入视图
		exit; //停止脚本
	}
	//6 布局开关
	protected function layout($layout){
		$this->_layout = $layout;
	}
	//7 重定向
	protected function redirect($url){
		header("Location:$url");
		exit;
	}
	//8 提示信息
	protected function tips($flag=false, $tips=''){
		$this->_tips = $tips ? ($flag ?  "<div>$tips</div>" : "<div class=\"error\">$tips</div>") : '';
	}
	//9 返回ajax
	protected function ajaxReturn($arr){
		echo json_encode($arr);
		exit;
	}
}