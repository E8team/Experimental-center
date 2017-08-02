<?php

namespace Admin\Logic;

use Think\Model;

/**
 * 管理员业务处理
 *
 * @author webdd
 *         2014/7/9
 */
class AdminLogic extends Model {
	
	
	/**
	 * 登录验证函数，用于将表单数据与数据库进行比较
	 *
	 * @param string $account        	
	 * @param string $password        	
	 * @param boolean $login
	 *        	是否判断用户状态，默认为true
	 *        	
	 * @return $admin
	 */
	public function login($account, $password, $login = true) {
		// 邮箱验证正则表达式
		$pattern = "^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+";
		// 正则表达式判断当前是账号登录还是邮箱登录
		preg_match( $pattern, $account ) ? $condition ['email'] = $account : $condition ['account'] = $account;
		$condition ['password'] = md5 ( $password );
		$admin = $this->where ( $condition )->find ();
		return $admin;
	}
	
	/**
	 * 获取指定管理员的姓名
	 *
	 * @param integer $admin_id        	
	 * @return string | boolean (false means User not found)
	 */
	public function getAdminName($admin_id) {
		$admin = $this->find ( $admin_id );
		if (is_null ( $admin )) {
			return false;
		}
		$name = (empty ( $admin ['name'] ) || trim ( $admin ['name'] ) == "") ? "未知姓名" : $admin ['name'];
		return $name;
	}
	public function getAdminList() {
	}
	
	/**
	 * 验证账户是否存在
	 *
	 * @param string $account        	
	 * @return boolean 存在返回true 不存在返回false
	 */
	public function checkAccount($account) {
		$condition ['account'] = $account;
		if (is_null ( $this->where ( $condition )->select () )) {
			return false;
		}
		return true;
	}
	
	/**
	 * 验证邮箱是否存在
	 *
	 * @param string $email        	
	 * @return boolean 存在返回true 不存在返回false
	 */
	public function checkEmail($email) {
		$condition ['email'] = $email;
		if (is_null ( $this->where ( $condition )->select () )) {
			return false;
		}
		return true;
	}
	
	/**
	 * 获取指定管理员的个人信息
	 * 
	 * @param integer $admin_id
	 * @return Admin $admin
	 */
	public function getAdminInfo($admin_id){
		$Admin = $this->find($admin_id);
		return $Admin;
	}
	
	
	/**
	 * 根据指定管理员分组，获取对应的权限分组信息
	 *
	 * @param integer $admin_id
	 * @return Array | boolean  $adminPermIdList | false
	 */
	public function getAdminPermIdList($admin_id){
		$admin = $this->find($admin_id);
		if (is_null($admin)){
			//对应管理员不存在
			return false;
		}
		$adminPermIdList = explode(',',$admin['perm_group_id']);
		return $adminPermIdList;
	}
	
	/**
	 * 获取指定分组的管理员人数和人员名单
	 * 
	 * @param array $adminGroupList
	 * @return array $AdminGroupList
	 */
	public function getAdminGroupUserInfo($adminGroupList){
		//循环统计每个数组的用户人数
		foreach ($adminGroupList as $k=>$v) {
			$condition['admin_group_id'] = $v['admin_group_id'];
			$adminArr = $this->where($condition)->select();
			$adminGroupList[$k]['admin_count'] = count($adminArr);
			//var_dump($adminArr);
			foreach ($adminArr as $key=>$val) {
				$adminGroupList[$k]['admin_info'][$key] = 
				array('admin_id'=>$val['admin_id'],'name'=>$val['name'],'mw'=>passport_encrypt($val['admin_id']));
			}
		}
		return $adminGroupList;
	}
	
	/**
	 * 根据指定管理员分组，将其下面的管理员分组值空
	 * @param array $admin_group_id
	 * @return boolean
	 */
	public function delAdminGroupId($admin_group_id){
		$data['admin_group_id'] = $admin_group_id;
		$flag = $this->where("admin_group_id = $admin_group_id")->save($data);
		if ($flag === false){
			return false;
		}
		return true;
	}
	
	/**
	 * 根据指定权限数组ID，将对应管理员所包含的权限数组ID删除
	 * @param integer $perm_group_id
	 */
	public function delPermGroupId($perm_group_id){
		$adminArr = $this->select();
		$permGroupIds = array();
		foreach ($adminArr as $k=>$v) {
			$permGroupIds = explode(',',$v['perm_group_id']);
			//如果用户所拥有的权限分组中包含该权限分组
			if (in_array($perm_group_id,$permGroupIds)){
				//重新拼接权限字符串
				$idStr = "";
				foreach ($permGroupIds as $val){
					if ($val != $perm_group_id) {
						$idStr .= $val . ',';
					}
				}
				$idStr = substr ( $idStr, 0, strlen ( $idStr ) - 1 );
				//更新
				$data ['perm_group_id'] = $idStr;
				$id = $v['admin_id'];
				$flag = $this->where('admin_id = ' . $id)->save($data);
				//如果失败，直接返回false
				if ($flag === false){
					return false;
				}
			}
		}
		return true;
	}
	
	/**
	 * 更改用户登录状态
	 * @param integer $admin_id
	 * @param integer $state
	 */
	public function changeState($admin_id,$state){
		$data['login_state'] = $state;
		$this->where('admin_id='.$admin_id )->save($data);
		//echo $this->getLastSql();
		if ($this->save($data) !== false){}
			return true;
		return false;
	}
	
}