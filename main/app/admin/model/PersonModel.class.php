<?php

class PersonModel extends Model{
    public function getList($mode='all'){
        static $result=[];
        if(empty($result)){
            $data=$this->fetchAll('SELECT * FROM `person`');
            foreach($data as $v){
                $result[$v['id']]=$v;
            }
        }
        return isset($result[$mode])?$result[$mode]:$result;
    }
}