<?php
namespace Admin\Model;
use Think\Model;

/**
 * 权限模型
 * 
 * 2014/7/13
 * @author webdd
 *
 */
class PermissionModel extends Model {
	
	/**
	 * 权限添加自动验证规则
	 */
	public $addValidate = array (
			array (
					'name',
					'require',
					'权限名称不能为空',
					1
			),
			array (
					'action',
					'require',
					'action不能为空',
					1
			)
	);
	
	/**
	 * 权限修改自动验证规则
	 */
	public $editValidate = array (
			array (
					'name',
					'require',
					'权限名称不能为空',
					1
			),
			array (
					'action',
					'require',
					'action不能为空',
					1
			)
	);
	
}