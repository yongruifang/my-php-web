<?php
class TrainerController extends CommonController{
    public function indexAction(){
        $opt = I('exec','get','string');
        if('trainer_delete_'==$opt) $this->delete_trainer();
        else if('log_illegal_delete_'==$opt) $this->delete_log_illegal();
        else if('assignment_delete_'==$opt) $this->delete_assignment();

        if(IS_POST){
            if('trainer_edit_'==$opt) $this->edit_trainer(0);
            else if('trainer_add_'==$opt) $this->edit_trainer(1);
            else if('log_illegal_edit_'==$opt) $this->edit_log_illegal(0);
            else if('log_illegal_add_'==$opt) $this->edit_log_illegal(1);  
            else if('assignment_edit_'==$opt) $this->edit_assignment(0);
            else if('assignment_add_'==$opt) $this->edit_assignment(1);  
        }
        $this->trainers=New_model('trainer')->getList();
        $this->log_illegals=New_model('log_illegal')->getList();
        $this->assignments=New_model('assignment')->getList();
        $this->display();
    }
    private function delete_trainer(){
        $id = I('id','get','int');
        New_model('trainer')->delete(['id'=>$id]);
    }
    private function delete_log_illegal(){
        $tid = I('tid','get','int');
        New_model('log_illegal')->delete(['tid'=>$tid]);
    }
    private function delete_assignment(){
        // $cid = I('cid','get','int');
        // New_model('log_illegal')->delete(['tid'=>$tid]);
    }
    private function edit_trainer($opt){
        $this->id = I('id','get','int');
        $trainer = New_model('trainer');
        $data=[
            'id'=>I('id','post','int'),
        ];
        // $data['id'] = $this->id;
        if($opt==0)$trainer->save($data,$where='id');
        else if($opt==1)$trainer->add($data);
        $this->data=$data;
    }
    private function edit_log_illegal($opt){
        $this->tid = I('tid','get','int');
        $log_illegal = New_model('log_illegal');
        $data=[
            'tid'=>I('tid','post','int'),
            'times'=>I('times','post','int'),
        ];
        if($opt==0)$log_illegal->save($data,$where='tid');
        else if($opt==1)$log_illegal->add($data);
        $this->data=$data;
    }
    private function edit_assignment($opt){
        
    }
    public function customer_listAction(){
        $result = New_null_model()->query("call trainer_customers()");
        $this->datas = $result;
        $this->display();
    }
    public function customer_feeAction(){
        $result = New_null_model()->query("call performance()");
        $this->datas = $result;
        $this->display();
    }
}