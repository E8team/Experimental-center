<?php
namespace Admin\Controller;
use Think\Controller;

class FindpasswordController extends Controller{
	/**
	 * 忘记密码
	 */
	public function index(){
		$Admin = D ("Admin");
		$Setting = D ("Setting");
		$Email = D ("Email");
		$website = $Setting->where(" item =  'indexurl' ")->getField("value");
		if(IS_POST){
			if(empty($_POST['account']) or empty($_POST['email'])){
				$this->error("账号和邮箱不能为空",__APP__."/Admin/Findpassword/index");
			}else{
				$account = $_POST['account'];
				$mw = passport_encrypt($account);
				$email = $_POST['email'];
				$result = $Admin->where("account = "."'". $account. "' and email = " ."'". $email. "'")->find();
				//如果找到，就发送邮件
				if($result){
					$sendtime = time();
					 if ($Email->create()){
							$Email->account = $account;
							$Email->sendtime = $sendtime;
							$Email->add();
							$id = mysql_insert_id();
							$mw_id = passport_encrypt(strval($id));
							//发送邮件
							think_send_mail($email,$account,"E8后台管理员找回密码",
							"链接地址:     "."http://{$website}".__APP__."/Admin/Findpassword/find/account/{$mw}/email_id/{$mw_id}".'<br/>'.'请于10分钟之内进行找回密码操作','');
							$this->success("邮件发送成功,请查收！");
					 } 
				}else{
					$this->error("账号或邮箱不正确",__APP__."/Admin/Findpassword/index");
				}
			}
		}else{
			$this->display();
		}
	}
	
	/**
	 * 找回密码
	 */
	public function find(){
		$Admin = D ("Admin");
		$Email = D ("Email");
		if(IS_POST){
			$account = $_POST['account'];
			$password = $_POST['password'];
			$rpassword = $_POST['rpassword'];
			if($password !== $rpassword){
				$this->error("两次密码输入不正确！");
			}else{
				$Admin->where(" account = "."'" . $account . "'")->setField("password", md5($password));
				$this->success("密码修改成功,请重新登陆",__APP__."/Admin/Login/index");
			}
		}else{
			if(isset($_GET['account']) and isset($_GET['email_id'])){
				$account = passport_decrypt($_GET['account']);
				$email_id = passport_decrypt($_GET['email_id']);
				$result1 = $Admin->where( "account = "."'". $account. "'" )->find();
				$result2 = $Email->where( " email_id = $email_id ")->find();
				$sendtime = $Email->where(" email_id = $email_id ")->getField("sendtime");
				$now = time();
				if( $now-$sendtime > 600 ){
					$this->error("找回密码超时,请重新操作",__APP__."/Admin/Findpassword/index");
				}else{
					if($result1 == null){
						$this->error("账号不存在！");
					}
					if($result2 == null ){
						$this->error("邮箱不存在！");
					}
					$this->assign("account",$account);
					$this->display();
				}		
			}else{
				$this->error(" 非法操作！");
			}
		}
	}
}
