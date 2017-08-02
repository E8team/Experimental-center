<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| MySQL模型/用于获取Mysql数据库信息 <逻辑层>
//+---------------------------------
//| Author: webdd <2014/8/27>
//+---------------------------------

namespace Admin\Logic;
use Think\Model;

class MysqlLogic extends Model{

	/**
	 * 获取服务器MySQL版本信息
	 * @return string
	 */
	public function getMysqlVersion() {
		$version = $this->query ( "select version() as ver" );
		return $version [0] ['ver'];
	}
	
	/**
	 * 获取服务器MySQL大小
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