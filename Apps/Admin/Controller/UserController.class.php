<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 后台管理员控制器
//+---------------------------------
//| Author: webdd <2014//8/27>
//+---------------------------------

namespace Admin\Controller;
use Think\Controller;

class UserController extends BaseController {


	//权限验证
    public function __construct() {
        parent::__construct ();
        $this->checkPerm();
    }

	public function index(){

		$User = M ('User');
		$Role = D ('Role');

		$where = "";
		if (!empty($_GET)) {
			$where['role_id'] = $_GET['role_id'];
			$this->assign('cancel',1);
		}
		// 分页处理,获取数据
		$count = $User->where ( $where )->count ();
		$Page = new \Think\Page ( $count, 15 );
		$show = $Page->show ();
		$userArr = $User->where ( $where )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();

		foreach ($userArr as $key=>$val){
			//获取角色名称
			$userArr[$key]['rolename'] = $Role->getRoleName($val['role_id']);
			//生成密文
			$userArr[$key]['mw'] = passport_encrypt($val['id']);
		}

		$this->assign('userArr',$userArr);
		$this->assign('page',$show);
		$this->display();
	}


	public function add(){
		// 如果是post方式
		if (IS_POST) {
			$UserEvent = A ('User','Event');
			$UserEvent->addEvent($this->user['id']);
		} else {
			//获取所有角色分组
			$Role = D ('Role');
			$roleArr = $Role->getRole();
			//生成前缀
			$roleArr = $Role->getPrefix($roleArr);
			$this->assign("roleArr",$roleArr);
			$this->display();
		}
	}

	public function edit(){
		if (IS_POST) {
			$UserEvent = A ('User','Event');
			$UserEvent->editEvent($this->user['id']);
		} else {
			$id = $_GET['id'];
			$mw = $_GET['mw'];
			if (empty($id) || empty($mw)) $this->error("缺少必要参数!");
			if (!compare($id,$mw)) $this->error("错误或恶意的操作,您的IP已被记录!");
			$User = M('User');
			$user = $User->find($id);
			if (empty($user)) $this->error("改用户不存在!");

			//获取所有角色分组
			$Role = D ('Role');
			$roleArr = $Role->getRole();
			//生成前缀
			$roleArr = $Role->getPrefix($roleArr);
			$this->assign("roleArr",$roleArr);

			$this->assign('user',$user);
			$this->assign('mw',$mw);
			$this->display();
		}
	}

	public function del(){
		$UserEvent = A ('User','Event');
		$UserEvent->delEvent($this->user['id']);
	}

	//ajax验证方法
	public function check(){
		$UserEvent = A ('User','Event');
		isset($_GET['type'])?$type=$_GET['type']:$type="empty";
		switch ($type) {
			case 'username':
				$UserEvent->checkUsername();
				break;
			case 'email':
				$UserEvent->checkEmail();
			default:
				$this->ajaxReturn("",'JSON');
				break;
		}
	}

}