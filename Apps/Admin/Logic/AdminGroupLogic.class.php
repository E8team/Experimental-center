<?php

namespace Admin\Logic;

use Think\Model;

/**
 * 管理员分组业务逻辑
 *
 * 2014/7/14
 * 
 * @author webdd
 *        
 */
class AdminGroupLogic extends Model {
	/**
	 * 设置管理员集合对应分组名称
	 *
	 * @param Array(Admin) $adminList        	
	 * @return Array(Admin) $adminNewList
	 */
	public function setGroupName($adminList) {
		$adminNewList = array ();
		foreach ( $adminList as $k => $v ) {
			
			$adminNewList [$k] ['admin_id'] = $v ['admin_id'];
			// ID密文处理
			$adminNewList [$k] ['mw'] = passport_encrypt ( $v ['admin_id'] );
			$adminNewList [$k] ['photo'] = $v ['photo'];
			$adminNewList [$k] ['name'] = $v ['name'];
			$adminNewList [$k] ['account'] = $v ['account'];
			$adminNewList [$k] ['email'] = $v ['email'];
			$adminNewList [$k] ['login_ip'] = $v ['login_ip'];
			$adminNewList [$k] ['login_time'] = $v ['login_time'];
			$adminNewList [$k] ['admin_group_name'] = $this->getGroupName ( $v ['admin_group_id'] );
			$adminNewList [$k] ['content'] = $this->getGroupName;
			switch ($v ['login_state']) {
				case 0 :
					$adminNewList [$k] ['login_state'] = '离线';
					break;
				case 1 :
					$adminNewList [$k] ['login_state'] = '在线';
					break;
				case 2 :
					$adminNewList [$k] ['login_state'] = '异常';
					break;
			}
		}
		return $adminNewList;
	}
	
	/**
	 * 获取指定分组名称
	 *
	 * @param Integer $admin_group_id        	
	 * @return String $admin_group_name
	 */
	private function getGroupName($admin_group_id) {
		$adminGroup = $this->find ( $admin_group_id );
		if (empty ( $adminGroup )) {
			return "null";
		}
		return $adminGroup ['name'];
	}
	
	/**
	 * 获取所有管理员分组列表
	 *
	 * @return Array(AdminGroup) $adminGroupList
	 */
	public function getAdminGroupList() {
		$adminGroupList = $this->select ();
		return $adminGroupList;
	}
	
	/**
	 * 返回管理员分组ID对应密文
	 * @param array $adminGroupList
	 * @return array $adminGroupList
	 */
	public function setAdminGroupListMw($adminGroupList) {
		foreach ($adminGroupList as $key=>$val) {
			$adminGroupList[$key]['mw'] = passport_encrypt($val['admin_group_id']);
		}
		return $adminGroupList;
	}
	
	/**
	 * 根据指定管理员分组，获取对应的权限分组信息
	 *
	 * @param integer $admin_group_id        	
	 * @return Array | boolean $adminGroupPermList | false
	 */
	public function getAdminGroupPermList($admin_group_id) {
		$adminGroup = $this->find ( $admin_group_id );
		if (is_null ( $adminGroup )) {
			// 对应管理员分组不存在
			return false;
		}
		$adminGroupPermList = explode ( ',', $adminGroup ['perm_group_id'] );
		return $adminGroupPermList;
	}
	
	/**
	 * 获取指定管理分组信息
	 *
	 * @param integer $admin_group_id        	
	 * @return Array $adminGroup
	 */
	public function getAdminGroup($admin_group_id) {
		$adminGroup = $this->find ( $admin_group_id );
		return $adminGroup;
	}
	
	/**
	 *
	 * @param Array $adminGroupList        	
	 */
	public function allotSecretKey($adminGroupList) {
		foreach ( $adminGroupList as $k => $v ) {
			
		}
	}
	
	/**
	 * 更改分组状态
	 *
	 * @param integer $admin_group_id        	
	 * @param integer $useful        	
	 * @return boolean
	 */
	public function changeUseful($admin_group_id) {
		if (is_null( $admin_group_id )){
			return false;
		}
		$adminGroup = $this->find($admin_group_id);
		if (empty($adminGroup)){
			return false;
		}
		$useful = ($adminGroup ['useful'] == 1)?0:1;
		$data ['useful'] = $useful;
		$data ['admin_group_id'] = $admin_group_id;
		//p ($data);
		if ($this->save ( $data ) !== false) {
			return $useful;
		}
		return false;
	}
	
	
	/**
	 * 根据指定权限数组ID，将对应管理员分组所包含的权限数组ID删除
	 * @param integer $perm_group_id
	 */
	public function delPermGroupId($perm_group_id){
		$adminGroupArr = $this->select();
		$permGroupIds = array();
		foreach ($adminGroupArr as $k=>$v) {
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
				$id = $v['admin_group_id'];
				$flag = $this->where('admin_group_id = ' . $id)->save($data);
				//如果失败，直接返回false
				if ($flag === false){
					return false;
				}
			}
		}
		return true;
	}
	
}