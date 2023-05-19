<?php

class HealthModel extends Model{
    public function getList($mode='all'){
        static $result=[];
        if(empty($result)){
            $data=$this->fetchAll('SELECT * FROM `health`');
            foreach($data as $v){
                $result[$v['no']]=$v;
            }
        }
        return isset($result[$mode])?$result[$mode]:$result;
    }
}