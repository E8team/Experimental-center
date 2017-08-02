<?php
namespace Admin\Model;
use Think\Model;

/**
 * 管理员分组模型
 * 
 * 2014/7/14
 * @author webdd
 *
 */

class AdminGroupModel extends Model{
	
	/**
	 * 管理员分组添加自动验证
	 */
	public $addValidate = array (
			array (
					'name',
					'require',
					'分组名称不能为空',
					1
			)
	);
	
	/**
	 * 管理员分组添加自动验证
	 */
	public $editValidate = array (
			array (
					'name',
					'require',
					'分组名称不能为空',
					1
			)
	);
	
}