<?php
class AssignmentModel extends Model{
    public function getList($mode='all'){
        static $result=[];
        if(empty($result)){
            $data=$this->fetchAll('SELECT * FROM `assignment`');
            foreach($data as $v){
                $result[$v['cid'].$v['tid']]=$v;
            }
        }
        return isset($result[$mode])?$result[$mode]:$result;
    }
}