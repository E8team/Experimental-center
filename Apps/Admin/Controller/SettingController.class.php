<?php 
namespace Admin\Controller;
use Think\Controller;
/**
 * 2014/7/14
 * @author baochao 
 *
 */
class SettingController extends BaseController{
	
	
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
	/**
	 * 列出网站设置
	 */
	public  function index(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$Setting = D('Setting',"Logic");
		$count = $Setting->count ();
		$page = new\Think\Page($count,8);
		$show = $page->show ();
		$limit = $page->firstRow . "," . $page->listRows;
		$settingList = $Setting->limit($limit)->select();
		for($i=0;$i<count($settingList);$i++){
			$settingList[$i]['mw'] = passport_encrypt($settingList[$i]['setting_id']);
		}	
		//面包屑
		$mbx = array(
				'first_item'=>'系统管理',
				'url'=>'Setting/index',
				'second_item'=>'网站设置',
		);
		$this->assign ( 'mbx', $mbx );
		$this->assign("settingList",$settingList);
		$this->assign('page',$show);
		$this->display();
	}
	/**
	 * 添加网站设置
	 */
	public function add() {
		$Setting = D ( 'Setting' );
		$Assign = A ( 'Assign' );
		$Assign->index ();
		if (IS_POST){
			if (!$Setting->validate($Setting->_validate)->create()){
				$this->error($Setting->getError());
			} else {

				$logMsg = $Setting->name;

				if ($Setting->add()){

					//写入日志
					$Log = D ('Log','Logic');
					$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了添加网站设置操作,添加的网站设置名称为 ' . $logMsg;
					$Log->write($this->admin['admin_id'],$content,1);

					$this->success('添加成功!',__APP__.'/Admin/Setting/index');
				} else {
					$this->error('添加失败!',__APP__.'/Admin/Setting/index');
				}
			}
		} else {
			$mbx = array(
					'first_item'=>'系统管理',
					'url'=>'index',
					'second_item'=>'网站设置',
			);
			$this->assign ( 'mbx', $mbx );				
			$this->display ();
		}
	}
	/**
	 * 修改网站设置
	 */
	public function edit(){
		$Setting = D ( 'Setting' );
		$Assign = A ( 'Assign' );
		$Assign->index ();
		if (IS_POST){
			$setting_id = $_POST['setting_id'];
			if (isset($setting_id)){
				if (!$Setting->validate($Setting->_validate)->create()){
					$this->error($Setting->getError());
				} else {

					$logMsg = $Setting->name;

					if ($Setting->save()){

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了修改网站设置操作,修改的网站设置名称为 ' . $logMsg;
						$Log->write($this->admin['admin_id'],$content,1);


						$this->success('修改成功!',__APP__.'/Admin/Setting/index');
					} else {
						$this->error('修改失败!',__APP__.'/Admin/Setting/index');
					}
				}
			}
		}else{
			if (isset($_GET['setting_id'])){
				$setting_id = $_GET['setting_id'];
				$mw = $_GET['mw'];
				if($setting_id !== passport_decrypt($mw)){
					$this->error ( '非法操作,错误代码1001！' );
				}else{
					if (($setting = $Setting->find($setting_id)) == null){
						$this->error('该网站设置不存在!');
					}
					$this->assign('setting',$setting);
					$this->display();
				}
			}else{
				$this->error('非法访问!');
			}
		}
	}
	/**
	 * 删除网站设置
	 */
	public function del(){
		$Setting = D('Setting');
		if (isset($_GET['setting_id'])){
			$setting_id = $_GET['setting_id'];
			$mw = $_GET['mw'];
			if($setting_id !== passport_decrypt($mw)){
				$this->error ( '非法操作,错误代码1001！' );
			}else{
				if ($Setting->find($setting_id)){
					$setting_id = $Setting->where("setting_id = $setting_id")->getField('setting_id');
					if ($Setting->delete())

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了删除网站设置操作,添加的网站设置ID为 ' . $setting_id;
						$Log->write($this->admin['admin_id'],$content,1);


						$this->success('删除成功!' , __APP__.'/Admin/Setting/index');
				} else {
					$this->error('该网站设置不存在!',__APP__.'/Admin/Setting/index');
				}
			}
		} else {
			$this->error('非法操作!',__APP__.'/Admin/Setting/index');
		}
	}
}