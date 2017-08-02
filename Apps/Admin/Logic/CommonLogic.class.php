<?php
namespace Admin\Logic;
use Think\Model;

/**
 * 公共模型类
 * 封装部分依靠模型的函数
 * 
 * 2014/7/13
 * @author webdd
 *
 */
class CommonLogic extends Model{
	
	/**
	 * 获取服务器MySQL版本信息
	 *
	 * @return string
	 */
	public function getMysqlVersion() {
		$version = $this->query ( "select version() as ver" );
		return $version [0] ['ver'];
	}
	
	/**
	 * 获取服务器MySQL大小
	 *
	 * @return string
	 */
	public function getMysqlSize() {
		$sql = "SHOW TABLE STATUS FROM " . C ( 'DB_NAME' );
		$tblPrefix = C ( 'DB_PREFIX' );
		if ($tblPrefix != null) {
			$sql .= " LIKE '{$tblPrefix}%'";
		}
		$row = $this->query ( $sql );
		$size = 0;
		foreach ( $row as $value ) {
			$size += $value ["Data_length"] + $value ["Index_length"];
		}
		return round ( ($size / 1048576), 2 ) . 'M';
	}
}