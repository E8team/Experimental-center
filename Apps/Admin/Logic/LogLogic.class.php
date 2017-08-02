<?php
namespace Admin\Logic;
use Think\Model;

/**
 * 友链分组管理逻辑层
 * @author webzrf
 */
class LogLogic extends Model{
	
	/**
	 * 写入管理员日志信息
	 */
	public 	function write($admin_id,$content,$type) {
			$Log = D ('Log');
			$Log->admin_id = $admin_id;
			$Log->content = $content;
			$Log->type = $type;
			$Log->time = time();
			$Log->add();
	}
	
	/**
	 * 
	 * 读出管理员日志信息
	 */
	public 	function read($admin_id) {
		$Log = D ('Log');
		$logread = $Log->where("admin_id = $admin_id")->select();
		return $logread;
	}
	
	/**
	 * 
	 * 读出管理员日志
	 */
	public function getAdminLog($adminArr) {
		foreach ($adminArr as $key=>$val) {
			$condition['admin_id'] = $val['admin_id'];
			$logArr = $this->where($condition)->select();
			$adminArr[$key]['log'] = $logArr;
		}
		return $adminArr;
	}
	
}
?>