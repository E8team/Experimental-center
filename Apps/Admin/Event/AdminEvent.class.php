<?php

namespace Admin\Event;

use Think\Controller;

/**
 * 响应管理员相关操作动作
 *
 * @author webdd
 *        
 */
class AdminEvent extends BaseEvent {

	/**
	 * 添加管理员
	 */
	public function add() {
		$Admin = D ( 'Admin' );
		$AdminLogic = D ( 'Admin', 'Logic' );
		// p($_POST);
		// 自动验证表单数据合法性
		if (! $Admin->validate ( $Admin->addValidate )->create ()) {
			$this->error ( $Admin->getError () );
		} else {
			// 验证账号或邮箱是否存在
			if ($AdminLogic->checkAccount ( $_POST ['account'] ) || $AdminLogic->checkEmail ( $_POST ['email'] )) {
				$this->error ( "账号或邮箱已存在!" );
			}
			$password = md5 ( $_POST ['password'] );
			$permGroupId = $_POST ['perm_group_id'];
			// 拼接权限组id
			$permGroupStr = "";
			foreach ( $permGroupId as $v ) {
				$permGroupStr .= $v . ',';
			}
			$permGroupStr = substr ( $permGroupStr, 0, strlen ( $permGroupStr ) - 1 );
			$Admin->password = $password;
			$Admin->perm_group_id = $permGroupStr;
			//强制为非ROOT用户，防止表单恶意赋值
			$Admin->root = 0;
			
			// 上传头像到服务器
			if ($_FILES ['photo'] ['name'] != "") {
				$fileInfo = $this->upload ( 'photo', true );
				$Admin->photo = $fileInfo;
			} else {
				$Admin->photo = 'photo/gif-60.gif';
			}
			
			//获取管理员账号,用于存入日志
			$logMsg = $Admin->account;

			if ($Admin->add ()) {
				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了添加管理员操作,添加的管理员账号为 '. $logMsg;
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success ( '添加成功!', __APP__ . '/Admin/Admin/index' );
			} else {
				$this->error ( '添加失败!' );
			}
		}
	}
	
	/**
	 * 显示修改页面
	 */
	public function showEditView() {
		$admin_id = $_GET ['admin_id'];
		$mw = $_GET ['mw'];
		// 参数不能为空
		if (empty ( $admin_id ) || empty ( $mw )) {
			$this->error ( "非法操作,错误代号13" );
		}
		// 判断密文和id是否匹配
		if (passport_decrypt ( $mw ) !== $admin_id) {
			$this->error ( "非法操作,错误代号1001-管理员修改页显示" );
		}
			
		$AdminLogic = D ( 'Admin', 'Logic' );
		$AdminGroupLogic = D ( 'AdminGroup', 'Logic' );
		$PermGroupLogic = D ( 'PermGroup', 'Logic' );
			
		// 获取管理员基本信息
		$admin = $AdminLogic->getAdminInfo ( $admin_id );
		if (is_null ( $admin )) {
			$this->error ( "管理员不存在,错误代号12" );
		}
		// 如果该用户为ROOT用户
		if ($admin ['root'] == 1) {
			$this->error ( "非法操作，不能修改ROOT用户，错误代号1002" );
		}
		// 获取当前管理员所拥有的权限分组id
		$adminPermIdList = explode ( ',', $admin ['perm_group_id'] );
		// 获取所有管理员分组
		$adminGroupList = $AdminGroupLogic->getAdminGroupList ();
		// 获取当前管理员分组下面的所有权限分组id
		$adminGroupPermIdList = $AdminGroupLogic->getAdminGroupPermList ( $admin ['admin_group_id'] );
		// 根据id数据，获取权限分组详细信息
		$adminGroupPermList = $PermGroupLogic->getPermGroupInfo ( $adminGroupPermIdList );
		// p($adminGroupPermList);
			
		// 调用Assign控制器，传递页面所需要的基本参数
		$Assign = A ( 'Assign' );
		$Assign->index ();
			
		$this->assign ( 'adminUser', $admin );
		$this->assign ( 'mw', $mw );
		$this->assign ( 'adminPermIdList', $adminPermIdList );
		$this->assign ( 'adminGroupList', $adminGroupList );
		$this->assign ( 'adminGroupPermList', $adminGroupPermList );
			
		$this->display ();
	}
	
	
	/**
	 * 修改管理员
	 */
	public function edit() {
		$Admin = D ( 'Admin' );
		$AdminLogic = D ( 'Admin', 'Logic' );
		// 自动验证表单数据合法性
		if (! $Admin->validate ( $Admin->editValidate )->create ()) {
			$this->error ( $Admin->getError () );
		} else {
			
			$admin_id = $_POST ['admin_id'];
			$mw = $_POST['mw'];
			
			if (empty($admin_id) || empty($mw)) {
				$this->error ( "非法操作,错误代号13" );
			}
			
			if (passport_decrypt ( $mw ) !== $admin_id) {
				//密码和密文是否匹配
				$this->error ( "非法操作,错误代号1001-管理员修改表单提交" );
			}
			
			$password = md5 ( $_POST ['password'] );
			// 获取该ID对应的管理员信息
			$user = $AdminLogic->getAdminInfo ( $admin_id );
			
			if (empty($user)) {
				$this->error("管理员不存在，错误代号12");
			}
			
			if ($user['root'] == 1) {
				$this->error("非法操作，不能修改ROOT用户，错误代号1002");
			}
			
			if ($password === md5 ( "default" )) {
				$password = $user ['password'];
			}
			
			$permGroupId = $_POST ['perm_group_id'];
			// 拼接权限组id
			$permGroupStr = "";
			foreach ( $permGroupId as $v ) {
				$permGroupStr .= $v . ',';
			}
			$permGroupStr = substr ( $permGroupStr, 0, strlen ( $permGroupStr ) - 1 );
			
			$Admin->password = $password;
			$Admin->perm_group_id = $permGroupStr;
			
			// 上传头像到服务器
			if ($_FILES ['photo'] ['name'] != "") {
				//删除原图片
				unlink ( $this->uploadPath . $user ['photo'] );
				$fileInfo = $this->upload ( 'photo', true );
				$Admin->photo = $fileInfo;
			} else {
				$Admin->photo = $user ['photo'];
			}
			
			//p ( $Admin );
			
			$logMsg = $Admin->account;

			if ($Admin->save () !== false) {
				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了修改管理员操作,修改的管理员账号为 '. $logMsg;
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success ( '修改成功!', __APP__ . '/Admin/Admin/index',1 );
			} else {
				$this->error ( '修改失败!' );
			}
		}
	}
	
