<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 个人信息修改表单响应
//+---------------------------------
//| Author: webdd <2014/8/29>
//+---------------------------------

namespace Admin\Event;
use Think\Controller;

class PersonEvent extends BaseEvent {

	public function infoEvent($sessionName){

		$id = $_POST['id'];
		$mw = $_POST['mw'];
		if (empty($id) || empty($mw)) $this->error("缺少必要参数!");
		if (!compare($id,$mw)) $this->error("错误或恶意的操作,您的IP已被记录!");

		empty($_POST['nickname'])?$data['nickname'] = "未知":$data['nickname']  = $_POST['nickname'];
		$data['email'] = $_POST['email'];
		$data['remark'] = $_POST['remark'];

		$Verify = new \Libs\Util\Verify();
		if (!$Verify->checkEmail($data['email'])) $this->error("邮箱为空或格式不正确!");

		$User = M ('User');
		$user = $User->find($id);
		if (empty($user)) $this->error("用户不存在!");

		//上传用户头像
		$Upload = new \Libs\Util\Upload();
		$data['photo'] = $user['photo'];
		//p($_FILES);
		if ($_FILES['photo']['name'] != "") {
			$fileInfo = $Upload->upload ( 'photo', true );
			//删除旧头像
			unlink($this->uploadPath . $user['photo']);
			$data['photo'] = $fileInfo;
		}

		if ($User->where("id=".$id)->save($data) !== false){
			//更新session
			$session = session($sessionName);
			$session['nickname'] = $data['nickname'];
			$session['photo'] = $data['photo'];
			$session['email'] = $data['email'];
			$session['remark'] = $data['remark'];
			session($sessionName,$session);

			//写入日志
			$Operationlog = D ('Operationlog');
			$info = "提示语：修改个人信息成功! <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：POST";
			$get = __SELF__;
			$Operationlog->write($session['id'],1,$info,$get);

			$this->success("修改个人信息成功!",__APP__.'/Center');
		} else {
			$this->error("修改个人信息失败!");
		}
	}


	//用户个人密码修改
	public function pwdEvent($sessionName){
		$id = $_POST['id'];
		$mw = $_POST['mw'];
		if (empty($id) || empty($mw)) $this->error("缺少必要参数!");
		if (!compare($id,$mw)) $this->error("错误或恶意的操作,您的IP已被记录!");

		//验证旧密码
		$oldpwd = $_POST['oldpwd'];
		if (empty($oldpwd)) $this->error("旧密码不正确!");
		$User = M ('User');
		$where['id'] = $id;
		$where['password'] = md5($oldpwd);
		$user = $User->where($where)->find();
		if (empty($user)) $this->error("旧密码不正确!");

		$password = md5(trim($_POST['password']));
		$truepassword = md5(trim($_POST['truepassword']));
		if (empty($password) || $password!==$truepassword) $this->error("新密码为空或者两次输入不一致!");

		if ($User-> where('id='.$id)->setField('password',$password) !== false) {

			$session = session($sessionName);
			//写入日志
			$Operationlog = D ('Operationlog');
			$info = "提示语：修改个人密码成功! <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：POST";
			$get = __SELF__;
			$Operationlog->write($session['id'],1,$info,$get);

			session($sessionName,null);
			$url = __APP__ .'/Login';
			echo "<script>alert('修改成功,请重新登陆!');window.history.forward(1); top.location.href='" . $url . "';</script>";
		} else {
			$this->error("修改个人密码失败!");
		}
	}


	//验证旧密码是否正确
	public function checkpwdEvent(){
		$id = $_GET['id'];
		$oldpwd = $_GET['val'];
		if (empty($id) || empty($oldpwd)) {
			$data['status'] = 0;
			$data['msg'] = "旧密码不正确!";
			$this->ajaxReturn($data,'JSON');
		}

		$oldpwd = md5($oldpwd);
		$User = M('User');
		$where['id'] = $id;
		$where['password'] = $oldpwd;
		$user = $User->where($where)->select();
		if (!empty($user)) {
			$data['status'] = 1;
			$data['msg'] = "输入正确!";
		} else {
			$data['status'] = 0;
			$data['msg'] = "旧密码不正确!";
		}
		$this->ajaxReturn($data,'JSON');
	}

}