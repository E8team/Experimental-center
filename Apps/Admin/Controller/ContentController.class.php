<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 2014/7/9
 * @author webff
 * Sever App Template page Controller
 */
class ContentController extends BaseController{
	
	public function __construct() {
		parent::__construct ();
		$action = CONTROLLER_NAME . '/' . ACTION_NAME;
		//验证权限
		if (!in_array($action,$this->permission)) {
			$this->error("您没有权限操作当前模块");
		}
	}
	
	/**
	 * 获取文章列表
	 */
	public function index(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		// 接受参数
		$class_id = isset ( $_GET ['class_id'] ) ? $_GET ['class_id'] : 0;
		$this->assign ( 'class_id', $class_id );
		$sort_field = isset ( $_GET ['sort_field'] ) ? $_GET ['sort_field'] : '';
		$keywords = isset ( $_GET ['keywords'] ) ? $_GET ['keywords'] : '';
		$this->assign("keywords",$keywords); //关键字描红
			// 创建各个模型
			$classModel = D ( 'class' );
			$channelModel = D ( 'channel' );
			$attributeModel = D ( 'attribute' );
			$adminModel = D ( 'admin' );
			$contentModel = D ( 'content' );
			// 判断是否为所有文档、我发布的文档、待审核的文档等
			$manage_name = '文档回收站';
			$this->assign ( 'manage_name', $manage_name );
				
			// 获取栏目树
			$classListStr = $this->_getClassTree ( $class_id );
			$this->assign ( 'classListStr', $classListStr );
				
			// 获取我管理的栏目ID
			$my_class_id_list = $this->_getMyClassId ();
				
			// 获取我管理的栏目下拉列表，不包括外部链接栏目
			$classList = $this->_getMyClass ( $class_id, $my_class_id_list );
			$this->assign ( "classList", $classList );
				
			// 获取所有的文档属性
			$attrList = $attributeModel->select ();
			$this->assign ( 'attrList', $attrList );
				
			// 递归获取栏目下的所有文档，排除不在权限内的栏目
			import ( 'ORG.Util.Page' );
			$all_class_id_list = $classModel->getAllSubId ( $class_id );
			array_push ( $all_class_id_list, $class_id );
			$all_class_id_list = implode ( ",", $all_class_id_list );
			$my_class_id_list = $this->admin ['class_id'];
			if ($my_class_id_list != 0)
				$where = "class_id in ($all_class_id_list) and class_id in ($my_class_id_list)";
			else
				$where = "class_id in ($all_class_id_list)";
			// 拼接where、order
			$sort_field = isset ( $_GET ['sort_field'] ) ? $_GET ['sort_field'] : '';
			$where = $where . " and state = 'publish'";
			$where = $keywords == '' ? $where : $where . " and title like '%$keywords%'";
				
			$order = 'sort_index,uptime desc';
			$order = $sort_field == '' ? $order : $sort_field . " desc," . $order;
			$count = $contentModel->where ( $where )->count ();
			$page = new\Think\Page($count,9);
			$show = $page->show ();
			$limit = $page->firstRow . "," . $page->listRows;
			$contentList = $contentModel->getAllContent ( $where, $order, $limit );
				
			$this->assign ( 'page', $show );
			for($i=0;$i<count($contentList);$i++){
				$contentList[$i]['mw'] = passport_encrypt($contentList[$i]['content_id']);
			}
			//面包屑
			$mbx = array(
					'first_item'=>'内容管理',
					'url'=>'index',
					'second_item'=>'文章管理',
			);
			$this->assign ( 'mbx', $mbx );
			$this->assign ( 'contentList', $contentList );
			//$this->ajaxReturn($contentList,'JSON');
			$this->display();
	}

