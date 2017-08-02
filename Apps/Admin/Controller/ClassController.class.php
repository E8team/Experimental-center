<?php
namespace Admin\Controller;
/**
 * 2014/7/9
 * @author baochao
 * Sever App class page Controller
 */
class ClassController extends BaseController{
	
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
	/**
	 * 列出栏目信息
	 */
	public function index(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		//实例化模型
		$Class = D ('Class','Logic');
		$Content = D ("Content");
		// 获取父级ID
		$father_id = isset ( $_GET ['father_id'] ) ? $_GET ['father_id'] : 0;
		if($father_id == 0){
			$condition['father_id'] = 0;
		}else{
			$condition['father_id'] = $father_id;
		}
		//获取下级栏目的url地址
		$this->assign ( 'father_id', $father_id ); 
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
		$count = $Class->where ( $condition )->count ();
		$page = new \Think\Page($count,8);
		$show = $page->show ();
		$limit = $page->firstRow . "," . $page->listRows;
		$classList = $Class->where ( $condition )->order ( "sort_index" )->limit ( $limit )->select ();
		$this->assign ( 'page', $show);
		
		for($i = 0; $i < count ( $classList ); $i ++) {
			$classList[$i]['mw'] = passport_encrypt($classList[$i]['class_id']);
			// 判断栏目类型
			switch ($classList [$i] ['type']) {
				case 'list' :
					$classList [$i] ['type_name'] = '列表栏目';
					// 获取文档数量
					$Content = D ( 'Content' );
					$class_id = $classList [$i] ['class_id'];
					$count = $Content->where ( "class_id = $class_id and state <> 'trash'" )->count ();
					$classList [$i] ['name'] .= '（文档：' . $count . '）';
					break;
				case 'index' :
					$classList [$i] ['type_name'] = '频道封面';
					break;
				case 'url' :
					$classList [$i] ['type_name'] = '外部链接';
					break;
			}
			
			// 获取内容模型
			$Channel = D ( 'Channel' );
			$channel_id = $classList [$i] ['channel_id'];
			$channel = $Channel->where ( "channel_id = $channel_id" )->field ( 'name' )->find ();
			$classList [$i] ['channel_name'] = $channel ['name'];
				
			// 获取模板文件
			$template_id = $classList [$i] ['index_template'];
			$Template = D ( 'Template' );
			$template = $Template->where ( "template_id = $template_id" )->find ();
			$url = $classList [$i] ['url'];
			$classList [$i] ['url'] = $url == "" ? __ROOT__ . "/" . $template ['url'] . "/" .$classList[$i]['class_id'] . ".html" : $url;
		}
		
		//面包屑
		$mbx = array(
				'first_item'=>'内容管理',
				'url'=>'Class/index',
				'second_item'=>'栏目管理',
		);
		
		$this->assign("classList",$classList);
		$this->assign('mbx',$mbx);
		$this->assign('keyword',$keyword);
		$this->display();
	}
	/**
	 * 添加栏目
	 */
	public function add() {
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$Class = D ( 'Class' ); //建立模型
		if (IS_POST){		
			$father_id = $_POST ['father_id'];	//获取隐藏域的值
			$content = $_POST ['content'];
			if (!$Class->validate($Class->_validate)->create()){  //自动验证
				$this->error($Class->getError());
			} else {
				if($_POST['is_show'] == "on"){
					$Class->is_show = 1;
				}else{
					$Class->is_show = 0;
				}
				if($_POST['is_nav'] == "on"){
					$Class->is_nav = 1;
				}else{
					$Class->is_nav = 0;
				}
				$Class->content = html_entity_decode($content);
				$logMsg['name'] = $Class->name;
				$logMsg['id'] = $Class->class_id;
				if ($Class->add()){

					//写入日志
					$Log = D ('Log','Logic');
					$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了添加栏目操作,添加的栏目名称为 '. $logMsg['name'] . ',栏目ID为' . $logMsg['id'];
					$Log->write($this->admin['admin_id'],$content,1);

					$this->success('添加成功!',__APP__.'/Admin/Class/index/father_id/'.$father_id);
				} else {
					$this->error('添加失败!',__APP__.'/Admin/Class/index/father_id/'.$father_id);
				}
			}
		} else {
			// 获取父级ID
			$father_id = isset ( $_GET ['father_id'] ) ? $_GET ['father_id'] : 0;
			$this->assign ( 'father_id', $father_id );
			
			// 获取内容模型
			$Channel = D ( 'Channel' );
			$channelList = $Channel->where ( "is_open = 1" )->select ();
			$this->assign ( 'channelList', $channelList );
			
			// 获取栏目模板
			$Template = D ( 'Template' );
			$indexTemplateList = $Template->where ( "type = 'index'" )->select ();
			$this->assign ( 'indexTemplateList', $indexTemplateList );
			$contentTemplateList = $Template->where ( "type = 'content'" )->select ();
			$this->assign ( 'contentTemplateList', $contentTemplateList );
			
			$this->display ();
		}
	}
	/**
	 * 修改栏目
	 */
	public function edit(){
		$Class = D ( 'Class' );
		$Channel = D('Channel');
		$Assign = A ( 'Assign' );
		$Assign->index ();
		if (IS_POST){
			$class_id = $_POST['class_id'];
			$content = $_POST['content'];
			$father_id = $Class->where("class_id = $class_id")->getField('father_id');
			if (isset($class_id)){
				if (!$Class->validate($Class->_validate)->create()){
					$this->error($Class->getError());
				} else {
					if($_POST['is_show'] == "on"){
						$Class->is_show = 1;
					}else{
						$Class->is_show = 0;
					}
					if($_POST['is_nav'] == "on"){
						$Class->is_nav = 1;
					}else{
						$Class->is_nav = 0;
					}
					$Class->content = html_entity_decode($content);
					$logMsg['name'] = $Class->name;
					$logMsg['id'] = $Class->class_id;
					if ($Class->save()){

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了修改栏目操作,修改的栏目名称为 '. $logMsg['name'] . ',栏目ID为' . $logMsg['id'];
						$Log->write($this->admin['admin_id'],$content,1);

						$this->success('修改成功!',__APP__.'/Admin/Class/index/father_id/'.$father_id);
					} else {
						$this->error('修改失败!',__APP__.'/Admin/Class/index/father_id/'.$father_id);
					}
				}
			}
		}else{
			if (isset($_GET['class_id'])){
				$class_id = $_GET['class_id'];
				$mw = $_GET['mw'];
				if($class_id !== passport_decrypt($mw)){
					$this->error ( '非法操作,错误代码1001！' );
				}else{
					
					// 获取内容模型
					$Channel = D ( 'Channel' );
					$class = $Class->find($class_id);
					$channelList = $Channel->where ( "is_open = 1" )->select ();
					// 判断该栏目的内容模型
					for($i = 0; $i < count ( $channelList ); $i ++) {
						if ($channelList [$i] ['channel_id'] == $class ['channel_id'])
							$channelList [$i] ['select'] = 'selected = "selected"';
					}
					$this->assign("channelList",$channelList);
					
					// 获取栏目模板
					$templateModel = D ( 'template' );
					$indexTemplateList = $templateModel->where ( "type = 'index'" )->select ();
					// 判断该栏目的封面模板
					for($i = 0; $i < count ( $indexTemplateList ); $i ++) {
						if ($indexTemplateList [$i] ['template_id'] == $class ['index_template'])
							$indexTemplateList [$i] ['select'] = 'selected = "selected"';
					}
					$this->assign ( 'indexTemplateList', $indexTemplateList );
					
					// 判断该栏目的内容模板
					$contentTemplateList = $templateModel->where ( "type = 'content'" )->select ();
					
					for($i = 0; $i < count ( $contentTemplateList ); $i ++) {
						if ($contentTemplateList [$i] ['template_id'] == $class ['content_template'])
							$contentTemplateList [$i] ['select'] = 'selected = "selected"';
					}
					$this->assign ( 'contentTemplateList', $contentTemplateList );
					$this->assign('channel_id',$channel_id);
					$this->assign('class',$class);
					$this->display();
				}
			}else{
				$this->error('非法访问!',__APP__.'/Admin/Class/index');
			}
		}
	}
	/**
	 * 删除栏目
	 */
	public function del(){
		$Class = D ('Class');
		if (isset($_GET['class_id'])){
			$class_id = $_GET['class_id'];
			$mw = $_GET['mw'];
			if($class_id !== passport_decrypt($mw)){
				$this->error ( '非法操作,错误代码1001！' );
			}else{
				if ($Class->find($class_id)){
					if ($Class->delete())
						// 调用递归删除栏目
						$Class->deleteClass ( $class_id );
						// 清理栏目下的内容
						$Class = D ( 'content' );
						$Class->clearClass ();

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了删除栏目操作,删除的栏目ID为 '. $class_id;
						$Log->write($this->admin['admin_id'],$content,1);

						$this->success ( '删除成功！' );
				} else {
					$this->error('指定栏目不存在!' , __APP__.'/Admin/Class/index');
				}
			}
		} else {
			$this->error('非法操作!' , __APP__.'/Admin/Class/index');
		}
		}
	/**
	 * 栏目结构图
	 */
	public function tree() {
		$Assign = A ( 'Assign' );
		$Assign->index ();
		// 创建模型
		$Class = D ( 'Class' );
		// 获取所有栏目
		$classList = $Class->getAllClass ( 0 );
		for($i = 0; $i < count ( $classList ); $i ++) {
			$deep = $classList [$i] ['deep'];
			$classList [$i] ['prefix'] = str_repeat ( "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp", $deep ) . "|-";
			// 判断栏目类型
			switch ($classList [$i] ['type']) {
				case 'list' :
					$classList [$i] ['type_name'] = '列表栏目';
					$classList [$i] ['manage_url'] = __APP__ . '/Admin/Class/index/father_id/' . $classList [$i] ['class_id'];
					// 获取文档数量
					$Content = D ( 'Content' );
					$class_id = $classList [$i] ['class_id'];
					$count = $Content->where ( "class_id = $class_id" )->count ();
					$classList [$i] ['name'] .= '（文档：' . $count . '）';
					break;
				case 'index' :
					$classList [$i] ['type_name'] = '频道封面';
					$classList [$i] ['manage_url'] = __APP__ . '/Admin/Class/index/father_id/' . $classList [$i] ['class_id'];
					break;
				case 'url' :
					$classList [$i] ['type_name'] = '外部链接';
					$classList [$i] ['manage_url'] = __APP__ . '/Admin/Class/index/father_id/' . $classList [$i] ['class_id'];
					break;
			}
		}
		$this->assign ( "classList", $classList );
		$this->display ();
	}
	/**
	 * 移动栏目
	 */
	public function move() {
		$Assign = A ( 'Assign' );
		$Assign->index ();
		// 创建模型
		$Class = D ( 'Class' );
		if (IS_POST) {
			if (! isset ( $_POST ['class_id'] ) || ! isset ( $_POST ['father_id'] ))
				$this->error ( '操作错误！' );
			$class_id = $_POST ['class_id'];
			$class = $Class->where ( "class_id = $class_id" )->find ();
			if ($class == false)
				$this->error ( '当前目录不存在！' );
			$classname = $class ['name'];
			$father_id = $_POST ['father_id'];
			if ($class_id == $father_id)
				$this->error ( '移动栏目和目标栏目相同！' );
			if ($Class->isSubClass ( $father_id, $class_id ))
				$this->error ( '不能向子栏目下移动！' );
			if (! $Class->chk_class_purview ( $father_id ) || ! $Class->chk_class_purview ( $class_id ))
				$this->error ( '您没有权限移动到该栏目下！' );
			$Class->where ( "class_id = $class_id" )->setField ( 'father_id', $father_id );
			
			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了移动栏目操作,移动的栏目ID为 '. $class_id . ',移动到的栏目ID为' . $father_id;
			$Log->write($this->admin['admin_id'],$content,1);

			$jumpUrl = __APP__ . "/Admin/Class/index/father_id/" . $father_id;
			$this->success ( '移动成功！', $jumpUrl );
		} else {
			if (! isset ( $_GET ['class_id'] ))
				$this->error ( '操作错误！' );
			$class_id = $_GET ['class_id'];
			$mw = $_GET['mw'];
			if($class_id !== passport_decrypt($mw)){
				$this->error ( '非法操作,错误代码1001！' );
			}else{
				if (! $Class->chk_class_purview ( $class_id ))
					$this->error ( '您没有权限移动该栏目！' );
				$class = $Class->where ( "class_id = $class_id" )->find ();
				if ($class == false)
					$this->error ( '不存在该栏目！' );
				$this->assign ( 'class', $class );
				$father_id = $class ['father_id'];
				
				// 获取栏目树
				$where = "class_id in ($this->admin['class_id])";
				$classList = $Class->getClassTree ( $father_id, $where );
				$classListStr = '<a href="' . __APP__ . '/class' . '">顶级栏目</a>';
				for($i = count ( $classList ) - 1; $i >= 0; $i --) {
					$classListStr .= ' >> <a href="' . __APP__ . '/Admin/Class/index/father_id/' . $classList [$i] ['class_id'] . '">' . $classList [$i] ['name'] . '</a>';
				}
				$this->assign ( 'classListStr', $classListStr );
				
				// 获取所有栏目
				$classList = $Class->getAllClass ( 0 );
				for($i = 0; $i < count ( $classList ); $i ++) {
					$deep = $classList [$i] ['deep'];
					$classList [$i] ['prefix'] = str_repeat ( "&nbsp&nbsp", $deep ) . "|-";
				}
				$this->assign ( "classList", $classList );
				$this->display ();
			}
		}
	}
}