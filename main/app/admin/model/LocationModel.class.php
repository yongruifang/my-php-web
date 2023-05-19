<?php

class LocationModel extends Model{
    public function getList($mode='all'){
        static $result=[];
        if(empty($result)){
            $data=$this->fetchAll('SELECT * FROM `location`');
            foreach($data as $v){
                $result[$v['id']]=$v;
            }
        }
        return isset($result[$mode])?$result[$mode]:$result;
    }
}