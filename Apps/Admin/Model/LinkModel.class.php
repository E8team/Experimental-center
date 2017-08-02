<?php
namespace Admin\Model;
use Think\Model;

/**
 * 
 * @author Administrator
 *
 */
class LinkModel extends Model {
	/**
	 *添加友情链接 
	 */
	public  $linkValidate = array(
		array(
			'name',
			'require',
			'连接名称不能为空!',
			1
		),
		array(
			'url',
			'require',
			'链接地址不能为空!',
			1
		),
		array(
			'url',
			'url',
			'链接地址格式不正确!',
			2
		),
		array(
			'termsid',
			'require',
			'所属分类不能为空!',
			1
		),
		array(
				'description',
				'require',
				'链接描述不能为空!',
				1
		)
			

	);  
}