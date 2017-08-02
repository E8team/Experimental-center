<?php

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller {
	
	/**
	 * 验证码生成函数
	 * 调用ThinkPHP框架，生成验证码
	 *
	 * $config 配置验证码数组
	 */
	public function createVerify() {
		$config = array (
				'fontSize' => 16,
				'length' => 4,
				'imageW' => 120,
				'imageH' => 40,
				'useNoise' => false, // 是否使用噪点
				'useCurve' => false, // 是否使用混淆曲线
				'bg' => array (
						51,
						163,
						255 
				), // 验证码背景色
				'fontttf' => '4.ttf'  // 验证码字体
				);
		$Verify = new \Think\Verify ( $config );
		ob_end_clean();
		$Verify->entry ();
	}
	
	/**
	 * 验证码验证函数 (私有，不可被访问)
	 * 调用ThinkPHP框架进行验证码验证
	 *
	 * @param string $code
	 *        	表单提交的验证字符串
	 * @param string $id
	 *        	验证码id，用于表示生成的多个验证码
	 */
	private function checkVerify($code, $id = '') {
		$verify = new \Think\Verify ();
		return $verify->check ( $code, $id );
	}
	
	/**
	 * index函数，显示登录界面
	 */
	public function index() {
		$this->display ();
	}
	
	/**
	 * 用户登录函数，验证用户是否登录正确
	 *
	 *
	 * @param $_POST['account'] 表单提交用户账户，为账户或者邮箱        	
	 * @param $_POST['password'] 表单提交用户密码        	
	 * @param $_POST['verify'] 表单提交验证码        	
	 */
	public function login() {
		// 实例化管理员模型
		$Admin = D ( 'Admin' );
		$AdminLogic = D ( 'Admin', 'Logic' );
		$AdminGroupLogic = D ( 'AdminGroup', 'Logic' );
		$SessionLogic = D ( 'Session', 'Logic' );
		
		if (! $Admin->validate ( $Admin->loginValidate )->create ()) {
			// 如果自动验证失败，返回登录界面
			$this->error ( $Admin->getError (), __APP__ . '/Admin/Login/index', 1 );
		} else {
			// 验证验证码
			$verify = $_POST ['verify'];
			if (! $this->checkVerify ( $verify )) {
				$this->error ( "验证码错误!", __APP__ . '/Admin/Login/index', 1 );
			} else {
				// 调用管理员逻辑层login方法，返回查询结果
				$admin = $AdminLogic->login ( $_POST ['account'], $_POST ['password'] );
				//p($admin);
				if (empty ( $admin )) {
					// 查询失败，没有该用户
					$this->error ( "账号密码不正确或用户不存在！", __APP__ . '/Admin/Login/index', 1 );
				} else {
					// 查询用户所属用户组
					$where ['admin_group_id'] = $admin ['admin_group_id'];
					$adminGroup = $AdminGroupLogic->where ( $where )->find ();
					// p($adminGroup);
					// 判断该用户组是否可用
					if ($adminGroup ['useful'] == 0) {
						$this->error ( "该用户所属用户组不可用，请联系管理员设置", __APP__ . '/Admin/Login/index', 1 );
					}
				}
				
				// 更改用户信息
				$admin ['login_time'] = time ();
				$admin ['login_ip'] = get_client_ip ();
				// 用户登录次数加1
				$admin ['login_num'] = $admin ['login_num'] + 1;
				// 更改用户登录状态
				$admin ['login_state'] = 1;
				
				// 保存登录信息
				if ($Admin->save ( $admin ) === false) {
					// 保存用户信息失败
					$this->error ( '登陆失败，缓存用户信息不成功!', __APP__ . '/Admin/Login/index', 1 );
				}
				
				// 查询session是否有该ip所对应的session信息
				$session = $SessionLogic->checkSession ( get_client_ip () );
				if ($session) {
					$sessionName = $session ['name'];
				} else {
					// 写入session信息到数据库
					$sessionName = md5 ( 'Hfzbf' . $admin ['account'] );
					if (! $SessionLogic->createSession ( get_client_ip (), $sessionName )) {
						$this->error ( '写入Session数据失败，请联系管理员', __APP__ . '/Admin/Login/index', 1 );
					}
				}

				//此处添加密文（不能放倒前面，前面需要写入数据库）
				$admin['mw'] = passport_encrypt($admin['admin_id']);
				// 存入session信息
				session ( $sessionName, $admin );

				//写入日志
				$Log = D ('Log','Logic');
				$content = $admin['account'] . '('. $admin['name'] . ') 登入了后台';
				$Log->write($admin['admin_id'],$content,1);

				// 页面重定向
				$this->redirect ( '/Admin/Index/index' );
			}
		}
	}
}