	 public function add() {
	 	//创建各个模型
		$Content = D ('Content');
		$Con_article = D('Con_article');
		$Channel = D ("Channel");
		$Class = D("Class");
		if (IS_POST){
			if (!$Content->validate($Content->_validate)->create()){
					$this->error($Content->getError());
				} else {
					//判断是否置顶
					if($_POST['is_stick'] == "on"){
						$Content->is_stick = 1;
					}else{
						$Content->is_stick = 0;
					}
					//获取频道ID
					$class_id = $_POST['class_id'];
					$channel_id = $Class->where(" class_id = $class_id ")->getField("channel_id");
					$Content->channel_id = $channel_id;
					//获取admin_id
					$Content->admin_id = $this->admin['admin_id'];
					//获取更新时间
					$Content->uptime = time();
					//写入添加时间
					$addtime = strtotime($_POST['addtime']);
					$addtime = date('Y-m-d', $addtime);
					$Content->addtime = $addtime;
					//写入置顶到期时间
					$sticky_time = strtotime($_POST['sticky_time']);
					$sticky_time = date('Y-m-d', $sticky_time);
					$Content->sticky_time = $sticky_time;
					$Content->state = 'publish';
					//上传图片
					if ($_FILES ['picurl'] ['name'] != "") {
						$fileInfo = $this->upload ( 'image', true );
						$Content->picurl = $fileInfo;
					}
					//日志记录中需要的数据
					$logMsg['title'] = $Content->title;
					$logMsg['id'] = $Content->content_id;

					if ($Content->add()){
						$content_id = mysql_insert_id();
						//写入附加表的数据
						if($Con_article->create()){
							$Con_article->content_id = $content_id;
							$Con_article->url = $_POST['url'];
							$Con_article->class_id = $_POST["class_id"];
							$Con_article->body = $_POST["content"];
						}
						$Con_article->add();

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了添加文章操作,添加的文章ID为 '. $logMsg['id'] . ',添加的文章标题为 ' . $logMsg['title'];
						$Log->write($this->admin['admin_id'],$content,1);

						$this->success('添加成功!',__APP__.'/Admin/Content/');
					} else {
						$this->error('添加失败!',__APP__.'/Admin/Content/add');
					}
				}
		} else {
			$class_id = isset ( $_GET ['class_id'] ) ? $_GET ['class_id'] : 0;
			$channel_id = isset ( $_GET ['channel_id'] ) ? $_GET ['channel_id'] : '';
			// 判断文档模型
			if ($channel_id == '') {
				if ($class_id == 0) {
					$channel_id = 1;
				} else {
					$classModel = D ( 'class' );
					$class = $classModel->where ( "class_id = $class_id" )->find ();
					$channel_id = $class ['channel_id'];
				}
			}	
			// 创建模型
			$Class = D ( 'Class' );
			// 获取栏目文档模型
			$channelModel = D ( 'channel' );
			$channel = $channelModel->where ( "channel_id = $channel_id" )->find ();
			$fields = $channel ['fields'];
			$this->assign ( 'channel', $channel );
			// 获取所有授权的该模型栏目
			$my_class_id_list = $this->_getMyClassId ();
			$where = "channel_id = $channel_id";
			$classList = $this->_getMyClass ( $class_id, $my_class_id_list, $where );
			//p($classList[35]);
			$this->assign ( "classList", $classList );
			
			//发布文章的时间默认是当前时间
			$date = date("m/d/y",time()); 
			$this->assign("date",$date);
			
			$this->display ();
		}
	}
 	
