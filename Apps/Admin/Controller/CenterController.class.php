<?php


namespace Admin\Controller;
use Think\Controller;

class CenterController extends BaseController {

	public function index(){

		//获取网站访问量
        $Visit = D ('Visit');	
		//获取当前时间包含的年月日
		$time = time();
		$y = date('y',$time);
		$m = date('m',$time);
        $visitCount = $Visit->getVisitCount($y,$m);
        //p($visitCount);
		$Mysql = D ('Mysql');
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
    			'mysql_version' => $Mysql->getMysqlVersion(), //获取服务器MySQL版本
    			'mysql_size' => $Mysql->getMysqlSize(), //获取服务器Mysql已使用大小
    	);

    	$this->assign('y',$y);
    	$this->assign('m',$m);
    	$this->assign('visitCount',$visitCount);
    	$this->assign('serverinfo',$serverinfo);
		$this->display();
	}


	public function now(){
		//获取网站访问量
        $Visit = D ('Visit');	
		//获取当前时间包含的年月日
		$time = time();
		$y = date('y',$time);
		$m = date('m',$time);
        $visitCount = $Visit->getVisitCount($y,$m);
        $data['status'] = 1;
        $data['dataN'] = $visitCount['now'];
        $data['dataL'] = $visitCount['last'];
        $data['y'] = $y;
        $data['m'] = $m;
        $this->ajaxReturn($data,'JSON'); 
	}


	public function next(){
		//获取网站访问量
        $Visit = D ('Visit');	
		//获取当前时间包含的年月日
		$y = $_GET['y'];
		$m = $_GET['m'];
		if ($m == 12) {
			$y++;
			$m = 1;
		} else {
			$y += 1;
			$m += 1;
		}

        $visitCount = $Visit->getVisitCount($y,$m);
        //p($visitCount);
        $data['status'] = 1;
        $data['dataN'] = $visitCount['now'];
        $data['dataL'] = $visitCount['last'];
        $data['y'] = $y;
        $data['m'] = $m;
        $this->ajaxReturn($data,'JSON'); 
	}

	public function last() {
		//获取网站访问量
        $Visit = D ('Visit');	
		//获取当前时间包含的年月日
		$y = $_GET['y'];
		$m = $_GET['m'];
		if ($m == 1){
			$y--;
			$m = 12;
		} else {
			$y -= 1;
			$m -= 1;
		}

        $visitCount = $Visit->getVisitCount($y,$m);
        $data['status'] = 1;
        $data['dataN'] = $visitCount['now'];
        $data['dataL'] = $visitCount['last'];
        $data['y'] = $y;
        $data['m'] = $m;
        $this->ajaxReturn($data,'JSON'); 
	}

}