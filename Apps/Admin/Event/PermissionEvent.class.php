<?php
namespace Admin\Event;
use Think\Controller;

/**
 * 响应权限动作
 * @author webdd
 *
 */

class PermissionEvent extends Controller {
	/**
	 * 响应表单添加权限操作
	 */
	public function add(){
		$Permission = D ('Permission');
		if (! $Permission->validate ( $Permission->addValidate )->create ()) {
			$this->error ( $Permission->getError () );
		} else {

			$logMsg['name'] = $Permission->name;
			$logMsg['id'] = $Permission->permission_id;

			if ($Permission->add ()) {

				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了添加权限操作,添加的权限ID为 ' . $logMsg['id'] . ',权限名称为 ' .$logMsg['name'];
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success ( '添加成功!', __APP__ . '/Admin/Permission/index' );
			} else {
				$this->error ( '添加失败!' );
			}
		}
	}
	
	/**
	 * 响应表单修改权限操作
	 */
	public function edit(){
		$Permission = D ('Permission');
		// 自动验证表单数据合法性
		if (! $Permission->validate ( $Permission->editValidate )->create ()) {
			$this->error ( $Permission->getError () );
		} else {
			$permission_id = $_POST ['permission_id'];
			$mw = $_POST['mw'];
				
			if (is_null($permission_id) || is_null($mw)) {
				$this->error ( "非法操作,错误代号15" );
			}
			if (passport_decrypt ( $mw ) !== $permission_id) {
				//密码和密文是否匹配
				$this->error ( "非法操作,错误代号1001-权限修改" );
			}

			//日志记录所需数据
			$logMsg['name'] = $Permission->name;
			$logMsg['id'] = $Permission->permission_id;

			if ($Permission->save() !== false) {

				//写入日志
				$Log = D ('Log','Logic');
				$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了修改权限操作,修改的权限ID为 ' . $logMsg['id'] . ',权限名称为 ' .$logMsg['name'];
				$Log->write($this->admin['admin_id'],$content,1);

				$this->success("修改成功",__APP__.'/Admin/Permission/index/',1);
			} else {
				$this->error("操作失败");
			}
		}
	}
	
	/**
	 * 响应表单权限删除操作
	 */
	public function del(){
		//GET方式获取传递过来的参数
		$permission_id = $_GET ['perm_id'];
		$mw = $_GET['mw'];
		
		if (is_null($permission_id) || is_null($mw)) {
			$this->error ( "非法操作,错误代号15" );
		}
		if (passport_decrypt ( $mw ) !== $permission_id) {
			//密码和密文是否匹配
			$this->error ( "非法操作,错误代号1001-权限修改" );
		}
		
		$PermGroupLogic = D ('PermGroup','Logic');
		$Permission = D ('Permission');
		
		//更新权限分组表，将包含该权限的ID从字段中删除
		//启用事物，支持回滚操作
		$PermGroupLogic->startTrans();
		$Permission->startTrans();
		
		//删除权限组对应权限信息和该权限
		if ($PermGroupLogic->delPermissionId($permission_id) && $Permission->delete($permission_id)){
			//提交事物
			$PermGroupLogic->commit();
			$Permission->commit();

			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了删除权限操作,删除的权限ID为 ' . $permission_id;
			$Log->write($this->admin['admin_id'],$content,1);

			$this->success('删除成功!',__APP__.'/Admin/Permission/index',1);
		} else {
			//事物回滚
			$PermGroupLogic->rollback();
			$Permission->rollback();
			$this->error('删除失败!',__APP__.'/Admin/Permission/index',1);
		}
	}
}