	/**
	 * 修改文章
	 */
	public function edit(){
		$Content = D ( 'Content' );
		$Con_article = D('Con_article');
		$Class = D("Class");
		if (IS_POST){
			$content_id = $_POST['content_id'];
			if (isset($content_id)){
				if (!$Content->validate($Content->_validate)->create()){
					$this->error($Content->getError());
				} else {
					//判断是否置顶
					if($_POST['is_stick'] == "on"){
						$Content->is_stick = 1;
					}else{
						$Content->is_stick = 0;
					}
					//获取admin_id
					$Content->admin_id = $this->admin['admin_id'];
					//获取更新时间
					$Content->uptime = time();
					//写入添加时间
					$time = strtotime($_POST['addtime']);
					$time = date('Y-m-d', $time);
					$Content->addtime = $time;
					//写入置顶到期时间
					$sticky_time = strtotime($_POST['sticky_time']);
					$sticky_time = date('Y-m-d', $sticky_time);
					$Content->sticky_time = $sticky_time;
					//上传图片
					if ($_FILES ['picurl'] ['name'] != "") {
						$fileInfo = $this->upload ( 'image', true );
						$Content->picurl = $fileInfo;
					}

					//日志记录中需要的数据
					$logMsg['title'] = $Content->title;
					$logMsg['id'] = $Content->content_id;

					if ($Content->save()){
						//修改附加表的数据
						if($Con_article->create()){
							$Con_article->url = $_POST['url'];
							$Con_article->class_id = $_POST["class_id"];
							$Con_article->body = $_POST["content"];
						}
						$Con_article->save();

						//写入日志
						$Log = D ('Log','Logic');
						$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了修改文章操作,修改的文章ID为 '. $logMsg['id'] . ',修改的文章标题为 ' . $logMsg['title'];
						$Log->write($this->admin['admin_id'],$content,1);

						$this->success('修改成功!',__APP__.'/Admin/Content/index');
					} else {
						$this->error('修改失败!',__APP__.'/Admin/Content/index');
					}
				}
			}
		}else{
			if (isset($_GET['content_id'])){
				$content_id = $_GET['content_id'];
				$mw = $_GET['mw'];
				if (($content = $Content->find($content_id)) == null){
					$this->error('该文章不存在!');
				}
				if($content_id !== passport_decrypt($mw)){
					$this->error ( '非法操作,错误代码1001！',__APP__.'/Admin/Content/index');
				}else{

					
					$this->assign('content',$content);

					// 获取文档模型信息
					$channelModel = D ( 'channel' );
					$channel_id = $content ['channel_id'];
					$channel = $channelModel->where ( "channel_id = $channel_id" )->find ();
					if ($channel == false)
						$this->error ( '文档模型错误！' );
					$this->assign ( 'channel', $channel );
					
					// 获取附加表信息
					$tableName = $channel ['addon_table'];
					$model = M ( $tableName );
					$modelCon = $model->where ( "content_id = $content_id" )->find ();
					$this->assign("modelCon",$modelCon);
					if ($modelCon == false){
						$this->error ( '附加表不存在该记录！' );
					}
					
					// 获取所有授权的该模型栏目
					$my_class_id_list = $this->_getMyClassId ();
					$where = "channel_id = $channel_id";
					$classList = $this->_getMyClass ( $content ['class_id'], $my_class_id_list, $where );
					$this->assign ( 'classList', $classList );
					
					$this->display();
				}
			}else{
				$this->error('非法访问!',__APP__.'/Admin/Content/index');
			}
		}
	}
	/**
	 * 审查文档
	 */
	public function check(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		// 接受参数
		$class_id = isset ( $_GET ['class_id'] ) ? $_GET ['class_id'] : 0;
		$this->assign ( 'class_id', $class_id );
		$sort_field = isset ( $_GET ['sort_field'] ) ? $_GET ['sort_field'] : '';
		$keywords = isset ( $_GET ['keywords'] ) ? $_GET ['keywords'] : '';
		$this->assign("keywords",$keywords); //关键字描红
		
		// 创建各个模型
		$classModel = D ( 'class' );
		$channelModel = D ( 'channel' );
		$attributeModel = D ( 'attribute' );
		$adminModel = D ( 'admin' );
		$contentModel = D ( 'content' );
		
		// 判断是否为所有文档、我发布的文档、待审核的文档等
		$manage_name = '文档回收站';
		$this->assign ( 'manage_name', $manage_name );
		
		// 获取栏目树
		$classListStr = $this->_getClassTree ( $class_id );
		$this->assign ( 'classListStr', $classListStr );
		
		// 获取我管理的栏目ID
		$my_class_id_list = $this->_getMyClassId ();
		
		// 获取我管理的栏目下拉列表，不包括外部链接栏目
		$classList = $this->_getMyClass ( $class_id, $my_class_id_list );
		$this->assign ( "classList", $classList );
		
		// 获取所有的文档属性
		$attrList = $attributeModel->select ();
		$this->assign ( 'attrList', $attrList );
		
		// 递归获取栏目下的所有文档，排除不在权限内的栏目
		import ( 'ORG.Util.Page' );
		$all_class_id_list = $classModel->getAllSubId ( $class_id );
		array_push ( $all_class_id_list, $class_id );
		$all_class_id_list = implode ( ",", $all_class_id_list );
		$my_class_id_list = $this->admin ['class_id'];
		if ($my_class_id_list != 0)
			$where = "class_id in ($all_class_id_list) and class_id in ($my_class_id_list)";
		else
			$where = "class_id in ($all_class_id_list)";
		// 拼接where、order
		$sort_field = isset ( $_GET ['sort_field'] ) ? $_GET ['sort_field'] : '';
		$where = $where . " and state = 'check'";
		$where = $keywords == '' ? $where : $where . " and title like '%$keywords%'";
		$order = 'sort_index,uptime desc';
		$order = $sort_field == '' ? $order : $sort_field . " desc," . $order;
		$count = $contentModel->where ( $where )->count ();
		$page = new \Think\Page($count,6);
		$show = $page->show ();
		$limit = $page->firstRow . "," . $page->listRows;
		$contentList = $contentModel->getAllContent ( $where, $order, $limit );
		$this->assign ( 'page', $show );
		for($i=0;$i<count($contentList);$i++){
			$contentList[$i]['mw'] = passport_encrypt($contentList[$i]['content_id']);
		}
		$this->assign ( 'contentList', $contentList );
		//面包屑
		$mbx = array(
				'first_item'=>'内容管理',
				'url'=>'',
				'second_item'=>'文章审核管理',
		);
		$this->assign ( 'mbx', $mbx );
		$this->assign('menu',$this->menu);
		$this->assign('admin',$this->admin);
		$this->assign('msgCount',count($this->msg));
		$this->assign('msg',$this->msg);
		$this->display ();
	}
	/**
	 * 还原文档
	 */
	public function restore() {
		$this->check_args ( 'get:content_id' );
		//获取ID 和 密文
		$content_id = $_GET ['content_id'];
		//将字符串转换为数组  取出单个复选框的ID+mw
		$arr1 = explode(",",$content_id);
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
		//将ID整合成contend_id
		$content_id = implode(',',$id);
		if($j>0){
			$this->error ( '非法操作,错误代码1001！');
		}else{
			$contentModel = D ( 'content' );
			$where = "content_id in ($content_id)";
			$contentModel->where ( $where )->setField ( 'state', 'publish' );

			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了还原文章操作,共还原了' . $j . '篇文章';
			$Log->write($this->admin['admin_id'],$content,1);

			$this->success ( '文档还原成功！' );
		}
	}
	/**
	 * 移到回收站
	 */
	public function remove() {
		$this->check_args ( 'get:content_id' );
		//获取ID 和 密文
		$content_id = $_GET ['content_id'];
		//将字符串转换为数组  取出单个复选框的ID+mw
		$arr1 = explode(",",$content_id);
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
		//将ID整合成contend_id
		$content_id = implode(',',$id);
		if($j>0){
			$this->error ( '非法操作,错误代码1001！' );
		}else{
			$contentModel = D ( 'content' );
			$where = "content_id in ($content_id)";
			$contentModel->where ( $where )->setField ( 'state', 'trash' );

			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了移动文章到回收站操作,共移动了' . $j . '篇文章';
			$Log->write($this->admin['admin_id'],$content,1);

			$this->success ( '文档移至回收站成功！' );
		}
	}
	/**
	 * 审核文档
	 */
	public function checkout() {
		$this->check_args ( 'get:content_id' );
		//获取ID 和 密文
		$content_id = $_GET ['content_id'];
		//将字符串转换为数组  取出单个复选框的ID+mw
		$arr1 = explode(",",$content_id);
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
		//将ID整合成contend_id
		$content_id = implode(',',$id);
		if($j>0){
			$this->error ( '非法操作,错误代码1001！');
		}else{
			$contentModel = D ( 'content' );
			$where = "content_id in ($content_id)";
			$contentModel->where ( $where )->setField ( 'state', 'publish' );

			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了审核文章操作,共审核了' . $j . '篇文章';
			$Log->write($this->admin['admin_id'],$content,1);

			$this->success ( '文档审核成功！' );
		}
	}
	/**
	 * 永久删除文档
	 */
	public function delete() {
		$this->check_args ( 'get:content_id' );
		//获取ID 和 密文
		$content_id = $_GET ['content_id'];
		//将字符串转换为数组  取出单个复选框的ID+mw
		$arr1 = explode(",",$content_id);
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
		//将ID整合成contend_id
		$content_id = implode(',',$id);
		if($j>0){
			$this->error ( '非法操作,错误代码1001！');
		}else{
			$content_id = explode ( ",", $content_id );
			$contentModel = D ( 'content' );
			$channelModel = D ( 'channel' );
			$number = 0;			
			foreach ( $content_id as $k=>$v){
				$content = $contentModel->where ( "content_id = $v")->find ();
				
				$contentModel->where ( $where )->delete ();
				// 删除附加表记录				
				if ($content != false) {
					$content_id = $content ['content_id'];
					$channel_id = $content ['channel_id'];
					$channel = $channelModel->where ( "channel_id = $channel_id" )->find ();
					$tableName = $channel ['addon_table'];
					$model = M ( $tableName );
					$model->where ( $where )->delete (); 
					$number++;
				}		
				
			}

			//写入日志
			$Log = D ('Log','Logic');
			$content = $this->admin['account'] . '('. $this->admin['name'] . ') 执行了永久删除文章操作,共删除了' . $number . '篇文章';
			$Log->write($this->admin['admin_id'],$content,1);

			$this->success ( '成功删除' . $number . '个文档！' );
		}
	}
	/**
	 * 文档回收站
	 */
	public function recycle(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		// 接受参数
		$class_id = isset ( $_GET ['class_id'] ) ? $_GET ['class_id'] : 0;
		$this->assign ( 'class_id', $class_id );
		$sort_field = isset ( $_GET ['sort_field'] ) ? $_GET ['sort_field'] : '';
		$keywords = isset ( $_GET ['keywords'] ) ? $_GET ['keywords'] : '';
		$this->assign("keywords",$keywords); //关键字描红
		
		// 创建各个模型
		$classModel = D ( 'class' );
		$channelModel = D ( 'channel' );
		$attributeModel = D ( 'attribute' );
		$adminModel = D ( 'admin' );
		$contentModel = D ( 'content' );
		
		// 判断是否为所有文档、我发布的文档、待审核的文档等
		$manage_name = '文档回收站';
		$this->assign ( 'manage_name', $manage_name );
		
		// 获取栏目树
		$classListStr = $this->_getClassTree ( $class_id );
		$this->assign ( 'classListStr', $classListStr );
		
		// 获取我管理的栏目ID
		$my_class_id_list = $this->_getMyClassId ();
		
		// 获取我管理的栏目下拉列表，不包括外部链接栏目
		$classList = $this->_getMyClass ( $class_id, $my_class_id_list );
		$this->assign ( "classList", $classList );
		
		// 获取所有的文档属性
		$attrList = $attributeModel->select ();
		$this->assign ( 'attrList', $attrList );
		
		// 递归获取栏目下的所有文档，排除不在权限内的栏目
		import ( 'ORG.Util.Page' );
		$all_class_id_list = $classModel->getAllSubId ( $class_id );
		array_push ( $all_class_id_list, $class_id );
		$all_class_id_list = implode ( ",", $all_class_id_list );
		$my_class_id_list = $this->admin ['class_id'];
		if ($my_class_id_list != 0)
			$where = "class_id in ($all_class_id_list) and class_id in ($my_class_id_list)";
		else
			$where = "class_id in ($all_class_id_list)";
			// 拼接where、order
		$sort_field = isset ( $_GET ['sort_field'] ) ? $_GET ['sort_field'] : '';
		$where = $where . " and state = 'trash'";
		$where = $keywords == '' ? $where : $where . " and title like '%$keywords%'";
		$where = $attr_key == '' ? $where : $where . " and attribute like '%$attr_key%'";
		$order = 'sort_index,uptime desc';
		$order = $sort_field == '' ? $order : $sort_field . " desc," . $order;
		$count = $contentModel->where ( $where )->count ();
		$page = new\Think\Page($count,6);
		$show = $page->show ();
		$limit = $page->firstRow . "," . $page->listRows;
		$contentList = $contentModel->getAllContent ( $where, $order, $limit );
		$this->assign ( 'page', $show );
		for($i=0;$i<count($contentList);$i++){
			$contentList[$i]['mw'] = passport_encrypt($contentList[$i]['content_id']);
		}
		//面包屑
		$mbx = array(
				'first_item'=>'内容管理',
				'url'=>__APP__.'/Admin/Content/recycle',
				'second_item'=>'文档回收站',
		);
		
		$this->assign ( 'mbx', $mbx );
		$this->assign ( 'contentList', $contentList );
		
		$this->assign('menu',$this->menu);
		$this->assign('admin',$this->admin);
		$this->assign('msgCount',count($this->msg));
		$this->assign('msg',$this->msg);
		$this->display ();
	}
	
