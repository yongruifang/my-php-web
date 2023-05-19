<?php
/**
 * 前台用户模型
 * 1. login($name,$password) 
*/
class UserModel extends Model{
	//登录
	public function login($name, $password){
		//根据用户名查询数据
		$result = $this->select('id,name,password,salt', ['name'=>$name], 'fetchRow');
		//验证1 - 用户名不存在
		if(!$result){
			throw new Exception('登录失败，用户名或密码错误');
		}
		//验证2 - 根据用户名判断密码
		elseif($result['password'] !== Add_salt($password, $result['salt'])){
			throw new Exception('登录失败，用户名或密码错误');
		}
		//返回用户名和ID
		return ['name'=>$result['name'], 'id'=>$result['id']];
	}
}