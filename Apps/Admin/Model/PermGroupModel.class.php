<?php
namespace Admin\Model;
use Think\Model;

/**
 * 权限组模型
 * 
 * 2014/7/13
 * @author webdd
 *
 */
class PermGroupModel extends Model {

	/**
	 * 权限组添加自动验证规则
	 */
	public $addValidate = array (
			array (
					'name',
					'require',
					'权限分组名称不能为空',
					1
			)
	);
	
}