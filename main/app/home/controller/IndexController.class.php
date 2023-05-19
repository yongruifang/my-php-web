<?php
//前台首页控制器
class IndexController extends CommonController{
	public function indexAction(){
		$this->title = '首页';
		$this->display();
	}
}