<?php 
namespace Admin\Controller;
/**
 * 2014/7/9
 * @author webff
 * Sever App Flink page Controller
 */
class FlinkController extends BaseController{
	/**
	 * 列出友链信息
	 */
		public function index(){
			$Assign = A ( 'Assign' );
			$Assign->index ();
			$Flink = D ('Flink','Logic');
			$type_id = $_GET['type_id'];
			$this->assign('type_id',$type_id);
			$mw = $_GET['mw'];
			$this->assign('mw',$mw);
			if ($type_id !== passport_decrypt($mw)) {
				$this->error ( '非法操作,错误代码1001！' );
			}else{
				$where="type_id  = $type_id ";
				$this->assign ( 'type_id', $type_id );
				$count = $Flink->where($where)->count();
				$Page = new \Think\Page($count,8);
				$show = $Page->show();
				$flinkList = $Flink->where($where)->order(" sort_index ")->limit($Page->firstRow.','.$Page->listRows)->select();
				$this->assign('page',$show);
				for($i=0;$i<count($flinkList);$i++){
					$flinkList[$i]['mw'] = passport_encrypt($flinkList[$i]['flink_id']);
				}
				$this->assign('flinkList',$flinkList);
				$this->display();
			}
		}
		/**
		 * 添加友情链接
		 */
		public function add() {
			$Flink = D ( 'Flink' );
			$Assign = A ( 'Assign' );
			$Assign->index ();
			if (IS_POST){
				$type_id = $_POST ['type_id'];
				$mw = passport_encrypt($type_id);
				if (!$Flink->validate($Flink->_validate)->create()){
					$this->error($Flink->getError());
				} else {
					$Flink->addtime = time ();
					$Flink->type_id = $type_id;
					//上传图片
					if ($_FILES ['logo'] ['name'] != "") {
						$fileInfo = $this->upload ( 'image', true );
						$Flink->logo = $fileInfo;
					}
					if ($Flink->add()){
						$this->success('添加成功!',__APP__.'/Admin/Flink/index/type_id/'.$type_id.'/mw/'.$mw);
					} else {
						$this->error('添加失败!',__APP__.'/Admin/Flink/index/type_id/'.$type_id.'/mw/'.$mw);
					}
				}
			} else {
				$type_id = $_GET ['type_id'];
				$mw = $_GET['mw'];
				if ($type_id !== passport_decrypt($mw)) {
					$this->error ( '非法操作,错误代码1001！' );
				}else{
					$this->assign ( 'type_id', $type_id );
					$this->display ();
				}
			}
		}
	/**
	 * 修改友链链接
	 */
	public function edit(){
		$Flink = D ( 'Flink' );
		$Assign = A ( 'Assign' );
		$Assign->index ();
		if (IS_POST){
			$flink_id = $_POST['flink_id'];
			$type_id = $Flink->where("flink_id = $flink_id")->getField('type_id');
			$mw = passport_encrypt($type_id);
			if (isset($flink_id)){
				if (!$Flink->validate($Flink->_validate)->create()){
					$this->error($Flink->getError());
				} else {
					//上传图片
					if ($_FILES ['logo'] ['name'] != "") {
						$fileInfo = $this->upload ( 'image', true );
						$Flink->logo = $fileInfo;
					}
                    $Flink->addtime = time ();
					if ($Flink->save()){
						$this->success('修改成功!',__APP__.'/Admin/Flink/index/type_id/'.$type_id.'/mw/'.$mw);
					} else {
						$this->error('修改失败!',__APP__.'/Admin/Flink/index/type_id/'.$type_id.'/mw/'.$mw);
					}
				}
			}
		}else{
			if (isset($_GET['flink_id'])){
				$flink_id = $_GET['flink_id'];
				$mw = $_GET['mw'];
				if($flink_id !== passport_decrypt($mw)){
					$this->error ( '非法操作,错误代码1001！' );
				}else{
					$type_id = $Flink->where("flink_id = $flink_id")->getField('type_id');
					$flink = $Flink->find($flink_id);
					$this->assign('flink',$flink);
					$this->display();
				}
			}else{
				$this->error('非法访问!');
			}
		}
	}
	/**
	 * 删除友情链接
	 */
	public function del(){
		$Flink = D ('Flink');
		if (isset($_GET['flink_id'])){
			$flink_id = $_GET['flink_id'];
			$mw = $_GET['mw'];
			if($flink_id !== passport_decrypt($mw)){
				$this->error ( '非法操作,错误代码1001！' );
			}else{
				if ($Flink->find($flink_id)){
					$type_id = $Flink->where("flink_id = $flink_id")->getField('type_id');
					$mw = passport_encrypt($type_id);
					if ($Flink->delete())
						$this->success('删除成功!' , __APP__.'/Admin/Flink/index/type_id/'.$type_id."/mw/".$mw);
				} else {
					$this->error('指定友链不存在!');
				}
			}
		} else {
			$this->error('非法操作!');
		}
	}
}