<?php
namespace Admin\Logic;
use Think\Model;

/**
 * 后台导航业务处理
 * 2014/7/13
 * 
 * @author webdd
 *        
 */
class MenuLogic extends Model {
	
	/**
	 * 获取后台导航列表
	 *
	 * @param null
	 * @return Array(Array(Menu)) menuArr
	 */
	public function getMenu() {
		$menuArr = array();
		$condition ['father_id'] = 0;
		$condition['is_open'] = 1;
		$fatherMenu = $this->where($condition)->order('sort_index asc')->select ();
		//遍历获取父级栏目下的子栏目
		foreach ( $fatherMenu as $k => $v) {
			$childMenu = $this->getChildMenu($v['menu_id']);
			$menuArr[$k]['menu_id'] = $v['menu_id'];
			$menuArr[$k]['father_id'] = $v['father_id'];
			$menuArr[$k]['name'] = $v['name'];
			$menuArr[$k]['url'] = $v['url'];
			$menuArr[$k]['target'] = $v['target'];
			$menuArr[$k]['icon'] = $v['icon'];
			$menuArr[$k]['child'] = $childMenu;
		}
		
		return $menuArr;
	}
	
	/**
	 * 获取指定父级栏目下的子栏目
	 *
	 * @param Integer $father_id        	
	 * @param Array(Menu) $childMenu        	
	 */
	private function getChildMenu($father_id) {
		$childMenu = array ();
		$condition ['father_id'] = $father_id;
		$condition ['is_open'] = 1;
		$childMenu = $this->where ( $condition ) -> order('sort_index asc')->select ();
		if (empty ( $childMenu )) {
			return "null";
		}
		return $childMenu;
	}
}