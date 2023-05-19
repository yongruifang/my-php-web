<?php
class PersonController extends CommonController{
    public function indexAction(){
        $opt = I('exec','get','string');
        if('person_delete_'==$opt) $this->delete_person();
        else if('location_delete_'==$opt) $this->delete_location();
        if(IS_POST){
            if('person_edit_'==$opt) $this->edit_person(0);
            else if('person_add_'==$opt) $this->edit_person(1);
            else if('location_edit_'==$opt) $this->edit_location(0);
            else if('location_add_'==$opt) $this->edit_location(1);
            
        }
        $this->persons = New_model('person')->getList();
        $this->locations = New_model('location')->getList();
        $this->display();
    }
    private function delete_person(){
        $id = I('id','get','int');
        New_model('person')->delete(['id'=>$id]);
    }
    private function delete_location(){
        $id = I('id','get','int');
        New_model('location')->delete(['id'=>$id]);
    }
    private function edit_person($opt){
        $this->id = I('id','get','int');
        $person = New_model('person');
        $data=[
            'id'=>I('id','post','int'),
            'email'=>I('email','post','string'),
            'last_name'=>I('last_name','post','string'),
            'first_name'=>I('first_name','post','string'),
            'phone' => I('phone','post','string'),
        ];
        if($opt==0)$person->save($data,$where='id');
        else if($opt==1)$person->add($data);
        $this->data=$data;
    }
    private function edit_location($opt){
        
        $location = New_model('location');
        $data=[
            'id'=>I('id','post','int'),
            'zipcode'=>I('zipcode','post','string'),
            'city'=>I('city','post','string'),
            'address'=>I('address','post','string'),
            'state' => I('state','post','string'),
        ];
        // $data['id'] = $this->id;
        if($opt==0)$location->save($data,$where='id');
        else if($opt==1)$location->add($data);
        $this->data=$data;
    }
    public function delete_18Action(){
        $this->display();
    }
    public function add_customer_successAction(){
        $person = New_model('person');
        $data=[
            'id'=>I('id','post','int'),
            'email'=>I('email','post','string'),
            'last_name'=>I('last_name','post','string'),
            'first_name'=>I('first_name','post','string'),
            'phone' => I('phone','post','string'),
        ]; 
        if($data['id'] == 0){
            unset($data['id']);
        }
        $person->add($data);
        $location = New_model('location');
        $data=[
            'id'=>I('id','post','int'),
            'zipcode'=>I('zipcode','post','string'),
            'city'=>I('city','post','string'),
            'address'=>I('address','post','string'),
            'state' => I('state','post','string'),
        ];
        if($data['id'] == 0){
            unset($data['id']);
        }
        $location->add($data);
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
        if($data['id'] == 0){
            unset($data['id']);
        }
        $customer->add($data);
        $this->display();
    }
    public function add_trainer_successAction(){
        $person = New_model('person');
        $data=[
            'id'=>I('id','post','int'),
            'email'=>I('email','post','string'),
            'last_name'=>I('last_name','post','string'),
            'first_name'=>I('first_name','post','string'),
            'phone' => I('phone','post','string'),
        ]; 
        if($data['id'] == 0){
            unset($data['id']);
        }
        $person->add($data);
        $location = New_model('location');
        $data=[
            'id'=>I('id','post','int'),
            'zipcode'=>I('zipcode','post','string'),
            'city'=>I('city','post','string'),
            'address'=>I('address','post','string'),
            'state' => I('state','post','string'),
        ];
        if($data['id'] == 0){
            unset($data['id']);
        }
        $location->add($data);
        $trainer = New_model('trainer');
        $data=[
            'id'=>I('id','post','int'),
        ];
        if($data['id'] == 0){
            unset($data['id']);
        }
        $trainer->add($data);
        $this->display();
    }
    
}