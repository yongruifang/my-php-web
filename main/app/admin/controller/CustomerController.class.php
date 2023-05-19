<?php
class CustomerController extends CommonController{
    public function indexAction(){
        $opt = I('exec','get','string');
        if('customer_delete_'==$opt) $this->delete_customer();
        else if('level_delete_'==$opt) $this->delete_level();
        else if('fitness_delete_'==$opt) $this->delete_fitness();
        else if('exercise_delete_'==$opt) $this->delete_exercise();
        else if('health_delete_'==$opt) $this->delete_health();
        if(IS_POST){
            if('customer_edit_'==$opt) $this->edit_customer(0);
            else if('customer_add_'==$opt) $this->edit_customer(1);        
            else if('level_edit_'==$opt) $this->edit_level(0);
            else if('level_add_'==$opt) $this->edit_level(1);
            else if('fitness_edit_'==$opt) $this->edit_fitness(0);
            else if('fitness_add_'==$opt) $this->edit_fitness(1);
            else if('exercise_edit_'==$opt) $this->edit_exercise(0);
            else if('exercise_add_'==$opt) $this->edit_exercise(1);
            else if('health_edit_'==$opt) $this->edit_health(0);
            else if('health_add_'==$opt) $this->edit_health(1);            
        }
        
        $this->customers=New_model("customer")->getList();
        $this->healths=New_model("health")->getList();
        $this->fitnesss=New_model("fitness")->getList();
        $this->exercises=New_model("exercise")->getList();
        $this->levels=New_model("level")->getList();
        $this->display();
    }
    private function delete_customer(){
        $id = I('id','get','int');
        New_model('customer')->delete(['id'=>$id]);
    }
    private function delete_level(){
        $no = I('no','get','int');
        New_model('level')->delete(['no'=>$no]);
    }
    private function delete_fitness(){
        $no = I('no','get','int');
        New_model('fitness')->delete(['no'=>$no]);
    }
    private function delete_exercise(){
        $no = I('no','get','int');
        New_model('exercise')->delete(['no'=>$no]);
    }
    private function delete_health(){
        $no = I('no','get','int');
        New_model('health')->delete(['no'=>$no]);
    }
    private function edit_customer($opt){
        $this->id = I('id','get','int');
        $customer = New_model('customer');
        $data=[
            'id'=>I('id','post','int'),
            'fitness_no'=>I('fitness_no','post','int'),
            'exercise_no'=>I('exercise_no','post','int'),
            'tid'=>I('tid','post','int'),
            'birth_date'=>date("Y-m-d H:i:s",strtotime(I('birth_date','post','html'))),
            'credit_card' => I('credit_card','post','int'),
            'health_no'=> I('health_no','post','int'),
            'level_no'=> I('level_no','post','int')
        ];
        // $data['id'] = $this->id;
        if($data['id'] == 0){
            unset($data['id']);
        }
        if($opt==0)$customer->save($data,$where='id');
        else if($opt==1)$customer->add($data);
        $this->data=$data;
    }
    private function edit_level($opt){
        $this->no = I('no','get','int');
        $level = New_model('level');
        $data=[
            'no'=>I('no','post','html'),
            'text'=>I('text','post','html'),
            'fee'=>I('fee','post','html'),
        ];
        // $data['no'] = $this->no;
        if($opt==0)$level->save($data,$where='no');
        else if($opt==1)$level->add($data);
        $this->data=$data;
    }
    private function edit_fitness($opt){
        $this->no = I('no','get','int');
        $fitness = New_model('fitness');
        $data=[
            'no'=>I('no','post','html'),
            'text'=>I('text','post','html'),
        ];
        // $data['no'] = $this->no;
        if($opt==0)$fitness->save($data,$where='no');
        else if($opt==1)$fitness->add($data);
        $this->data=$data;
    }
    private function edit_exercise($opt){
        $this->no = I('no','get','int');
        $exercise = New_model('exercise');
        $data=[
            'no'=>I('no','post','html'),
            'text'=>I('text','post','html'),
        ];
        // $data['no'] = $this->no;
        if($opt==0)$exercise->save($data,$where='no');
        else if($opt==1)$exercise->add($data);
        $this->data=$data;
    }
    private function edit_health($opt){
        $this->no = I('no','get','int');
        $health = New_model('health');
        $data=[
            'no'=>I('no','post','html'),
            'text'=>I('text','post','html'),
        ];
        // $data['no'] = $this->no;
        if($opt==0)$health->save($data,$where='no');
        else if($opt==1)$health->add($data);
        $this->data=$data;
    }

    public function age_xAction(){
        $age = I('age','get','int');
        $result = New_model('customer')->fetchAll("select * from customer c where getAge(c.birth_date)>".$age);
        $this->customers = $result;
        $this->display();
    }
    public function gold_fitAction(){
        $result = New_model('customer')->fetchAll("call fit_gold");
        $this->customers = $result;
        $this->display();
    }
}