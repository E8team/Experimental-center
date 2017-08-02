<?php
namespace Admin\Event;
use Think\Controller;

/**
 * 权限分组相关动作
 * @author webdd
 *
 */
class PermGroupEvent extends BaseEvent{
	
	/**
	 * 添加权限分组
	 */
	public function add(){
		$PermGroup = D ('PermGroup');
		if (! $PermGroup->validate ( $PermGroup->addValidate )->create ()) {
			$this->error ( $PermGroup->getError () );
		} else {
			//获取权限id数组
			$permission_ids = $_POST['permission_id'];
			if (!is_null($permission_ids)){
				//拼接权限id
				$idStr = "";
				foreach ($permission_ids as $v) {
					$idStr .= $v . ',';
				}
				$idStr = substr ( $idStr, 0, strlen ( $idStr ) - 1 );
				$PermGroup->permission = $idStr;
			} else {
				$PermGroup->permission = "";
			}
			//保证ROOT分组的唯一性
			$PermGroup->root = 0;
			//p($PermGroup);
			//写入日志所需数据
			$logMsg['name'] = $PermGroup->name;
			$logMsg['id'] = $PermGroup->perm_group_id;
			if ($PermGroup->add()) {

				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了添加权限分组操作,添加的权限分组ID为 ' .$logMsg['id']. ',名称为' . $logMsg['name'];
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success("添加权限分组成功",__APP__.'/Admin/PermGroup/index',1);
			} else {
				$this->error("添加权限分组失败");
			}
		}
	}
	
	/**
	 * 显示权限分组修改页面
	 */
	public function showEditView(){
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
		
		$PermGroupLogic = D ('PermGroup','Logic');
		$permGroup = $PermGroupLogic->find($perm_group_id);
		if (is_null($permGroup))
			$this->error("指定权限分组不存在");
		$PermissionLogic = D ('Permission','Logic');
		//根据该分组的权限字符串，获取他的已有和未有权限数组
		$permissionArr = $PermissionLogic->getPermGroupByIdstr($permGroup['permission']);
		//p($permissionArr);
		$hArr = $permissionArr['have'];
		$nArr = $permissionArr['no'];
		//p($nArr);
		$this->assign('hArr',$hArr);
		$this->assign('nArr',$nArr);
		$this->assign('permGroup',$permGroup);
		$this->assign('mw',$mw);
		
		// 调用Assign控制器，传递页面所需要的基本参数
		$Assign = A ( 'Assign' );
		$Assign->index ();
		//p($permGroup);
		$this->display();
	}
	
	/**
	 * 响应权限分组修改动作
	 */
	public function edit(){
		$PermGroup = D ('PermGroup');
		if (! $PermGroup->validate ( $PermGroup->addValidate )->create ()) {
			$this->error ( $PermGroup->getError () );
		} else {
			$perm_group_id = $_POST['perm_group_id'];
			$mw = $_POST['mw'];
			//判断传递过来的参数是否为空
			if (is_null($perm_group_id) || is_null($mw)){
				$this->error ( "非法操作,错误代号16" );
			}
			// 判断密文和id是否匹配
			if (passport_decrypt ( $mw ) !== $perm_group_id) {
				$this->error ( "非法操作,错误代号1001-权限分组修改页显示" );
			}
			
			$permission_ids = $_POST['permission_id'];
			if (!is_null($permission_ids)){
				//拼接权限id
				$idStr = "";
				foreach ($permission_ids as $v) {
					$idStr .= $v . ',';
				}
				$idStr = substr ( $idStr, 0, strlen ( $idStr ) - 1 );
				$PermGroup->permission = $idStr;
			} else {
				$PermGroup->permission = "";
			}
			//保证ROOT分组的唯一性
			$PermGroup->root = 0;
			//写入日志所需数据
			$logMsg['name'] = $PermGroup->name;
			$logMsg['id'] = $PermGroup->perm_group_id;
			if ($PermGroup->save() !== false) {

				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了修改权限分组操作,修改的权限分组ID为 ' .$logMsg['id']. ',名称为' . $logMsg['name'];
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success("修改权限分组成功",__APP__.'/Admin/PermGroup/index',1);
			} else {
				$this->error("修改权限分组失败");
			}
		}
	}
	
}