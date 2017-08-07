<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 管理员管理控制器
 * 控制管理员相关页面跳转
 *
 * 2014/7/13
 *
 * @author webdd
 *        
 */
class AdminController extends BaseController {
	
	// 权限验证
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		// 验证权限
		if (! in_array ( $action, $this->permission )) {
			$this->error ( "您没有权限操作当前模块" );
		}
	}
	
	/**
	 * 显示管理员列表页
	 */
	public function index() {
		// 调用Assign控制器，传递页面所需要的基本参数
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$Admin = D ( 'Admin' );
		$AdminGroupLogic = D ( 'AdminGroup', 'Logic' );
		$LogLogic = D ('Log','Logic');
		
		// 获取管理员分组
		$adminGroupList = $AdminGroupLogic->getAdminGroupList ();
		// 默认关键字
		$keyword = "";
		if (IS_POST) {
			$admin_group_id = $_POST ['admin_group_id'];
			$keyword = $_POST ['keyword'];
			// p($admin_group_id);
			// 如果指定了某个管理员分组，则设置条件
			if ($admin_group_id !== 'all')
				$condition ['admin_group_id'] = $admin_group_id;
			$where ['account'] = array (
					'like',
					'%' . $keyword . '%' 
			);
			$where ['name'] = array (
					'like',
					'%' . $keyword . '%' 
			);
			$where ['email'] = array (
					'like',
					'%' . $keyword . '%' 
			);
			$where ['_logic'] = 'or';
			$condition ['_complex'] = $where;
		}
		// 当前登录管理员不能管理自己
		$condition ['admin_id'] = array (
				'neq',
				$this->admin ['admin_id'] 
		);
		// Root用户不能被管理
		$condition ['root'] = array (
				'eq',
				0 
		);
		
		// 分页处理,获取数据
		$count = $Admin->where ( $condition )->count ();
		// P($Admin->getLastSql());
		$Page = new \Think\Page ( $count, 9 );
		$show = $Page->show ();
		$adminList = $Admin->where ( $condition )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		$adminList = $AdminGroupLogic->setGroupName ( $adminList );
		
		$adminList = $LogLogic->getAdminLog($adminList);

		//面包屑
		$mbx = array(
			'first_item'=>'系统管理',
			'url'=>'Admin/index',
			'second_item'=>'管理员管理',
			);
		// 传递数据
		$this->assign ( 'keyword', $keyword );
		$this->assign ( 'mbx', $mbx );
		$this->assign ( 'adminList', $adminList );
		$this->assign ( 'page', $show );
		$this->assign ( 'adminGroupList', $adminGroupList );
		$this->display ();
	}
	
	/**
	 * 显示管理添加页
	 */
	public function add() {
		// 实例化AdminEvent对象
		$AdminEvent = A ( 'Admin', 'Event' );
		// 实例化管理员分组业务逻辑层
		$AdminGroupLogic = D ( 'AdminGroup', 'Logic' );
		// 如果是POST提交
		if (IS_POST) {
			// 调用AdminEvent的add方法来保存数据
			$AdminEvent->add ();
		} else {
			// 调用Assign控制器，传递页面所需要的基本参数
			$Assign = A ( 'Assign' );
			$Assign->index ();
			
			// 获取所有管理员分组
			$adminGroupList = $AdminGroupLogic->getAdminGroupList ();
			$this->assign ( 'adminGroupList', $adminGroupList );
			//面包屑
			$mbx = array(
					'first_item'=>'系统管理',
					'url'=>'index',
					'second_item'=>'管理员管理',
			);
			$this->assign ( 'mbx', $mbx );
			$this->display ();
		}
	}
	
	/**
	 * 显示管理员修改页
	 */
	public function edit() {
		// 实例化AdminEvent对象
		$AdminEvent = A ( 'Admin', 'Event' );
		// 如果是POST提交方式
		if (IS_POST) {
			// 调用AdminEvent里面的修改方法
			$AdminEvent->edit ();
		} else {
			// 调用AdminEvent里面的显示修改页面方法
			$AdminEvent->showEditView ();
		}
		
		
	}
	
	/**
	 * 删除管理员
	 */
	public function del() {
		// 实例化AdminEvent对象
		$AdminEvent = A ( 'Admin', 'Event' );
		// 调用AdminEvent里面的修改方法
		$AdminEvent->del ();
	}
	
	
	/**
	 * 调用AdminEvent->getPermGroupList()响应管理员添加页面的额Ajax请求，返回管理员分组对应的权限分组信息
	 */
	public function getPermGroupList() {
		$AdminEvent = A ( 'Admin', 'Event' );
		$AdminEvent->getPermGroupList ();
	}
	
	/**
	 * 调用AdminEvent->checkAccount()响应管理员添加页面Ajax请求,验证用户名是否存在
	 */
	public function checkAccount() {
		$AdminEvent = A ( 'Admin', 'Event' );
		$AdminEvent->checkAccount ();
	}
	
	/**
	 * 调用AdminEvent->checkEmail()响应管理员添加页面Ajax请求,验证邮箱是否存在
	 */
	public function checkEmail() {
		$AdminEvent = A ( 'Admin', 'Event' );
		$AdminEvent->checkEmail ();
	}
}