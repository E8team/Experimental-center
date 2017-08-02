<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 栏目数据层 <数据层>
//+---------------------------------
//| Author: webbc <2014/9/6>
//+---------------------------------

namespace Admin\Model;
use Think\Model;

class PictureModel extends Model {
	
	protected  $_validate = array (
			array (
					'name',
					'require',
					'图片名称不能为空！',
					1
			),
			array (
					'termid',
					'require',
					'所属分类不能为空！',
					1
			),
	);
}
?>