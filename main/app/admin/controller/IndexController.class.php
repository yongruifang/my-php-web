<?php
class IndexController extends CommonController{
    public function indexAction(){
		$opt = I('exec','get','string');
		if('delete_18'==$opt) $this->delete_18();
        $this->display();
    }
    //获取MySQL版本信息
	private function _getMySQLVer(){
		$data = New_null_model()->fetchColumn('SELECT VERSION() AS ver');
		return $data ? $data : '未知';
	}
    //内容区域
    public function homeAction(){
        //获取服务器基本信息
		$this->data = [
			//获取服务器信息（操作系统、Apache版本、PHP版本）
			'server' => I('SERVER_SOFTWARE', 'server', 'html'),
			//获取MySQL版本信息
			'mysql' => $this->_getMySQLVer(),
			//获取服务器时间
			'time' => date('Y-m-d H:i:s', time()),
			//上传文件大小限制
			'max_upload' => ini_get('file_uploads') ? ini_get('upload_max_filesize') : '已禁用', 
			//脚本最大执行时间
			'max_ex_time' => ini_get('max_execution_time').'秒'
		];
		$this->display();
    }
	private function delete_18(){
        New_model('customer')->query("call delete_illegal_customer");
    }
	//统计区域
	public function statisticAction(){
		//顾客年龄分布
		$age_distrib = array(0,0,0,0,0);
		// var_dump($age_distrib);
		$result = New_model('customer')->fetchAll("select getAge(c.birth_date) age from customer c order by age");
		$row = count($result);//echo $row;
		for($i=0;$i<$row;$i++){
			// echo $result[$i]['age'];
			$age = $result[$i]['age'];
			// echo $age.'<br/>';
			if($age<=0||$age>=110){
				continue;
			}
			if($age<30){
				$age_distrib[0] += 1;
			}else if($age<40){
				$age_distrib[1] += 1;
			}else if($age<50){
				$age_distrib[2] += 1;
			}else if($age<60){
			 	$age_distrib[3] += 1;
			}else{
			 	$age_distrib[4] += 1;
			}
		}
		$this->age_distrib = $age_distrib;
		$this->customer_cnt = $row; 
		$result = New_model('trainer')->fetchAll('select * from trainer');
		$row = count($result);
		$this->trainer_cnt = $row;
		$result = New_model('level')->fetchAll('select * from level');
		$row = count($result);
		$this->level_cnt = $row;
		//顾客运动频次分布
		$result = New_model('customer')->fetchAll("select COUNT(*)  cnt from customer c GROUP BY exercise_no ORDER BY exercise_no");
		$row = count($result);
		$data = "";
		for($i=0;$i<$row;$i++){
			$data[$i]=$result[$i]['cnt'];
		}
		$this->frequency = $data;
		//顾客健壮水平分布
		$result = New_model('customer')->fetchAll("select COUNT(*)  cnt from customer c GROUP BY fitness_no ORDER BY fitness_no");
		$row = count($result);
		$data = "";
		for($i=0;$i<$row;$i++){
			$data[$i]=$result[$i]['cnt'];
		}
		$this->fit = $data;
		//顾客健康水平分布
		$result = New_model('customer')->fetchAll("select COUNT(*)  cnt from customer c GROUP BY health_no ORDER BY health_no");
		$row = count($result);
		$data = "";
		for($i=0;$i<$row;$i++){
			$data[$i]=$result[$i]['cnt'];
		}
		$this->health = $data;
		$this->display();
	}
}