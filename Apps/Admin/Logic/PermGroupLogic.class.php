<?php
namespace Admin\Logic;
use Think\Model;

/**
 * 权限组业务逻辑
 * 封装对权限组相关操作的函数
 * 
 * 2014/7/13
 * @author webdd
 *
 */
class PermGroupLogic extends Model {
	
	/**
	 * 根据分组id获取该分组下面的所有的权限对应id
	 * 如果为超级管理员，返回管理员标记
	 * 
	 * @param string $perm_group_id
	 * @return Array(Integer) $permIdArr
	 * @return String Administrator 如果是超级管理员，则返回该字符串
	 */
	public function getPermIdList($perm_group_id){
		
		$permIdArr = array();
		//得到管理员所拥有的权限分组id数组
		$permGroupIdArr = explode(',',$perm_group_id);
		//p($permGroupIdArr);
		//建立查询条件，根据权限分组id查询所有权限分组
		$condition['perm_group_id'] = array('in',$permGroupIdArr);
		$permGroupArr = $this->where($condition)->select();
		//p($permGroupArr);
		//循环遍历所有权限分组，得到权限id数组
		foreach ($permGroupArr as $key=>$val) {
			//如果是超级管理员，直接返回Administrator字符串
			if ($val['permission'] == "Administrator") {
				return "Administrator";
			}
			$permIdArr = array_merge($permIdArr,explode(',',$val['permission']));
		}
		//p($permIdArr);
		//处理数组，删除重复id，整理成一维数组
		$newPermIdArr = array();
		for ($i = 0;$i<count($permIdArr);$i++) {
			if (!in_array($permIdArr[$i],$newPermIdArr)) {
				array_push($newPermIdArr,$permIdArr[$i]);
			}
		}
		//返回处理完成的权限数组信息
		return $newPermIdArr;
	}
	
	/**
	 * 根据指定权限分组id，获取其详细信息
	 * 
	 * @param Array(integer) $permGroupIdList
	 * @return Array $permGroupList
	 */
	public function getPermGroupInfo($permGroupIdList){
		$permGroupList = array();
		foreach ($permGroupIdList as $k=>$v) {
			//echo $v;
			$permGroupList[] = $this->find($v);
		}
		return $permGroupList;
	}
	
	/**
	 * 获取当前分组的所有权限组信息
	 * @param unknown $adminGroupList
	 */
	public function getAdminGroupPermGrouInfo($adminGroupList) {
		foreach ($adminGroupList as $k=>$v) {
			$permGroupIdArr = explode(',',$v['perm_group_id']);
			$i = 0;
			foreach ($permGroupIdArr as $val) {
				$permGroup = $this->find($val);
				$adminGroupList[$k]['perm_group'][$i] = array('perm_group_id'=>$permGroup['perm_group_id'],'name'=>$permGroup['name']);
				$i++;
			}
		}
		//p($adminGroupList);
		return $adminGroupList;
	}
	
	/**
	 * 获取所有权限分组信息
	 * @return array $permGroupList
	 */
	public function getPermGroupList(){
		$where = "permission <> 'Administrator'";
		$permGroupList = $this->where($where)->select();
		//p($this->getLastSql());
		return $permGroupList;
	}
	
	/**
	 * 删除所有分组中该权限ID信息
	 * @param integer $permission_id
	 * @return boolean;
	 */
	public function delPermissionId($permission_id){
		$permGroupArr = $this->select();
		$permIds = array();
		foreach ($permGroupArr as $k=>$v) {
			$permIds = explode(',',$v['permission']);
			//如果权限组所拥有的权限中包含该权限
			if (in_array($permission_id,$permIds)){
				//重新拼接权限字符串
				$idStr = "";
				foreach ($permIds as $val){
					if ($val != $permission_id) {
						$idStr .= $val . ',';
					}
				}
				$idStr = substr ( $idStr, 0, strlen ( $idStr ) - 1 );
				//更新权限
				$data ['permission'] = $idStr;
				$id = $v['perm_group_id'];
				$flag = $this->where('perm_group_id = ' . $id)->save($data);
				//如果失败，直接返回false
				if ($flag === false){
					return false;
				}
			}
		}
		return true;
	}
	
	/**
	 * 为权限数组对应条目附加密文
	 * @param array $permGroupList
	 * @return array $permGroupList
	 */
	public function setMw($permGroupList) {
		foreach ($permGroupList as $k=>$v) {
			$permGroupList[$k]['mw'] = passport_encrypt($v['perm_group_id']);
		}
		return $permGroupList;
	}
}