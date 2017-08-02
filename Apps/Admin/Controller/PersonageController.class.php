<?php


namespace Admin\Controller;

use Think\Controller;

/**
 * 
 * @author Administrator
 *
 */
class PersonageController extends BaseController {

	/**
	 * 修改当前用户信息
	 */
	public function alter() {
		$Assign = A ( 'Assign' );
		$Assign->index ();
		
		$Admin = D ('Admin');
		if (IS_POST){
			$admin_id = $_POST['admin_id'];
			if (isset($admin_id)){
				if (!$Admin->validate($Admin->alterValidate)->create()){
					$this->error($Admin->getError());
				} else {
					$user = $Admin->where( " admin_id = $admin_id")->select();
					$password = $_POST ['password'];
					// 上传头像到服务器
					if ($_FILES ['photo'] ['name'] != "") {
						$fileInfo = $this->upload( 'photo',true );
						$Admin->photo = $fileInfo;				
					}
					//判断是否修改了密码。。
					if ( $password == "default" ){
						$password = $user ['0'] ['password'];
					}else {
						$password = md5 ($password);
					}
					$Admin->password = $password;
					if ($Admin->save() !== false){
						$this->success('修改成功!',__APP__.'/Admin/Index');
					} else {
						$this->error('修改失败!',__APP__.'/Admin/Index');
					}
				}
			}
		}else{
			if (isset($_GET['admin_id'])){
				$admin_id = $_GET['admin_id'];
				$mw = $_GET['mw'];
				if($admin_id !== passport_decrypt($mw)){
					$this->error ( '非法操作,错误代码1001！' );
				}else{
					if (($Admin = $Admin->find($admin_id)) == null){
						$this->error('该管理员不存在!',__APP__.'/Admin/Index');
					}
					$this->assign('Admin',$Admin);
					$this->display();
				}
			}else{
				$this->error('非法访问!',__APP__.'/Admin/Index');
			}
		} 
	}
}
