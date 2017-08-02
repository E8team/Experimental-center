<?php

namespace Admin\Controller;
use Think\Controller;

class PersonController extends BaseController {

	//权限验证
    public function __construct() {
        parent::__construct ();
        $this->checkPerm();
    }

	//修改用户信息
	public function info(){
		if (IS_POST){
			$PersonEvent = A ('Person','Event');
			$PersonEvent->infoEvent($this->user['sessionName']);
		} else {
			$this->assign('person',$this->user);
			$this->display();
		}
	}

	//修改用户密码
	public function pwd(){
		if (IS_POST){
			$PersonEvent = A ('Person','Event');
			$PersonEvent->pwdEvent($this->user['sessionName']);
		} else {
			$this->assign('person',$this->user);
			$this->display();
		}
	}

	//ajax验证旧密码是否正确
	public function checkpwd(){
		$PersonEvent = A ('Person','Event');
		$PersonEvent->checkpwdEvent();
	}

}