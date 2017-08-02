<?php
namespace Admin\Model;
use Think\Model;

/**
 * 栏目自动验证
 * 2014/7/11
 * @author baochao
 */

class ClassModel extends Model {
	protected $_validate = array (
			array (
					'name',
					'require',
					'栏目标题不能为空！',
					1
			),
			array (
					'channel_id',
					'require',
					'内容模型不能为空！',
					1
			),
			array (
					'sort_index',
					'number',
					'排序值必须为数字！',
					1
			),
			array (
					'type',
					'require',
					'栏目类型不能为空！',
					1
			),
			array (
					'url',
					'url',
					'外部链接地址格式错误！',
					2
			),
			array (
					'index_template',
					'require',
					'栏目封面模板不能为空！',
					1
			),
			array (
					'content_template',
					'require',
					'栏目内容模板不能为空！',
					1
			)
	);
	/**
	 * 获取栏目名称，用于管理员列表
	 *
	 * @param unknown $class_id
	 * @return string
	 */
	public function getClassName($class_id) {
		if (is_array ( $class_id )) {
			$class_id = implode ( ",", $class_id );
		}
		$classList = $this->where ( "class_id in ($class_id)" )->field ( "name" )->select ();
		for($i = 0; $i < count ( $classList ); $i ++) {
			$classList [$i] = $classList [$i] ['name'];
		}
		return implode ( "、", $classList );
	}
	
	/**
	 * 递归获取父级菜单下的所有栏目
	 *
	 * @param number $father_id
	 * @param number $deep
	 * @return void multitype:
	 */
	public function getAllClass($father_id = 0, $deep = 0, $where = '') {
		static $classList = array ();
		$now_where = $where == '' ? "father_id = $father_id" : "father_id = $father_id and " . $where;
		$result = $this->where ( $now_where )->order ( 'sort_index' )->select ();
		if ($result == false)
			return;
		else {
			for($i = 0; $i < count ( $result ); $i ++) {
				$result [$i] ['deep'] = $deep;
				array_push ( $classList, $result [$i] );
				$this->getAllClass ( $result [$i] ['class_id'], $deep + 1, $where );
			}
		}
		return $classList;
	}
	/**
	 * 从下往上获取所有的ID
	 *
	 * @param unknown $sub_id
	 * @param string $where
	 * @return multitype:
	 */
	public function getAllFatherId($sub_id, $where = '') {
		static $class_id = array ();
		if (is_array ( $sub_id )) {
			for($i = 0; $i < count ( $sub_id ); $i ++) {
				$classList = $this->getClassTree ( $sub_id [$i] );
				for($j = 0; $j < count ( $classList ); $j ++) {
					if (! in_array ( $classList [$j] ['class_id'], $class_id )) {
						array_push ( $class_id, $classList [$j] ['class_id'] );
					}
				}
			}
		} else {
			$classList = $this->getClassTree ( $sub_id, $where );
			for($j = 0; $j < count ( $classList ); $j ++) {
				array_push ( $class_id, $classList [$j] ['class_id'] );
			}
		}
		return $class_id;
	}
	
	/**
	 * 递归从上往下获取所有ID
	 *
	 * @param number $father_id
	 * @return void multitype:
	 */
	public function getAllSubId($father_id = 0, $where = '') {
		static $class_id = array ();
		$now_where = $where == '' ? "father_id = $father_id" : "father_id = $father_id and " . $where;
		$result = $this->where ( $now_where )->select ();
		if ($result == false)
			return $class_id;
		else {
			for($i = 0; $i < count ( $result ); $i ++) {
				array_push ( $class_id, $result [$i] ['class_id'] );
				$this->getAllSubId ( $result [$i] ['class_id'], $where );
			}
		}
		return $class_id;
	}
	
	/**
	 * 获取从下往上获取栏目树
	 *
	 * @param unknown $class_id
	 */
	public function getClassTree($class_id, $where = "") {
		static $classList = array ();
		if ($class_id == 0)
			return;
		$nowwhere = $where == "" ? "class_id = $class_id" : "class_id = $class_id and " . $where;
		$class = $this->where ( $nowwhere )->find ();
		if ($class != false) {
			array_push ( $classList, $class );
			$this->getClassTree ( $class ['father_id'] );
		}
		return $classList;
	}
	
	/**
	 * 递归删除栏目
	 *
	 * @param unknown $class_id
	 */
	public function deleteClass($class_id) {
		$this->where ( "class_id=$class_id" )->delete ();
		$classList = $this->where ( "father_id=$class_id" )->select ();
		if ($classList == false)
			return;
		for($i = 0; $i < count ( $classList ); $i ++) {
			$this->deleteClass ( $classList [$i] ['class_id'] );
		}
	}
	/**
	 * 判断栏目1是否为栏目2的子栏目
	 *
	 * @param unknown $class1_id
	 * @param unknown $class2_id
	 */
	public function isSubClass($class1_id, $class2_id) {
		// 如果栏目1是顶级栏目，则返回false
		if ($class1_id == 0)
			return false;
	
		$class = $this->where ( "class_id = $class1_id" )->find ();
		// 如果栏目1未找到，则返回false
		if ($class == false)
			return false;
			
		// 如果是栏目2数组
		if (is_array ( $class2_id )) {
			// 如果栏目2中包含顶级栏目，返回true
			if (in_array ( 0, $class2_id ))
				return true;
			// 如果栏目1的父级栏目在栏目2中，返回true
			if (in_array ( $class ['father_id'], $class2_id ))
				return true;
		} else {
			// 如果栏目2是顶级栏目，返回true
			if ($class2_id == 0)
				return true;
			// 如果栏目1的父级栏目就是栏目2，返回true
			if ($class ['father_id'] == $class2_id)
				return true;
		}
		// 继续查看栏目1的父级栏目是否为栏目2的字栏目
		return $this->isSubClass ( $class ['father_id'], $class2_id );
	}
	
	/**
	 * 判断用户对于栏目有没有权限
	 *
	 * @param unknown $class_id
	 * @return boolean
	 */
	public function chk_class_purview($class_id) {
		$admin = session ( 'admin' );
		$class_ids = $admin ['class_id'];
		// 判断是否拥有所有栏目权限
		if ($class_ids == 0)
			return true;
		$class_id_list = explode ( ",", $class_ids );
		// 判断栏目是否在用户的权限栏目里
		if (in_array ( $class_id, $class_id_list ))
			return true;
		// 判断栏目是否在用户的权限栏目的子目录下
		if ($this->isSubClass ( $class_id, $class_id_list ))
			return true;
		return false;
	}
	
}