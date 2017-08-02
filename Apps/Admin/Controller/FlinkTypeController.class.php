<?php
namespace Admin\Controller;
/**
 * 2014/7/9
 * @author webff
 * Sever App FlinkType page Controller
 */

class FlinkTypeController extends BaseController{
	/**
	 * 获取友链分组信息
	 */
	public function index(){
		$Assign = A ( 'Assign' );
		$Assign->index ();
		$FlinkType = D ('Flink_type','Logic');
		$Flink = D ('Flink');
		$count = $FlinkType->count();
		$Page = new\Think\Page($count,8);
		$show = $Page->show();
		$flinktypeList = $FlinkType->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('page',$show);
		for($i=0;$i<count($flinktypeList);$i++){
			$type_id = $flinktypeList[$i]['type_id'];
			$flinktypeList[$i]['mw'] = passport_encrypt($type_id);
			$flinktypeList[$i]['count'] = $Flink->where("type_id = $type_id")->count();
		}
		$this->assign('flinktypeList',$flinktypeList);
		$this->display();
	}

	/**
	 * 添加友链分组
	 */
	public function add() {
		$FlinkType = D ('FlinkType');
		$Assign = A ( 'Assign' );
		$Assign->index ();
		if (IS_POST){
			if (!$FlinkType->validate($FlinkType->_validate)->create()){
				$this->error($FlinkType->getError(),__APP__.'/Admin/FlinkType/index');
			} else {
				if ($FlinkType->add()){
					$this->success('添加成功!',__APP__.'/Admin/FlinkType/index');
				} else {
					$this->error('添加失败!',__APP__.'/Admin/FlinkType/index');
				}
			}
		} else {
			$this->display ();
		}
	}
	/**
	 * 修改友链分组
	 */
	public function edit(){
		$FlinkType = D ('FlinkType');
		$Assign = A ( 'Assign' );
		$Assign->index ();
		if (IS_POST){
			$type_id = $_POST['type_id'];
			if (isset($type_id)){
				if (!$FlinkType->validate($FlinkType->_validate)->create()){
					$this->error($FlinkType->getError(),__APP__.'/Admin/FlinkType/edit/type_id/'.$type_id);
				} else {
					if ($FlinkType->save()){
						$this->success('修改成功!',__APP__.'/Admin/FlinkType/index');
					} else {
						$this->error('修改失败!',__APP__.'/Admin/FlinkType/index');
					}
				}
			}
		}else{
			if (isset($_GET['type_id'])){
				$type_id = $_GET['type_id'];
				$mw = $_GET['mw'];
				if($type_id !== passport_decrypt($mw)){ 
					$this->error ( '非法操作,错误代码1001！' );
				}else{
					if (($flinktype = $FlinkType->find($type_id)) == null){
						$this->error('该友链分组不存在!',__APP__.'/Admin/FlinkType/index');
					}
					$this->assign('flinktype',$flinktype);
					$this->display();
				}
			}else{
				$this->error('非法访问!',__APP__.'/Admin/FlinkType/index');
			}
		}
	}
	/**
	 * 删除友联分组
	 */
	public function del(){
		$FlinkType = D ('FlinkType');
		if (isset($_GET['type_id'])){
			$type_id = $_GET['type_id'];
			$mw = $_GET['mw'];
			if($type_id !== passport_decrypt($mw)){
				$this->error ( '非法操作,错误代码1001！' );
			}else{
				if ($FlinkType->find($type_id)){
					if ($FlinkType->delete())
						$Flink = D ( 'Flink' );
						$Flink->where ( 'type_id = ' . $type_id )->delete ();
						$this->success('删除成功!' , __APP__.'/Admin/FlinkType/index');
				} else {
					$this->error('指定项目不存在!' , __APP__.'/Admin/FlinkType/index');
				}
			}
		} else {
			$this->error('非法操作!' , __APP__.'/Admin/FlinkType/index');
		}
		}

}