	/**
	 * 响应管理员删除请求
	 */
	public function del(){
		$admin_id = $_GET['admin_id'];
		$mw = $_GET['mw'];
		//判断参数是否为空
		if (empty($admin_id) || empty($mw)) {
			$this->error("非法操作,错误代号13");
		}
		// 判断密文和id是否匹配
		if (passport_decrypt ( $mw ) !== $admin_id) {
			$this->error ( "非法操作,错误代号1001" );
		}
		
		$Admin = D ('Admin');
		$admin = $Admin->find($admin_id);
		if (!empty($admin)){
			if ($admin['root'] == 1) {
				$this->error("非法操作，不能修改ROOT用户，错误代号1002");
			}
			//删除头像图片
			unlink ( $this->uploadPath . $admin ['photo'] );
			if ($Admin->delete($admin_id)) {
				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了删除管理员操作,删除的管理员账号为 '. $admin['account'];
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success('删除成功!',__APP__.'/Admin/Admin/index');
			} else {
				$this->error('删除失败!');
			}
		} else {
			$this->error('管理员不存在!');
		}
		
	}
	
	/**
	 * 响应管理员添加页面的额Ajax请求，返回管理员分组对应的权限分组信息
	 *
	 * @param integer $admin_group_id        	
	 * @return JSON
	 */
	public function getPermGroupList() {
		$PermGroupLogic = D ( 'PermGroup', 'Logic' );
		$AdminGroupLogic = D ( 'AdminGroup', 'Logic' );
		// 如果是GET请求
		if (IS_GET) {
			$admin_group_id = $_GET ['admin_group_id'];
			$permGroupIdList = $AdminGroupLogic->getAdminGroupPermList ( $admin_group_id );
			if ($permGroupIdList === false) {
				$data ['status'] = 0;
				$data ['msg'] = "系统错误，错误代号11";
				$this->ajaxReturn ( $data, 'JSON' );
			} else {
				$data ['status'] = 1;
				$data ['data'] = $PermGroupLogic->getPermGroupInfo ( $permGroupIdList );
				$data ['msg'] = "Success";
				$this->ajaxReturn ( $data, 'JSON' );
			}
		} else {
			$data ['status'] = 0;
			$data ['msg'] = "Error";
			$this->ajaxReturn ( $data, 'JSON' );
		}
	}
	
	/**
	 * 相应管理员添加页面Ajax请求,验证用户名是否存在
	 *
	 * @param string $account        	
	 * @return JSON
	 */
	public function checkAccount() {
		$AdminLogic = D ( 'Admin', 'Logic' );
		if (IS_GET) {
			$account = $_GET ['account'];
			if (empty($account)) {
				$data ['status'] = 1;
				$data ['msg'] = "账户为空";
				$this->ajaxReturn ( $data, 'JSON' );
			}
			if ($AdminLogic->checkAccount ( $account )) {
				$data ['status'] = 1;
				$data ['msg'] = "账户已存在";
				$this->ajaxReturn ( $data, 'JSON' );
			} else {
				$data ['status'] = 0;
				$data ['msg'] = "";
				$this->ajaxReturn ( $data, 'JSON' );
			}
		}
	}
	
	/**
	 * 相应管理员添加页面Ajax请求,验证邮箱是否存在
	 *
	 * @param string $account        	
	 * @return JSON
	 */
	public function checkEmail() {
		$AdminLogic = D ( 'Admin', 'Logic' );
		if (IS_GET) {
			$email = $_GET ['email'];
			if ($AdminLogic->checkEmail ( $email )) {
				$data ['status'] = 1;
				$data ['msg'] = "邮箱已存在";
				$this->ajaxReturn ( $data, 'JSON' );
			} else {
				$data ['status'] = 0;
				$data ['msg'] = "";
				$this->ajaxReturn ( $data, 'JSON' );
			}
		}
	}
}