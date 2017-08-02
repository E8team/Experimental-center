<?php

namespace Admin\Model;

use Think\Model;

/**
 * 管理员模型
 * 1、定义了用户登录自动验证规则
 *
 * 2014/7/9
 * 
 * @author webdd
 */
class AdminModel extends Model {
	
	/**
	 * 管理员登录自动验证规则
	 */
	public $loginValidate = array (
			array (
					'account',
					'require',
					'账号不能为空',
					1 
			),
			array (
					'password',
					'require',
					'密码不能为空',
					1 
			),
			array (
					'verify',
					'require',
					'验证码不能为空',
					1 
			) 
	);
	
	/**
	 * 管理员添加自动验证规则
	 */
	public $addValidate = array (
			array (
					'account',
					'require',
					'账号不能为空',
					1 
			),
			array (
					'account',
					'/^[a-zA-Z0-9_]{6,16}$/',
					'账号格式不正确',
					1 
			),
			array (
					'name',
					'require',
					'真实姓名不能为空',
					1 
			),
			array (
					'email',
					'email',
					'邮箱格式不正确',
					1 
			),
			array (
					'qq',
					'number',
					'QQ号码格式不正确',
					2 
			),
			array (
					'password',
					'require',
					'密码不能为空',
					1 
			),
			array (
					'password',
					'6,22',
					'密码长度为6~22位',
					1,
					'length' 
			),
			array (
					'repassword',
					'password',
					'确认密码不正确',
					0,
					'confirm' 
			),
			array (
					'admin_group_id',
					'require',
					'用户所属组不能为空',
					1 
			) 
	);
	
	/**
	 * 管理员修改自动验证规则
	 */
	public $editValidate = array (
			array (
					'name',
					'require',
					'真实姓名不能为空',
					1
			),
			array (
					'qq',
					'number',
					'QQ号码格式不正确',
					2
			),
			array (
					'password',
					'require',
					'密码不能为空',
					1
			),
			array (
					'password',
					'6,22',
					'密码长度为6~22位',
					1,
					'length'
			),
			array (
					'repassword',
					'password',
					'确认密码不正确',
					0,
					'confirm'
			),
			array (
					'admin_group_id',
					'require',
					'用户所属组不能为空',
					1
			)
	);
	
	/**
	 * 修改用户信息验证
	 * @var unknown
	 */
	public $alterValidate = array (
			
			array (
					'email',
					'require',
					'邮箱不能为空！',
					1,
					'regex'
			),
	
			array (
					'email',
					'email',
					'邮箱格式错误！',
					2
			),
			array (
					'qq',
					'number',
					'QQ号码格式不正确',
					2
			),
			array (
					'qq',
					'require',
					'QQ号码不能为空！',
					1,
					'regex'
			),
			array (
					'password',
					'6,20',
					'密码长度为6到20！',
					2,
					'length'
			),
			array (
					'repassword',
					'password',
					'确认密码不正确',
					0,
					'confirm'
			),
	);
	
}