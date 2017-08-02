<?php
namespace Admin\Model;
use Think\Model;

/**
 * 友链分组模型层
 */
class FlinkTypeModel extends Model {
	public $_validate = array (
			array(
					'typename',
					'require',
					'友链分组名称不能为空!',
					1
			),
	);
}