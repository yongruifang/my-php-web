<?php

class Log_illegalModel extends Model{
    public function getList($mode='all'){
        static $result=[];
        if(empty($result)){
            $data=$this->fetchAll('SELECT * FROM `log_illegal`');
            foreach($data as $v){
                $result[$v['tid']]=$v;
            }
        }
        return isset($result[$mode])?$result[$mode]:$result;
    }
}