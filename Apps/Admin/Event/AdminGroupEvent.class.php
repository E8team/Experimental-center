<?php

namespace Admin\Event;

use Think\Controller;

class AdminGroupEvent extends BaseEvent {
	
	/**
	 * 响应添加管理员分组请求
	 */
	public function add() {
		$AdminGroup = D ( 'AdminGroup' );
		// 自动验证表单数据合法性
		if (! $AdminGroup->validate ( $AdminGroup->addValidate )->create ()) {
			$this->error ( $AdminGroup->getError () );
		} else {
			// 获取权限分组ID
			$permGroupIds = $_POST ['perm_group_id'];
			// 拼接权限组id
			$permGroupStr = "";
			foreach ( $permGroupIds as $v ) {
				$permGroupStr .= $v . ',';
			}
			$permGroupStr = substr ( $permGroupStr, 0, strlen ( $permGroupStr ) - 1 );
			$AdminGroup->perm_group_id = $permGroupStr;
			
			$logMsg = $AdminGroup->name;

			if ($AdminGroup->add ()) {
				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了添加管理员分组操作,添加的管理员分组名称为 '. $logMsg;
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success ( "添加成功！", __APP__ . '/Admin/AdminGroup/index', 1 );
			} else {
				$this->error ( "添加失败！" );
			}
		}
	}
	
	/**
	 * 显示修改管理员分组页面
	 */
	public function showEditView() {
		$admin_group_id = $_GET ['admin_group_id'];
		$mw = $_GET ['mw'];
		// 参数不能为空
		if (empty ( $admin_group_id ) || empty ( $mw )) {
			$this->error ( "非法操作,错误代号14" );
		}
		// 判断密文和id是否匹配
		if (passport_decrypt ( $mw ) !== $admin_group_id) {
			$this->error ( "非法操作,错误代号1001-管理员分组修改页显示" );
		}
		
		$AdminGroup = D ( 'AdminGroup' );
		// 查询管理员
		$adminGroup = $AdminGroup->find ( $admin_group_id );
		if (empty ( $adminGroup )) {
			$this->error ( "管理员不存在!" );
		}
		$PermGroupLogic = D ( 'PermGroup', 'Logic' );
		$permGroupList = $PermGroupLogic->getPermGroupList ();
		$permGroupIds = explode ( ',', $adminGroup ['perm_group_id'] );
		
		// 调用Assign控制器，传递页面所需要的基本参数
		$Assign = A ( 'Assign' );
		$Assign->index ();
		
		$this->assign ( 'mw', $mw );
		$this->assign ( 'permGroupList', $permGroupList );
		$this->assign ( 'permGroupIds', $permGroupIds );
		$this->assign ( 'adminGroup', $adminGroup );
		$this->display ();
	}
	
	/**
	 * 管理员修改表单提交方法
	 */
	public function edit() {
		$AdminGroup = D ( 'AdminGroup' );
		// p($_POST);
		// 自动验证表单数据合法性
		if (! $AdminGroup->validate ( $AdminGroup->editValidate )->create ()) {
			$this->error ( $AdminGroup->getError () );
		} else {
			
			$admin_group_id = $_POST ['admin_group_id'];
			$mw = $_POST ['mw'];
			
			if (empty ( $admin_group_id ) || empty ( $mw )) {
				$this->error ( "非法操作,错误代号14" );
			}
			if (passport_decrypt ( $mw ) !== $admin_group_id) {
				// 密码和密文是否匹配
				$this->error ( "非法操作,错误代号1001-管理员组修改表单提交" );
			}
			
			$group = $AdminGroup->find ( $admin_group_id );
			if ($group ['root'] == 1) {
				$this->error ( "非法操作，不能修改ROOT用户，错误代号1002" );
			}
			
			// 获取权限分组ID
			$permGroupIds = $_POST ['perm_group_id'];
			// 拼接权限组id
			$permGroupStr = "";
			foreach ( $permGroupIds as $v ) {
				$permGroupStr .= $v . ',';
			}
			$permGroupStr = substr ( $permGroupStr, 0, strlen ( $permGroupStr ) - 1 );
			// 跟新权限信息
			$AdminGroup->perm_group_id = $permGroupStr;
			$AdminGroup->name = $_POST ["name"];
			$AdminGroup->description = $_POST ['description'];
			
			if ($AdminGroup->save () !== false) {
				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了修改管理员分组操作,修改的管理员分组名称为 '. $group['admin_group_id'];
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success ( '修改成功!', __APP__ . '/Admin/AdminGroup/index', 1 );
			} else {
				$this->error ( '修改失败!' );
			}
		}
	}
	
	/**
	 * 响应页面Ajax请求，改变分组可用状态
	 *
	 * @param integer $admin_group_id        	
	 * @param integer $useful        	
	 * @return json
	 */
	public function changeUseful() {
		$admin_group_id = $_GET ['id'];
		$AdminGroupLogic = D ( 'AdminGroup', 'Logic' );
		$val = $AdminGroupLogic->changeUseful ( $admin_group_id );
		if ($val !== false) {

			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了修改管理员分组可用状态操作,修改的管理员分组ID为 '. $admin_group_id;
			$Log->write($this->admin['admin_id'],$content,1);

			$data ['status'] = 1;
			$data ['val'] = $val;
			$data ['msg'] = "修改分组成功";
			$this->ajaxReturn ( $data, 'JSON' );
		} else {
			$data ['status'] = 0;
			$data ['msg'] = "失败";
			$this->ajaxReturn ( $data, 'JSON' );
		}
	}
}