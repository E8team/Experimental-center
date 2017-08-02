<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 权限管理控制器
 * @author webdd
 *
 */
class PermissionController extends BaseController {
	
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
	/**
	 * 显示权限列表
	 */
	public function index(){
		// 调用Assign控制器，传递页面所需要的基本参数
		$Assign = A ( 'Assign' );
		$Assign->index ();
		
		$keyword = "";
		if (IS_POST) {
			//搜索关键字
			$keyword = $_POST ['keyword'];
			if (!is_null($keyword)){
				$where ['name'] = array (
						'like',
						'%' . $keyword . '%'
				);
				$where ['action'] = array (
						'like',
						'%' . $keyword . '%'
				);
				$where ['description'] = array (
						'like',
						'%' . $keyword . '%'
				);
				$where ['_logic'] = 'or';
				$condition ['_complex'] = $where;
			}
		}
		
		$PermissionLogic = D ('Permission','Logic');
		$count = $PermissionLogic->where($condition)->count();
		$Page = new \Think\Page ( $count, 10 );
		$show = $Page->show ();
		$permissionList = $PermissionLogic->where ( $condition )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
		//生成配套密文
		$permissionList = $PermissionLogic->setPermissionIdMw($permissionList);
		//面包屑
		$mbx = array(
				'first_item'=>'系统管理',
				'url'=>'Permission/index',
				'second_item'=>'权限管理',
		);
		$this->assign ( 'mbx', $mbx );
		$this->assign('keyword',$keyword);
		$this->assign("page",$show);
		$this->assign('permissionList',$permissionList);
		$this->display();
	}
	
	/**
	 * 添加权限
	 */
	public function add(){
		// 如果是POST提交
		if (IS_POST) {
			$PermissionEvent = A ('Permission','Event');
			// 调用AdminEvent的add方法来保存数据
			$PermissionEvent->add ();
		} else {
			// 调用Assign控制器，传递页面所需要的基本参数
			$Assign = A ( 'Assign' );
			$Assign->index ();
			//面包屑
			$mbx = array(
					'first_item'=>'系统管理',
					'url'=>'index',
					'second_item'=>'权限管理',
			);
			$this->assign ( 'mbx', $mbx );
			$this->display ();
		}
	}
	
	/**
	 * 修改权限
	 */
	public function edit(){
		if (IS_POST) {
			$PermissionEvent = A ('Permission','Event');
			$PermissionEvent->edit();
		} else {
			$permission_id = $_GET['perm_id'];
			$mw = $_GET['mw'];
			// 参数不能为空
			if (is_null ( $permission_id ) || is_null ( $mw )) {
				$this->error ( "非法操作,错误代号15" );
			}
			// 判断密文和id是否匹配
			if (passport_decrypt ( $mw ) !== $permission_id) {
				$this->error ( "非法操作,错误代号1001-权限修改" );
			}
			$Permission = D ('Permission');
			$permission = $Permission->find($permission_id);
			if (is_null($permission)){
				$this->error("找不到指定权限");
			}
			$this->assign('permission',$permission);
			$this->assign('mw',$mw);
			// 调用Assign控制器，传递页面所需要的基本参数
			$Assign = A ( 'Assign' );
			$Assign->index ();
			
			$this->display();
		}
	}
	
	/**
	 * 删除权限
	 */
	public function del(){
		$PermissionEvent = A ('Permission','Event');
		$PermissionEvent->del();
	}
	
}