	/**
	 * 获取栏目树
	 *
	 * @param unknown $class_id
	 * @return string
	 */
	private function _getClassTree($class_id, $where = '') {
		$classModel = D ( 'class' );
		// 获取栏目树
		$classList = $classModel->getClassTree ( $class_id, $where );
		$classListStr = '<a href="' . __APP__ . '/content' . '">所有栏目</a>';
		for($i = count ( $classList ) - 1; $i >= 0; $i --) {
			$classListStr .= ' >> <a href="' . __APP__ . '/content/index/class_id/' . $classList [$i] ['class_id'] . '">' . $classList [$i] ['name'] . '</a>';
		}
		return $classListStr;
	}
	
	/**
	 * 获取我的栏目下拉列表
	 *
	 * @param unknown $class_id
	 * @param unknown $class_id_list
	 * @return string
	 */
	private function _getMyClass($class_id, $class_id_list, $where = '1=1') {
		$classModel = D ( 'class' );
		if ($class_id_list != 0)
			$where = "type <> 'url' and class_id in ($class_id_list) and " . $where;
		else
			$where = "type <> 'url' and " . $where;
		$classList = $classModel->getAllClass ( 0, 0, $where );
		for($i = 0; $i < count ( $classList ); $i ++) {
			$deep = $classList [$i] ['deep'];
			$classList [$i] ['prefix'] = str_repeat ( "&nbsp&nbsp", $deep ) . "|-";
			// 如果是当前栏目
			if ($classList [$i] ['class_id'] == $class_id) {
				$classList [$i] ['select'] = 'selected="selected"';
			}
		}

		return $classList;
	}
	
