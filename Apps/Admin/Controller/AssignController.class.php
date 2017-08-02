<?php
namespace Admin\Controller;
use Think\Controller;

class AssignController extends BaseController{
	
	public function index(){
		$this->assign('menu',$this->menu);
    	$this->assign('admin',$this->admin);
    	$this->assign('webConfig',$this->webConfig);
	}
}