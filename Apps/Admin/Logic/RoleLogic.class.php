<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 用户角色表 <逻辑层>
//+---------------------------------
//| Author: webdd <2014/8/27>
//+---------------------------------

namespace Admin\Logic;
use Think\Model;

class RoleLogic extends Model {

	public function getRoleName($id) {
		$role = $this->find($id);
		if (!empty($role)) return $role['name'];
		return "未知角色名称";
	}


	//获取所有角色
	public function getRole($type="array"){
		$roleArr = array();
		$roleArr = $this->order('listorder asc')->select();
		if(empty($roleArr)) return $roleArr;
		// 生成不同类型数据
		switch ($type) {
			case 'array':
				$roleArr = $this->getArray($roleArr);
				break;
		}
		return $roleArr;
	}

	//递归重排角色数组
	//$data 带排列数组
	//$parentid 父id
	//$deep 数组深度
	public function getArray($data,$parentid='0',$deep = 0) {
		static $newArr = array();
		foreach ($data as $k=>$v){
			if($v['parentid']==$parentid){
				$v['deep'] = $deep;
	            $newArr[] = $v;
	            $this->getArray($data,$v['id'],$deep+1);
		    }
		}
		return $newArr;
	}


	//根据数组元素深度获取前缀
	public function getPrefix($data){
		if(empty($data)) return null;
		foreach ($data as $k=>$v) {
			$prefix = "┝";
			for ($i = 0; $i<$v['deep'];$i++)
				$prefix = "&emsp;" . $prefix;
			$data[$k]['prefix'] = $prefix;
		}
		return $data;
	}

}