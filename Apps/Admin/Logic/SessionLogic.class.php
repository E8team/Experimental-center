<?php
namespace Admin\Logic;
use Think\Model;

/**
 * session信息处理逻辑
 * @author webdd
 *
 */
class SessionLogic extends Model {
	
	/**
	 * 根据IP地址，测试该Session信息是否存在
	 * 如果存在，则返回该session信息，否则返回false
	 * @param string $ip
	 * @return $session | false
	 */
	public function checkSession($ip) {
		$condition['ip'] = $ip;
		$session = $this->where($condition)->find();
		if (is_null($session)) {
			return false;
		}
		return $session;
	}
	
	/**
	 * 根据IP地址，创建一条Session信息
	 * @param string $ip
	 * @return boolean
	 */
	public function createSession($ip,$name){
		$data['ip'] = $ip;
		$data['name'] = $name;
		if ($this->add($data))
			return true;
		return false;
	}
	
}