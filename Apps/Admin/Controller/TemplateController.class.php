<?php
namespace Admin\Controller;
/**
 * 2014/7/9
 * @author baochao
 * Sever App Template page Controller
 */
class TemplateController extends BaseController{
	
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
	/**
	 * 获取模板信息
	 */
	public function index(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$Template = D ('Template','Logic');
		if (IS_POST) {
			$keyword = $_POST ['keyword'];
			$type = $_POST['type'];
			if ($type !== 'all')
				$condition ['type'] = $type;
			$where ['name'] = array (
					'like',
					'%' . $keyword . '%'
			);
			$where ['_logic'] = 'or';
			$condition ['_complex'] = $where;
		}
		$count = $Template->where($condition)->count();		
		$Page = new\Think\Page($count,6);	
		$show = $Page->show();				
		$templateList = $Template->where($condition)->limit($Page->firstRow.','.$Page->listRows)->select();
		for($i=0;$i<count($templateList);$i++){
			$templateList[$i]['mw'] = passport_encrypt($templateList[$i]['template_id']);
		}	
		$mbx = array(
				'first_item'=>'内容管理',
				'url'=>'Template/index',
				'second_item'=>'模板管理',
		);
		$this->assign ( 'mbx', $mbx );
		$this->assign('page',$show);
		$this->assign ( 'keyword', $keyword );
		$this->assign('templateList',$templateList);
		$this->display();
	}
	/**
	 * 添加模板
	 */
	public function add() {
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$Template = D ('Template');		
		if (IS_POST){				
			if (!$Template->validate($Template->_validate)->create()){
					$this->error($Template->getError());
				} else {

					$logMsg = $Template->name;

					if ($Template->add()){

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了添加模板操作,添加的模板名称为 ' . $logMsg;
						$Log->write($this->admin['admin_id'],$content,1);


						$this->success('添加成功!',__APP__.'/Admin/Template/index');
					} else {
						$this->error('添加失败!',__APP__.'/Admin/Template/index');
					}
				}
		} else {		
			$mbx = array(
					'first_item'=>'内容管理',
					'url'=>'index',
					'second_item'=>'模板管理',
			);
			$this->assign ( 'mbx', $mbx );
			$this->display ();
		}
	}
	/**
	 * 修改模板
	 */
	public function edit(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$Template = D ('Template');
		if (IS_POST){
			$template_id = $_POST['template_id'];
			if (isset($template_id)){
				if (!$Template->validate($Template->_validate)->create()){
					$this->error($Template->getError());
				} else {

					$logMsg = $Template->name;

					if ($Template->save()){

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了编辑模板操作,编辑的模板名称为 ' . $logMsg;
						$Log->write($this->admin['admin_id'],$content,1);


						$this->success('修改成功!',__APP__.'/Admin/Template/index');
					} else {
						$this->error('修改失败!',__APP__.'/Admin/Template/index');
					}
				}
			}
		}else{
			if (isset($_GET['template_id'])){
				$template_id = $_GET['template_id'];
				$mw = $_GET['mw'];
				if($template_id !== passport_decrypt($mw)){
					$this->error ( '非法操作,错误代码1001！' );
				}else{
					if (($template = $Template->find($template_id)) == null){
						$this->error('该模板不存在!',__APP__.'/Admin/Template/index');
					}
					$this->assign('template',$template);
					$this->display();
				}
			}else{
				$this->error('非法访问!',__APP__.'/Admin/Template/index');
			}
		}
	}
	/**
	 * 删除摸板
	 */
	public function del(){
		$Template = D ('Template');
		if (isset($_GET['template_id'])){
			$template_id = $_GET['template_id'];
			$mw = $_GET['mw'];
			if($template_id !== passport_decrypt($mw)){
				$this->error ( '非法操作,错误代码1001！' );
			}else{
				if ($Template->find($template_id)){
					if ($Template->delete())

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了删除模板操作,删除的模板名称为 ' . $template_id;
						$Log->write($this->admin['admin_id'],$content,1);

						$this->success('删除成功!' , __APP__.'/Admin/Template/index');
					} else {
						$this->error('指定模板不存在!' , __APP__.'/Admin/Template/index');
					}
			}
		} else {
			$this->error('非法操作!' , __APP__.'/Admin/Template/index');
		}
	}
}