<?php

namespace Admin\Logic;

use Think\Model;

/**
 * 权限业务逻辑
 *
 * 2014/7/13
 * 
 * @author webdd
 *        
 */
class PermissionLogic extends Model {
	
	/**
	 * 根据权限id数组，获取对应Controller/Action并返回其集合数组
	 * 
	 * @param Array(Integer) $permIdArr    
	 * @return Array(String) $permActionArr    	
	 */
	public function getActionList($permIdArr) {
		$permArr = array ();
		if ($permIdArr === "Administrator") {
			// 如果是超级管理员，获取所有权限
			$permArr = $this->select ();
		} else {
			//定义表达式查询条件
			$map ['permission_id'] = array (
					'in',
					$permIdArr
			);
			$permArr = $this->where($map)->select();
		}
		$permActionArr = array();
		//格式化权限数组，只保留action字段
		foreach ($permArr as $k=>$v) {
			$permActionArr[] = $v['action'];
		}
		
		return $permActionArr;
	}
	
	
	/**
	 * 获取所有权限信息
	 * @return array $permissionList
	 */
	public function getPermissionList(){
		$permissionList = $this->select();
		return $permissionList;
	}
	
	/**
	 * 添加权限ID密文
	 * @param array $permissionList
	 * @return array $permissionList
	 */
	public function setPermissionIdMw($permissionList) {
		foreach ($permissionList as $key=>$val) {
			$permissionList[$key]['mw'] = passport_encrypt($val['permission_id']);
		}
		return $permissionList;
	}
	
	/**
	 * 根据权限分组中每个分组对应的权限字符串，获取对应权限数组
	 * @param array $permGroupList
	 * @return array $permGroupList
	 */
	public function getPermissionInfo ($permGroupList) {
		$permissionIds = array();
		foreach ($permGroupList as $k=>$v) {
			if (is_null($v['permission']))
				continue;
			if ($v['permission'] !== "Administrator") {
				$permissionIds = explode(',',$v['permission']);
				//echo "<pre>";
				//var_dump($permissionIds);
				$condition['permission_id'] = array('in',$permissionIds);
				$permissionArr = $this->where($condition)->select();
				$permGroupList[$k]['permission_arr'] = $permissionArr;
			}
		}
		return $permGroupList;
	}
	
	/**
	 * 根据该分组的权限字符串，获取他的已有和未有权限数组
	 * @param string $permissionIdStr
	 * @return array $permissionArr
	 */
	public function getPermGroupByIdstr($permissionIdStr){
		if (!is_null($permissionIdStr)){
			$permIdArr = explode(',',$permissionIdStr);
			$condition['permission_id'] = array('in',$permIdArr);
			$where['permission_id'] = array ('not in',$permIdArr);
			$haveArr = $this->where($condition)->select();
			$noArr = $this->where($where)->select();
		} else {
			$haveArr = $this->select();
			$noArr = array();
		}
		
		$permissionArr['have'] = $haveArr;
		$permissionArr['no'] = $noArr;
		return $permissionArr;
	}
	
}