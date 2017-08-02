<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * 管理员分组页面控制器
 *
 * @author webdd
 *         2014/7/17
 */
class AdminGroupController extends BaseController {
	
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
	/**
	 * 显示管理员分组列表
	 */
	public function index() {
		// 调用Assign控制器，传递页面所需要的基本参数
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$AdminLogic = D ( 'Admin', 'Logic' );
		$AdminGroupLogic = D ( 'AdminGroup', 'Logic' );
		$PermGroupLogic = D ( 'PermGroup', 'Logic' );
		
		//搜索关键字
		$keyword = "";
		if (IS_POST) {
			// 获取搜索关键字
			$keyword = $_POST ['keyword'];
			// 拼接查询条件
			$where ['name'] = array ('like' , '%' . $keyword . '%' );
			$where ['description'] = array ('like' , '%' . $keyword . '%' );
			$where ['_logic'] = 'or';
		} else {
			$where = "";
		}
		
		// 分页处理
		$count = $AdminGroupLogic->where ( $where )->count ();
		$Page = new \Think\Page ( $count, 9 );
		$show = $Page->show ();
		$adminGroupList = $AdminGroupLogic->where($where)->limit ( $Page->firstRow . ',' . $Page->listRow )->select ();
		//添加ID对应的密文
		$adminGroupList = $AdminGroupLogic->setAdminGroupListMw($adminGroupList);
		// p($adminGroupList);
		//统计该分组的管理员信息
		$adminGroupList = $AdminLogic->getAdminGroupUserInfo ( $adminGroupList );
		//统计该分组的权限组信息
		$adminGroupList = $PermGroupLogic->getAdminGroupPermGrouInfo ( $adminGroupList );
		
		//面包屑
		$mbx = array(
				'first_item'=>'系统管理',
				'url'=>'index',
				'second_item'=>'管理员分组管理',
		);
		$this->assign ( 'mbx', $mbx );
		$this->assign ('keyword',$keyword);
		$this->assign('adminGroupList',$adminGroupList);
		$this->assign ( 'admin', $this->admin );
		$this->assign('page',$show);
		
		$this->display ();
	}
	
	/**
	 * 添加分组管理
	 */
	public function add(){
		if (IS_POST){
			//实例化AdminGroupEvent对象
			$AdminGroupEvent = A ('AdminGroup','Event');
			$AdminGroupEvent->add();
		} else {
			// 调用Assign控制器，传递页面所需要的基本参数
			$Assign = A ( 'Assign' );
			$Assign->index ();
			
			$PermGroupLogic = D ('PermGroup','Logic');
			//获取所有权限分组信息
			$permGroupList = $PermGroupLogic->getPermGroupList();
			$this->assign('permGroupList',$permGroupList);
			//面包屑
			$mbx = array(
					'first_item'=>'系统管理',
					'url'=>'index',
					'second_item'=>'管理员分组管理',
			);
			$this->assign ( 'mbx', $mbx );
			$this->display();
		}
	}
	
	/**
	 * 修改管理员分组
	 */
	public function edit(){
		// 实例化$AdminGroupEvent对象
		$AdminGroupEvent = A ( 'AdminGroup', 'Event' );
		// 如果是POST提交方式
		if (IS_POST) {
			// 调用$AdminGroupEvent里面的修改方法
			$AdminGroupEvent->edit ();
		} else {
			//调用$AdminGroupEvent里面的显示修改页面方法
			$AdminGroupEvent->showEditView();
		}
	}
	
	
	/**
	 * 管理员分组删除方法
	 */
	public function del(){
		//获取Get方式传递回来的参数
		$admin_group_id = $_GET['admin_group_id'];
		$mw = $_GET['mw'];
		// 参数不能为空
		if (empty ( $admin_group_id ) || empty ( $mw )) {
			$this->error ( "非法操作,错误代号14" );
		}
		// 判断密文和id是否匹配
		if (passport_decrypt ( $mw ) !== $admin_group_id) {
			$this->error ( "非法操作,错误代号1001-管理员分组删除操作" );
		}
		
		$AdminLogic = D ('Admin','Logic');
		$AdminGroup = D ('AdminGroup');
		//更新管理员表，将属于该管理员分组的管理员分组id置空
		//在$AdminLogic模型中启动事务 *启动事物必须有数据库的支持,MySQL需要设置成InnDB格式
		$AdminLogic->startTrans();
		$AdminGroup->startTrans();
		//删除用户和用户权限记录
		if ($AdminLogic->delAdminGroupId($admin_group_id) && $AdminGroup->delete($admin_group_id)){
			//提交事物
			$AdminLogic->commit();
			$AdminGroup->commit();
			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了删除管理员分组操作,删除的管理员分组ID为 '. $admin_group_id;
			$Log->write($this->admin['admin_id'],$content,1);

			$this->success('删除成功!',__APP__.'/Admin/AdminGroup/index',1);
		} else {
			//事物回滚
			$AdminLogic->rollback();
			$AdminGroup->rollback();
			$this->error('删除失败!',__APP__.'/Admin/AdminGroup/index',1);
		}
	}
	
	/**
	 * 响应Ajax请求，改变分组可用状态
	 */
	public function changeUseful(){
		$AdminGroup = A ('AdminGroup','Event');
		$AdminGroup->changeUseful();
	}
}