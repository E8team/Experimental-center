<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 后台管理用户模型 <逻辑层>
//+---------------------------------
//| Author: webdd <2014/8/29>
//+---------------------------------

namespace Admin\Logic;
use Think\Model;

class UserLogic extends Model {


	/**
	 * 登录验证函数，用于将表单数据与数据库进行比较
	 *
	 * @param string $account        	
	 * @param string $password        	
	 * @param boolean $login
	 *        	是否判断用户状态，默认为true
	 *        	
	 * @return $user
	 */
	public function login($account, $password, $login = true) {
		// 邮箱验证正则表达式
		$pattern = "^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+";
		// 正则表达式判断当前是账号登录还是邮箱登录
		ereg ( $pattern, $account ) ? $where ['email'] = $account : $where ['username'] = $account;
		$where ['password'] = md5 ( $password );
		$user = $this->where ( $where )->find ();
		return $user;
	}

}