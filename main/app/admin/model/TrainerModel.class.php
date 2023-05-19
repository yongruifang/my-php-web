<?php

class TrainerModel extends Model{
    public function getList($mode='all'){
        static $result=[];
        if(empty($result)){
            $data=$this->fetchAll('SELECT * FROM `trainer`');
            foreach($data as $v){
                $result[$v['id']]=$v;
            }
        }
        return isset($result[$mode])?$result[$mode]:$result;
    }
}