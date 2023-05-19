<?php
/**
 * 基于PDO扩展的MySQL数据库操作类
 * 1  __construct(): 实例化，单例
 * 2 __clone()：空实现
 * 3 _connect()
 * 4 _query($sql,$data=[]): 预处理
 * 5 exec($sql,$data=[])
 * 6 fetchAll($sql,$data=[])
 * 7 fetchRow($sql,$data=[])
 * 8 fetchColumn($sql,$data=[])
 * lastInsertId
**/
class MySQLPDO{
    //保存PDO实例
    protected static $db=null; 
    //实例化PDO对象
    public function __construct(){
        self::$db||self::_connect();
    }
    //阻止克隆
    private function __clone(){}
    private static function _connect(){
        //通过全局变量dbConfig获取数据库配置信息
        $config=C('DB_CONFIG');
        //DNS连接信息
        $dsn="{$config['db']}:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";
        try{
            self::$db=new PDO($dsn,$config['user'],$config['pass']);
        }catch(PDOExceptioin $e){
            //exit('数据库连接失败：'.$e->getMessage());
            //连接失败
			if(APP_DEBUG){
				E('数据库连接失败：'.$e->getMessage());
			}else{
				E('数据库连接失败');
			}
        }
    }
    /**
     * 通过预处理方式执行SQL
     */
    public function query($sql,$data=[]){
        $stmt=self::$db->prepare($sql);
        is_array(current($data))||$data=[$data];
        foreach($data as $v){
            if(false==$stmt->execute($v)){
                //exit('数据库操作失败：'.implode('-',$stmt->errorInfo()));
                if(APP_DEBUG){
					E('数据库操作失败：'.implode('-',$stmt->errorInfo())."\\r\\nSQL语句: ".$sql);
				}else{
					E('数据库操作失败');
				}
            }
        }
        return $stmt;
    }
    public function exec($sql,$data=[]){
        return $this->query($sql,$data)->rowCount();
    }
    public function fetchAll($sql,$data=[]){
        return $this->query($sql,$data)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fetchRow($sql,$data=[]){
        return $this->query($sql,$data)->fetch(PDO::FETCH_ASSOC);
    }
    public function fetchColumn($sql,$data=[]){
        return $this->query($sql,$data)->fetchColumn();
    }
    public function lastInsertId(){
        return self::$db->lastInsertId();
    }
}