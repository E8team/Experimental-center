<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 用户管理表单响应
//+---------------------------------
//| Author: webdd <2014/8/29>
//+---------------------------------

namespace Home\Event;
use Think\Controller;

class PlusEvent extends BaseEvent {

	/*public function addEvent(){
		
		$Plus = D ('Plus');
		$time = date('Y-m-d H:m:s');
		$openid = $_POST['openid'];

		//参照完整性规则
		if (!empty($openid)){
			$rs = $Plus->where("openid = '$openid' ")->find();
			
			if (!empty($rs)){
				echo"1";
				$data['status'] = 0;
				$data['msg'] = "该用户已提交加V申请!";
				$this->ajaxReturn($data,'JSON');
			}else{
				$name = $_POST ['name'];
				$tel = $_POST ['tel'];
				$result = $_POST['result'];
				$Plus->name = $name;
				$Plus->openid = $openid;
				$Plus->tel = $tel;
				$Plus->result = $result;
				$Plus->time = $time ;
				$Plus->add ();
				$data['status'] = 1;
				$data['msg'] = "正在审核中,我们会第一时间通知开发者!!";
				$this->ajaxReturn($data,'JSON');
			}
		}else{
			$data['status'] = 0;
			$data['msg'] = "该用户不存在!";
			$this->ajaxReturn($data,'JSON');
		}
	}*/


	//验证用户名
	public function checkName(){
		$val = $_GET['val'];
		$Verify = new \Libs\Util\Verify();
		//如果$val不存在，直接ajax返回
		if (empty($val) || $val == 'index.php' || !$Verify->isNames($val)) {
			$data['status'] = 0;
			$data['msg'] = "用户名为空或格式错误";
		} else {

			$data['status'] = 1;
			$data['msg'] = "用户名可用";
			
		}
		$this->ajaxReturn($data,'JSON');
	}

	//验证联系方式
	public function checkTel(){
		$val = $_GET['val'];
		$Verify = new \Libs\Util\Verify();
		//p($Verify->checkEmail($val));
		//如果$val不存在，直接ajax返回
		if (empty($val) || $val == 'index.php' || !$Verify->isMobile($val)) {
			$data['status'] = 0;
			$data['msg'] = "联系方式或格式错误";
		} else {
	
			$data['status'] = 1;
			$data['msg'] = "联系方式可用";
			
		}
		$this->ajaxReturn($data,'JSON');
	}

}