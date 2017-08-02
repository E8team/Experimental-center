<?php
namespace Admin\Model;
use Think\Model;

/**
 * 网站设置模型层
 * 
 */
class SettingModel extends Model{
	public $_validate = array (
			array(
					'item',
					'require',
					'设置项不能为空!',
					1
			),
			array(
					'value',
					'require',
					'设置值不能为空!',
					1
			),
			array(
					'description',
					'require',
					'描述不能为空!',
					1
			),
	);
} 