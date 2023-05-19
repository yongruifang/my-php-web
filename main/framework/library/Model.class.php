<?php
/** 基础模型类
 * 1. __construct
 * 2. query($sql,$data=[])
 * 3. select($fields,$data,$mode='fetchAll')
 * 4. add($data)
 * 5. replace($data)
 * 6. save($data, $where='id')
 * 7. update($fields, $where)
 * 8. change($field, $old, $new)
 * 9. delete($data)
 * 10.exists($data)
 * 11.escapeLike($like): 需要转义% _ \\   函数名取自-->转义码(escape code)
 * 12._getFields($data)
 * 13._fieldsMap($fields)
 * 14.getLimit($page, $size): 分页专用函数
 */
class Model extends MySQLPDO{
	protected $table = '';  //保存表名
	//1 构造方法
	public function __construct($table=false) {
		parent::__construct();
		$this->table = $table ? C('DB_PREFIX').$table : '';
	}
	//2 执行SQL-查询操作（支持批量操作）
	public function query($sql, $data=[]){
		//SQL语句模板语法替换
		$prefix = C('DB_PREFIX');
		$sql = preg_replace_callback('/__([A-Z0-9_-]+)__/sU', function($match) use($prefix){
			return '`'.$prefix.strtolower($match[1]).'`';
		}, $sql);
		//调用数据库操作类MySQLPDO执行SQL
		return parent::query($sql, $data);
	}
	//3 查找数据
	public function select($fields, $data, $mode='fetchAll'){
		$fields = str_replace(',', '`,`', $fields);
		$where = implode(' AND ', self::_fieldsMap(array_keys($data)));
		return $this->$mode("SELECT `$fields` FROM `$this->table` WHERE $where", $data);
	}
	
	//4 添加数据（支持批量操作）
	public function add($data){
		//获取所有字段
		$fields = self::_getFields($data);
		//拼接SQL语句
		$sql = "INSERT INTO `$this->table` (`".implode('`,`', $fields).'`) VALUES (:'.implode(',:', $fields).')';
		//调用数据库操作类执行SQL，成功返回最后插入的ID，失败返回false
		return $this->query($sql, $data) ? $this->lastInsertId() : false;
	}
	
	//5 替换数据（支持批量操作）
	public function replace($data){
		$fields = self::_getFields($data);
		return $this->exec("REPLACE INTO `$this->table` (`".implode('`,`', $fields).'`) VALUES (:'.implode(',:', $fields).')', $data);
	}
	
	//6 修改数据（支持批量操作）
	public function save($data, $where='id'){
		$where = explode(',', $where);  //获取所有WHERE字段
		$fields = array_diff(self::_getFields($data), $where);  //获取所有操作字段
		//拼接SQL语句
		$fields = implode(',', self::_fieldsMap($fields));
		$where = implode(' AND ', self::_fieldsMap($where));
		//执行SQL
		return $this->exec("UPDATE `$this->table` SET $fields WHERE $where", $data);
	}
	
	//7 修改数据（字段、条件分开）
	public function update($fields, $where){
		$data = array_merge($fields, $where);
		$fields = implode(',', self::_fieldsMap(self::_getFields($fields)));
		$where = implode(' AND ', self::_fieldsMap(self::_getFields($where)));
		return $this->exec("UPDATE `$this->table` SET $fields WHERE $where", $data);
	}
	
	//8 修改指定字段
	public function change($field, $old, $new){
		return $this->exec("UPDATE `$this->table` SET `$field`=:new WHERE `$field`=:old", ['new'=>$new, 'old'=>$old]);
	}
	
	//9 删除记录（支持批量操作）
	public function delete($data){
		$fields = implode(' AND ', self::_fieldsMap(self::_getFields($data))); //获取所有字段
		return $this->exec("DELETE FROM `$this->table` WHERE $fields", $data);
	}
	
	//10 根据条件检查记录是否存在
	public function exists($data){
		$fields = implode(' AND ', self::_fieldsMap(self::_getFields($data))); //获取所有字段
		return (bool)$this->fetchColumn("SELECT 1 FROM `$this->table` WHERE $fields", $data);
	}
	
	//11 对LIKE条件进行转义
	public static function escapeLike($like){
		return strtr($like, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']); 
	}
	
	//12 自动从一维或二维数组中获取字段
	private static function _getFields($data){
		$row = current($data);
		return array_keys(is_array($row) ? $row : $data);
	}
	
	//13 将字段数组转换为SQL形式
	private static function _fieldsMap($fields){
		return array_map(function($v){ return "`$v`=:$v"; }, $fields);
	}
	
	//14 处理SQL语句中的Limit部分
	public static function getLimit($page, $size){
		return ($page-1) * $size . ',' . $size;
	}
}