<?php

class LevelModel extends Model{
    public function getList($mode='all'){
        static $result=[];
        if(empty($result)){
            $data=$this->fetchAll('SELECT * FROM `level`');
            foreach($data as $v){
                $result[$v['no']]=$v;
            }
        }
        return isset($result[$mode])?$result[$mode]:$result;
    }
}