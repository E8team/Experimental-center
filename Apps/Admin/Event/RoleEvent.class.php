<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 角色管理表单响应
//+---------------------------------
//| Author: webdd <2014/8/30>
//+---------------------------------

namespace Admin\Event;
use Think\Controller;

class RoleEvent extends BaseEvent{

	//添加角色
	public function addEvent($uid){
		$Role = M ('Role');
		if ($Role->create()) {
			if (empty($_POST['name'])){
				$data['status'] = 0;
				$data['msg'] = "角色名不能为空 :(";
				$this->ajaxReturn($data,'JSON');
			}

			$Role->create_time = time();
			if ($Role->add()){
				$data['status'] = 1;
				$data['msg'] = "添加角色成功 :)";
			} else {
				$data['status'] = 0;
				$data['msg'] = "添加角色失败 :(";
			}
			//写入日志
			$Operationlog = D ('Operationlog');
			$info = "提示语：".$data['msg']." <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：AJAX";
			$get = __SELF__;
			$Operationlog->write($uid,$data['status'],$info,$get);

			$this->ajaxReturn($data,'JSON');
		} else {
			$data['status'] = 0;
			$data['msg'] = "创建数据失败 :(";
			$this->ajaxReturn($data,'JSON');
		}
	}
	
	//修改角色
	public function editEvent($uid){
		$Role = M ('Role');
		if ($Role->create()) {
			$id = $_POST['id'];
			$mw = $_POST['mw'];
			if (!compare($id,$mw)){
				$data['status'] = 0;
				$data['msg'] = "错误或恶意的操作,您的IP已被记录 :(";
			}
			$Role->update_time = time();
			if ($Role->save() !== false) {
				$data['status'] = 1;
				$data['msg'] = "修改成功 :)";
				//$data['msg'] = $Role->getLastSql();
			} else {
				$data['status'] = 0;
				$data['msg'] = "修改失败 :(";
			}
			//写入日志
			$Operationlog = D ('Operationlog');
			$info = "提示语：".$data['msg']." <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：AJAX";
			$get = __SELF__;
			$Operationlog->write($uid,$data['status'],$info,$get);

			$this->ajaxReturn($data,'JSON');
		} else {
			$data['status'] = 0;
			$data['msg'] = "创建数据失败 :(";
			$this->ajaxReturn($data,'JSON');
		}
	}

	//删除角色
	public function delEvent($uid){
		$id = $_GET['id'];
		$mw = $_GET['mw'];
		if (empty($id) || empty($mw)) $this->error("缺少必要参数!");
		if (!compare($id,$mw)) $this->error("错误或恶意的操作,您的IP已被记录!");
		$Role = M ('Role');
		$role = $Role->find($id);
		if (empty($role)) $this->error("该角色不存在!");
		//判断该角色下是否有用户
		$User = M('User');
		$where['role_id'] = $id;
		$res = $User->where($where)->select();
		if (!empty($res)) $this->error("该角色下有用户,请先删除相关用户或将用户转移到其他角色组!",__APP__.'/Role/index',3);
		unset($where);
		unset($res);
		//判断是否有子角色
		$where['parentid'] = $id;
		$res = $Role->where($where)->select();
		if (!empty($res)) $this->error("该角色下有子角色,请先删除子角色!",__APP__.'/Role/index',3);

		if ($Role->delete($id) !== false) {
			//写入日志
			$Operationlog = D ('Operationlog');
			$info = "提示语：删除角色成功 <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：GET";
			$get = __SELF__;
			//p($info);
			$Operationlog->write($uid,1,$info,$get);

			$this->success("删除角色成功!");
		}else{
			$this->error("删除角色失败!");
		}
	}


	//授权操作
	public function accreditEvent($uid) {
		
		$id = $_GET['id'];
		$mw = $_GET['mw'];
		if (empty($id) || empty($mw) || !compare($id,$mw)) {
			$data['status'] = 0;
			$data['msg'] = "错误或恶意的操作,您的IP已被记录!";
			$this->ajaxReturn($data,'JSON');
		}

		$idArr = explode(',',$_GET['data']);
		if (empty($idArr)) {
			$data['status'] = 0;
			$data['msg'] = "当前没有选择任何条目!";
			$this->ajaxReturn($data,'JSON');
		}

		$Menu = M ('Menu');
		$Access = M ('Access');
		//授权成功记录数
		$successNum = 0;
		//删除该id相关的所有记录
		$Access->where('role_id='.$id)->delete();
		//插入操作
		foreach ($idArr as $v) {
			$menu  = $Menu->find($v);
			if (empty($menu)) continue;
			$data = array();
			$data['role_id'] = $id;
			$data['menu_id'] = $v;
			$data['app'] = $menu['app'];
			$data['controller'] = $menu['controller'];
			$data['action'] = $menu['action'];
			$data['status'] = 1;
			if ($Access->add($data)) $successNum++;
			else continue; 
		}
		unset($data);

		$data['status'] = 1;
		$data['msg'] = "授权成功 :)";
	
		//写入日志
		$Operationlog = D ('Operationlog');
		$info = "提示语：".$data['msg']." <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：AJAX";
		$get = __SELF__;
		$Operationlog->write($uid,$data['status'],$info,$get);

		$this->ajaxReturn($data,'JSON');
	}
}