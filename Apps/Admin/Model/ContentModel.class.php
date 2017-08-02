<?php
namespace Admin\Model;
use Think\Model;

class ContentModel extends Model {
	protected $_validate = array (
			array (
					'title',
					'require',
					'标题不能为空！',
					1 
			),
			array (
					'class_id',
					'require',
					'栏目未选择！',
					1 
			),
			array (
					'addtime',
					'require',
					'发布时间不能为空！',
					1 
			),
			array (
					'sort_index',
					'require',
					'文档排序不能为空！',
					1 
			)
	);
	
	/**
	 * 清理栏目不存在的内容
	 *
	 * @param unknown $class_id        	
	 */
	public function clearClass() {
		// 清除主表文档
		$classModel = D ( 'class' );
		$classTable = $classModel->getTableName ();
		$sql = "delete from __TABLE__ where class_id NOT IN (select class_id from $classTable )";
		$this->execute ( $sql );
		
		// 清楚附加表文档
		$channelModel = D ( 'channel' );
		$channelList = $channelModel->select ();
		for($i = 0; $i < count ( $channelList ); $i ++) {
			$model = M ( $channelList [$i] ['addon_table'] );
			$tableName = $model->getTableName ();
			$sql = "delete from $tableName where class_id NOT IN (select class_id from $classTable )";
			$this->execute ( $sql );
		}
	}
	
	/**
	 * 获取栏目下的所有文档
	 *
	 * @param unknown $class_id        	
	 */
	public function getAllContent($where = '', $order = '', $limit = '') {
		static $contentList = array ();
		$classModel = D ( 'class' );
		$adminModel = D ( 'admin' );
		$channelModel = D ( 'channel' );
		// 获取栏目下的文档
		$result = $this->where ( $where )->order ( $order )->limit ( $limit )->select ();
		for($i = 0; $i < count ( $result ); $i ++) {
			// 改变时间格式
			$result [$i] ['addtime'] = date ( "Y-m-d", $result [$i] ['addtime'] );
			$result [$i] ['uptime'] = date ( "Y-m-d", $result [$i] ['uptime'] );
			// 获取栏目名称
			$class_id = $result [$i] ['class_id'];
			$class = $classModel->where ( "class_id = $class_id" )->find ();
			$result [$i] ['class_name'] = $class ['name'];
			$template_id = $class ['content_template'];
			// 更改状态信息
			switch ($result [$i] ['state']) {
				case 'publish' :
					$result [$i] ['state'] = '已发布';
					break;
				case 'trash' :
					$result [$i] ['state'] = '已删除';
					break;
				case 'check' :
					$result [$i] ['state'] = '待审核';
					break;
			}
			// 获取文档编辑器
			$channel_id = $class ['channel_id'];
			$channel = $channelModel->where ( "channel_id = $channel_id" )->find ();
			$result [$i] ['edit_action'] = $channel ['edit_action'] == '' ? 'content/edit' : $channel ['edit_action'];
			
			// 获取文档发布者
			$admin_id = $result [$i] ['admin_id'];
			$admin = $adminModel->where ( "admin_id = $admin_id" )->find ();
			$result [$i] ['admin'] = $admin ['name'] . "（" . $admin ['account'] . "）";
			
			// 获取模版信息
			$templateModel = D ( 'template' );
			$template = $templateModel->where ( "template_id = $template_id" )->find ();
			$result [$i] ['url'] = __ROOT__ . "/" . $template ['url'] . "/" . $result[$i]['content_id'] . ".html";
			
			array_push ( $contentList, $result [$i] );
		}
		
		return $contentList;
	}
}

?>