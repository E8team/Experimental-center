<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 权限分组控制器
 * @author webdd
 *
 */
class PermGroupController extends BaseController {
	
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
	
	/**
	 * 显示权限分组列表
	 */
	public function index(){
		// 调用Assign控制器，传递页面所需要的基本参数
		$Assign = A ( 'Assign' );
		$Assign->index ();
		//响应搜索表单
		$keyword = "";
		if (IS_POST) {
			//搜索关键字
			$keyword = $_POST ['keyword'];
			if (!is_null($keyword)){
				$where ['name'] = array (
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
		
		$PermGroupLogic = D ('PermGroup','Logic');
		$PermissionLogic = D ('Permission','Logic');
		$count = $PermGroupLogic->where($condition)->count();
		$Page = new \Think\Page ( $count , 9 );
		$show = $Page->show();
		//获取权限分组信息列表
		$permGroupList = $PermGroupLogic->where($condition)->limit($Page->firstRow . ',' . $Page->listRows)->select();
		//获取权限分组对应的权限详细信息
		$permGroupList = $PermissionLogic->getPermissionInfo($permGroupList);
		//附加密文
		$permGroupList = $PermGroupLogic->setMw($permGroupList);
		//面包屑
		$mbx = array(
				'first_item'=>'系统管理',
				'url'=>'PermGroup/index',
				'second_item'=>'权限分组管理',
		);
		$this->assign ( 'mbx', $mbx );
		$this->assign('permGroupList',$permGroupList);
		$this->assign('keyword',$keyword);
		$this->assign('page',$show);
		$this->display();
	}
	
	/**
	 * 添加权限分组
	 */
	public function add(){
		//如果是POST方式提交
		if (IS_POST){
			$PermGroupEvent = A ('PermGroup','Event');
			$PermGroupEvent->add();
		} else {
			// 调用Assign控制器，传递页面所需要的基本参数
			$Assign = A ( 'Assign' );
			$Assign->index ();
			$PermissionLogic = D ('Permission','Logic');
			$permissionList = $PermissionLogic->getPermissionList();
			//面包屑
			$mbx = array(
					'first_item'=>'系统管理',
					'url'=>'index',
					'second_item'=>'权限分组管理',
			);
			$this->assign ( 'mbx', $mbx );
			$this->assign('permissionList',$permissionList);
			$this->display ();
		}
	}
	
	/**
	 * 编辑权限分组
	 */
	public function edit(){
		$PermGroupEvent = A ('PermGroup','Event');
		//如果是POST方式提交
		if (IS_POST){
			//响应修改提交请求
			$PermGroupEvent->edit();
		} else {
			//显示修改页面
			$PermGroupEvent->showEditView();
		}
	}
	
	/**
	 * 删除权限分组
	 */
	public function del(){
		$perm_group_id = $_GET['perm_group_id'];
		$mw = $_GET['mw'];
		//判断传递过来的参数是否为空
		if (is_null($perm_group_id) || is_null($mw)){
			$this->error ( "非法操作,错误代号16" );
		}
		// 判断密文和id是否匹配
		if (passport_decrypt ( $mw ) !== $perm_group_id) {
			$this->error ( "非法操作,错误代号1001-权限分组修改页显示" );
		}
		
		$AdminLogic = D ('Admin','Logic');
		$AdminGroupLogic = D ('AdminGroup','Logic');
		$PermGroup = D ('PermGroup');
		$permGroup = $PermGroup->find($perm_group_id);
		if (is_null($permGroup)) {
			$this->error("权限分组不存在");
		}
		//启用事物
		$AdminLogic->startTrans();
		$AdminGroupLogic->startTrans();
		$PermGroup->startTrans();
		//删除管理员包含的权限数组信息
		$flag1 = $AdminLogic->delPermGroupId($perm_group_id);
		//删除管理员数组包含的权限数组信息
		$flag2 = $AdminGroupLogic->delPermGroupId($perm_group_id);
		//删除权限分组
		$flag3 = $PermGroup->delete($perm_group_id);
		if ($flag1 && $flag2 && $flag3) {
			//提交事务
			$AdminLogic->commit();
			$AdminGroupLogic->commit();
			$PermGroup->commit();

			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了删除权限分组操作,删除的权限分组ID为 ' . $perm_group_id;
			$Log->write($this->admin['admin_id'],$content,1);

			$this->success("删除成功",__APP__.'/Admin/PermGroup/index');
		} else {
			//事务回滚
			$AdminLogic->rollback();
			$AdminGroupLogic->rollback();
			$PermGroup->rollback();
			$PermGroup->commit();
			$this->error("删除失败");
		}
	}
	
}