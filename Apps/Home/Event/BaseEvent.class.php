<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 事件控制器基类,提供部分公用参数
//+---------------------------------
//| Author: webdd <2014/8/29>
//+---------------------------------

namespace Home\Event;
use Think\Controller;

class BaseEvent extends Controller {

	protected $uploadPath ;
	protected $admin;
	
	public function __construct(){
		parent::__construct();
		//上传文件目录
		$this->uploadPath = $_SERVER['DOCUMENT_ROOT'] . C('UPLOAD_PATH');
	}

}