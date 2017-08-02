<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 2014/7/8
 * @author baochao
 * Sever App Index page Controller
 */

class IndexController extends BaseController{
	
	//权限验证
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
    public function index(){
    	
    	//调用Assign控制器，传递页面所需要的基本参数
    	$Assign = A ('Assign');
    	$Assign->index();
    	

        //获取网站访问量
        $Visit = D ('Visit','Logic');
        $visitCount = $Visit->getVisitCount();
        $historyVisitCount = $Visit->getHistoryCount();
        //p($visitCount);

    	$Common = D ('Common','Logic');
    	//获取服务器配置信息
    	$serverinfo = array(
    			'os' => $_SERVER["SERVER_SOFTWARE"], //获取服务器标识的字串
    			'php_version' => PHP_VERSION, //获取PHP服务器版本
    			'time' => date("Y-m-d H:i:s", time()), //获取服务器时间
    			'pc' => $_SERVER['SERVER_NAME'], //当前主机名
    			'osname' => php_uname(), //获取系统类型及版本号
    			'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'], //获取服务器语言
    			'port' => $_SERVER['SERVER_PORT'], //获取服务器Web端口
    			'max_upload' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", //最大上传
    			'max_ex_time' => ini_get("max_execution_time")."秒", //脚本最大执行时间
    			'mysql_version' => $Common->getMysqlVersion(), //获取服务器MySQL版本
    			'mysql_size' => $Common->getMysqlSize(), //获取服务器Mysql已使用大小
    	);
    	
        $this->assign('visitCount',$visitCount);
        $this->assign('historyVisitCount',$historyVisitCount);
    	$this->assign('serverinfo',$serverinfo);
        $this->display();
    }
    
}