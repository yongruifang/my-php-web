<?php
class CustomerModel extends Model{
    public function getList($mode="all"){
        static $result=[];
        if(empty($result)){
            $data=$this->fetchAll('SELECT * FROM `customer`');
            foreach($data as $v){
                $result[$v['id'].$v['id']]=$v;
            }
        }
        return isset($result[$mode])?$result[$mode]:$result;
    }
}