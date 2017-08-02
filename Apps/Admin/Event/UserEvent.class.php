<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 用户管理表单响应
//+---------------------------------
//| Author: webdd <2014/8/29>
//+---------------------------------

namespace Admin\Event;
use Think\Controller;

class UserEvent extends BaseEvent {

	public function addEvent($uid){
		$User = M ('User');
		if (IS_POST){
			if (!$User->create()) {
				$data['status'] = 0;
				$data['msg'] = "操作失败!";
				$this->ajaxReturn($data,'JSON');
			} else {
				if (empty($_POST['username']) || empty($_POST['email'])) {
					$data['status'] = 0;
					$data['msg'] = "用户名或邮箱不能为空";
					$this->ajaxReturn($data,'JSON');
				}
				//判断用户名和邮箱是否存在
				$where['username'] = $_POST['username'];
				$where['email'] = $_POST['email'];
				$where['_logic'] = 'or';
				$result = $User->where($where)->find();
				if (!empty($result)){
					$data['status'] = 0;
					$data['msg'] = "用户名或邮箱已存在";
					$this->ajaxReturn($data,'JSON');
				}
				if (empty($_POST['password'])) {
					$data['status'] = 0;
					$data['msg'] = "密码不能为空";
					$this->ajaxReturn($data,'JSON');
				}
				if ($_POST['password'] !== $_POST['truepassword']){
					$data['status'] = 0;
					$data['msg'] = "两次密码不一致";
					$this->ajaxReturn($data,'JSON');
				}

				$User->password = md5($_POST['password']);
				$User->create_time = time();
				$User->update_time = time();
				$User->photo = 'photo/default.jpg';

				if ($User->add()) {
					$data['status'] = 1;
					$data['msg'] = "添加管理用户成功!";
				} else {
					$data['status'] = 0;
					$data['msg'] = "添加管理用户失败!";
				}
				//写入日志
				$Operationlog = D ('Operationlog');
				$info = "提示语：".$data['msg']." <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：AJAX";
				$get = __SELF__;
				$Operationlog->write($uid,$data['status'],$info,$get);

				$this->ajaxReturn($data,'JSON');
			}
		} else {
			$data['status'] = 0;
			$data['msg'] = "错误的提交方式!";
			$this->ajaxReturn($data,'JSON');
		}
	}

	public function editEvent($uid){

		$User = M('User');
		$id = $_POST['id'];
		$mw = $_POST['mw'];
		$user = $User->find($id);

		if (empty($id) || empty($mw) || !compare($id,$mw) || empty($user)) {
			$data['status'] = 0;
			$data['msg'] = "错误或恶意的操作,您的IP已被记录!";
			$this->ajaxReturn($data, 'JSON');
		}

		if (empty($_POST['password'])) {
			$data['status'] = 0;
			$data['msg'] = "密码不能为空";
			$this->ajaxReturn($data,'JSON');
		}

		if ($_POST['password'] !== $_POST['truepassword']){
			$data['status'] = 0;
			$data['msg'] = "两次密码不一致";
			$this->ajaxReturn($data,'JSON');
		}

		if ($_POST['password']=="default") {
			$u['password'] = $user['password'];
		} else {
			$u['password'] = md5($_POST['password']);
		}

		$u['nickname'] = $_POST['nickname'];
		$truepassword = $_POST['truepassword'];
		$u['role_id'] = $_POST['role_id'];
		$u['status'] = $_POST['status'];
		$u['remark'] = $_POST['remark'];
		$u['update_time'] = time();

		if ($password == "default") {
			$u['password'] = $user['password'];
		}

		$flag = $User->where('id='.$id)->save($u);
		if ( $flag !== false ) {
			$data['status'] = 1;
			$data['msg'] = "修改管理用户成功!";
		} else {
			$data['status'] = 0;
			$data['msg'] = "修改管理用户失败!";
		}
		//写入日志
		$Operationlog = D ('Operationlog');
		$info = "提示语：".$data['msg']." <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：AJAX";
		$get = __SELF__;
		$Operationlog->write($uid,$data['status'],$info,$get);

		$this->ajaxReturn($data,'JSON');
	}


	public function delEvent($uid){
		$id = $_GET['id'];
		$mw = $_GET['mw'];
		if (empty($id) || empty($mw)) $this->error("缺少必要参数!");
		if (!compare($id,$mw)) $this->error("错误或恶意的操作,您的IP已被记录!");
		$User = M('User');
		$res = $User->find($id);
		if (empty($res)) $this->error("该用户不存在!");
		//删除头像图片
		if ($res['photo'] !== 'photo/default.jpg') unlink ( $this->uploadPath . $res ['photo'] );
		if ($User->delete($id) !== false){
			//写入日志
			$Operationlog = D ('Operationlog');
			$info = "提示语：删除管理用户成功 <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：GET";
			$get = __SELF__;
			$Operationlog->write($uid,$data['status'],$info,$get);

			$this->success("删除管理用户成功!");
		} else{ 
			$this->error("删除管理用户失败!");
		}
	}



	//验证用户名
	public function checkUsername(){
		$val = $_GET['val'];
		$Verify = new \Libs\Util\Verify();
		//如果$val不存在，直接ajax返回
		if (empty($val) || $val == 'index.php' || !$Verify->checkName($val)) {
			$data['status'] = 0;
			$data['msg'] = "用户名为空或格式错误";
		} else {
			$User = M('User');
			$user = $User->where("username='$val'")->find();
			if (!empty($user)) {
				$data['status'] = 1;
				$data['msg'] = "用户名已存在";
			} else {
				$data['status'] = 2;
				$data['msg'] = "用户名可用";
			}
		}
		$this->ajaxReturn($data,'JSON');
	}

	//验证邮箱
	public function checkEmail(){
		$val = $_GET['val'];
		$Verify = new \Libs\Util\Verify();
		//p($Verify->checkEmail($val));
		//如果$val不存在，直接ajax返回
		if (empty($val) || $val == 'index.php' || !$Verify->checkEmail($val)) {
			$data['status'] = 0;
			$data['msg'] = "邮箱为空或格式错误";
		} else {
			$User = M('User');
			$user = $User->where("email='$val'")->find();
			if (!empty($user)) {
				$data['status'] = 1;
				$data['msg'] = "邮箱已存在";
			} else {
				$data['status'] = 2;
				$data['msg'] = "邮箱可用";
			}
		}
		$this->ajaxReturn($data,'JSON');
	}

}