	/**
	 * 获取我的栏目ID
	 *
	 * @return string number
	 */
	private function _getMyClassId() {
		$classModel = D ( 'class' );
		$class_id = $this->admin ['class_id'];
		if ($class_id != 0) {
			$class_id = explode ( ",", $class_id );
			$class_id_list = $classModel->getAllFatherId ( $class_id );
			return implode ( ",", $class_id_list );
		} else {
			return 0;
		}
	}
	/**
	 * 获取从下往上获取栏目树
	 *
	 * @param unknown $class_id
	 */
	public function getClassTree($class_id, $where = "") {
		static $classList = array ();
		if ($class_id == 0)
			return;
		$nowwhere = $where == "" ? "class_id = $class_id" : "class_id = $class_id and " . $where;
		$class = $this->where ( $nowwhere )->find ();
		if ($class != false) {
			array_push ( $classList, $class );
			$this->getClassTree ( $class ['father_id'] );
		}
		return $classList;
	}
	/**
	 * 检测是否传递了参数，如果没传，则报错！
	 */
	public function check_args() {
		// 获取传来的参数
		$args = func_get_args ();
		$errMsg = '';
		for($i = 0; $i < count ( $args ); $i ++) {
			// 分解参数为（传递方式：参数名称）
			$field = explode ( ":", $args [$i] );
			// GET方式判断
			if (strtolower ( $field [0] ) == 'get') {
				if (! isset ( $_GET [$field [1]] )) {
					$errMsg .= $field [1];
				}
				// POST方式判断
			} else if (strtolower ( $field [0] ) == 'post') {
				if (! isset ( $_POST [$field [1]] )) {
					$errMsg .= $field [1];
				}
				// GET、POST方式同时判断
			} else if (strtolower ( $field [0] ) == 'all') {
				if (! isset ( $_POST [$field [1]] ) && ! isset ( $_GET [$field [1]] )) {
					$errMsg .= $field [1];
				}
			}
		}
		if ($errMsg != '') {
			$this->error ( '缺少参数：' . $errMsg );
		}
	}
}