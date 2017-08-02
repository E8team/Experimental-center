<?php
namespace Admin\Model;
use Think\Model;

/**
 * 友链分组模型层
 */
class FlinkModel extends Model {
	public $_validate = [
			[
					'webname',
					'require',
					'友链名称不能为空!',
					1
            ],
            //todo 这里的url验证暂时关掉
			/*[
					'url',
					'/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
					'友链链接格式错误!',
					1
            ],*/
	];
}