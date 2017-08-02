<?php
namespace Admin\Controller;
/**
 * 2014/7/9
 * @author webzrf
 * Sever App Template page Controller
 */

class logController extends BaseController{
	
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
	/**
	 * 获取日志信息
	 */
	public function index(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$Log = D ('Log');
		$Admin= D ('Admin');		
			$count = $Log->count();
			$Page = new\Think\Page($count,8);
			$show = $Page->show();
			$logList = $Log->limit($Page->firstRow.','.$Page->listRows)->order('time desc')->select(); 
		 for($i=0;$i<count($logList);$i++){
			$logList[$i]['mw'] = passport_encrypt($logList[$i]['log_id']);
			$logList [$i] ['time'] = date ( "Y-m-d h:i:sa", $logList [$i] ['time'] );
			$admin_id = $logList[$i]['admin_id'];
			$logList[$i]['admin_name'] = $Admin->where("admin_id = $admin_id")->getField('name');			
		 }  
		 //面包屑
		 $mbx = array(
		 		'first_item'=>'系统管理',
		 		'url'=>'Log/index',
		 		'second_item'=>'日志管理',
		 );
		 $this->assign ( 'mbx', $mbx );
		$this->assign('page',$show);
		$this->assign('logList',$logList);
		$this->display();				
	}
	/**
	 * 删除日志信息
	 */	
	public function del(){
		//获取ID 和 密文
		$log_id = $_GET ['log_id'];
		//将字符串转换为数组  取出单个复选框的ID+mw
		$arr1 = explode(",",$log_id);
		//取出 单个复选框的id 和 mw
		for($i=0;$i<count($arr1);$i++){
			$arr2[$i] = explode('-',$arr1[$i]);
		}
		for($i=0;$i<count($arr2);$i++){
			//将ID组合
			$id[$i] = $arr2[$i][0];
			//逐个id 和解密密文 进行判断
			if($arr2[$i][0] == passport_decrypt($arr2[$i][1])){
				//如果正确就跳出循环
				continue;
			}else{
				//不正确就记录下来
				$j=0;
				$j++;
			}
		}
		//将ID整合成log_id
		$log_id = implode(',',$id);
		if($j>0){
			$this->error ( '非法操作,错误代码1001！' );
		}else{
			$logModel = D ( 'log' );
			$where = "log_id in ($log_id)";
			$logModel->where ( $where )->delete();

			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了删除日志操作,共删除了' . $j . '篇日志';
			$Log->write($this->admin['admin_id'],$content,1);

			$this->success ( '删除成功！' );
		}	
	}
}
