<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 基类
 * 用于初始化程序
 * 
 * 2014/7/9
 * @author webdd
 */
class BaseController extends Controller {
	
	protected $admin; //管理员对象
	protected $msg; //登录用户未读消息数组
	protected $menu; //栏目列表
	protected $permission; //权限列表
	protected $sessionName; //用户SESSION标示符
	protected $webConfig; //获取网站配置
	
	/**
	 * 构造函数
	 */
	public function __construct(){
		parent::__construct();
		$this->initialize();
	}

	
	/**
	 * 系统初始化函数，包含以下功能
	 * 1、调用checkLogin() 验证用户是否登录
	 * 2、调用getNewMsg() 获取用户未处理新消息
	 * 3、调用getColumn() 获取栏目列表
	 * 4、调用getPermission() 获取用户权限
	 * 5、调用getSessionName() 获取ip对应的session信息  (优先级最高)
	 * 
	 */
	private function initialize(){
		//验证用户登录
		if ($this->checkLogin()){
			$this->admin = session($this->sessionName);
			//$this->getMsg($this->admin);
			$this->getColumn();
			$this->getPermission($this->admin);
			$this->getWebInfo();
		}
	}
	
	
	/**
	 * 验证用户是否登录函数，若用户没有登录，则跳转到登录界面
	 * 
	 * 2014/7/10
	 * @return boolean
	 */
	private function checkLogin(){
		//调用函数，获取session信息
		$this->getSessionName();
		if (is_null(session($this->sessionName))){
			//页面重定向
			$this->redirect('/Admin/Login/index');
		}
		return true;
	}
	
	/**
	 * 获取用户未读消息
	 * 根据当前登录的用户，获取用户收取到的新消息
	 * 
	 * @param Admin $admin
	 * 
	 */
	private function getMsg($admin){
		$MsgLogic = D ('Msg','Logic');
		$AdminLogic = D ('Admin','Logic');
		$admin_id = $admin['admin_id'];
		$msgArr = $MsgLogic->getNewMsg($admin_id);
		foreach ($msgArr as $k=>$v){
			$sendUserName =$AdminLogic->getAdminName($v['send_user']);
			if ($sendUserName === false) {
				$this->error("找不到改用户，错误代号10!",__APP__.'Admin/Index/index',3);
			}
			$msgArr[$k]['send_user_name'] = $sendUserName;
			//调用函数，将时间戳改为距离当前的时间字符串
			$msgArr[$k]['send_time'] = timeToNow($v['send_time']);
		}
		$this->msg = $msgArr;
	}
	
	
	/**
	 * 获取栏目列表
	 * 根据用户权限，获取相应栏目列表
	 * 
	 * @param Object $admin
	 */
	private function getColumn(){
		$MenuLogic = D ('Menu','Logic');
		$menu = $MenuLogic->getMenu();
		$this->menu = $menu;
	}
	

	/**
	 * 获取网站配置信息
	 */
	public function getWebInfo() {
		$Setting = M ('Setting');
		$webInfoArr = $Setting->select();
		$webInfo = array();
		//处理网站信息数组
		foreach ($webInfoArr as $key=>$val) {
			$webInfo[$val['item']] = $val['value'];
		}
		
		$this->webConfig = $webInfo;
	}

	
	/**
	 * 获取用户权限
	 * 获取用户所有操作权限
	 * 
	 * @param Object $admin
	 * @return Array(String) $permission
	 */
	private function getPermission($admin){
		$PermGroupLogic = D ('PermGroup','Logic');
		$PermissionLogic = D ('Permission','Logic');
		$permIdArr = $PermGroupLogic->getPermIdList($admin['perm_group_id']);
		$permission = $PermissionLogic->getActionList($permIdArr);
		//p($permission);
		$this->permission = $permission;
	}
	
	/**
	 * 获取用户session信息标记
	 */
	private function getSessionName(){
		$SessionLogic = D ('Session','Logic');
		$session = $SessionLogic->checkSession(get_client_ip());
		//p($session);
		$this->sessionName = $session['name'];
	}
	
	
	/**
	 * 管理员退出
	 */
	public function loginout(){
		$Admin = D ('Admin','Logic');
		if ($Admin->changeState($this->admin['admin_id'],0)){
			session ($this->sessionName,null);
			$this->success('退出成功!',__APP__.'/Admin/Login',1);
		}else{
			$this->error('更改用户登录状态出错!');
		}
	}
	
	
	/**
	 * 系统文件上传函数
	 * @param unknown_type $type 文件上传类型
	 * @param unknown_type $thumb 是否生成缩略图
	 * @param unknown_type $path 返回路径还是上传文件对象
	 * @return String | Object
	 */
	function upload($type,$thumb = false,$path=true){
		// 上传文件类型
		$ext_arr = array(
				'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
				'photo' => array('jpg', 'jpeg', 'png'),
				'flash' => array('swf', 'flv'),
				'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
				'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2','pdf')
		);
	
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->autoSub = true;//使用子目录保存上传文件
		$upload->subName = array('date','Ymd');
		$upload->subType = 'hash';//使用日期模式创建子目录
		//$upload->dateFormat = 'Ymd';//设置子目录日期格式
		$upload->allowExts  = $ext_arr[$type];// 设置附件上传类型
		$upload->rootPath = "./Public/upload/";
		$upload->savePath =  $type."/";// 设置附件上传目录
		$upload->saveRule = 'uniqid';
		$upload->thumb = $thumb;//生成缩略图
		$upload->thumbMaxWidth = '200';//缩略图最大宽度
		$upload->thumbMaxHeight = '200';//缩略图最大高度
		$upload->thumbRemoveOrigin = false;
	
		// 上传文件
		$info   =   $upload->upload();
		//p($info === false);
		if($info === false) {
			echo "error";
			// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{
			// 上传成功 获取上传文件信息
			if ($path){
				foreach($info as $file){
					return $file['savepath'].$file['savename'];
				}
			} else {
				return $info;
			}
		}
	}

}