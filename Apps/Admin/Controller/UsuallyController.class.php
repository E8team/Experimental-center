<?php

namespace Admin\Controller;
use Think\Controller;

class UsuallyController extends BaseController {

	//权限验证
    public function __construct() {
        parent::__construct ();
        $this->checkPerm();
    }

	public function index(){
		$Menu = D ('Menu');
		$where['hidden'] = 0;
		$menuArr = $Menu->getMenuForJson($where);
		unset($where);
		$AdminMenu = M ("AdminMenu");
		$where['uid'] = $this->user['id'];
		$have = $AdminMenu->where($where)->select();
		//提取id合成一维数组
		$ids = array();
		foreach ($have as $v) {
			$ids[] = $v['mid'];
		}
		//处理权限数组选中状态
		foreach ($menuArr as $k=>$v) {
			if (in_array($v['id'],$ids)) {
				$menuArr[$k]['checked'] = "true";
			}
		}

		$menuJson = json_encode($menuArr);
		$this->assign('menuJson',$menuJson);
		$this->display();
	}

	//添加用户常用菜单
	public function add(){
		$idArr = explode(',',$_GET['data']);
		if (empty($idArr)) {
			$data['status'] = 0;
			$data['msg'] = "当前没有选择任何条目!";
			$this->ajaxReturn($data,'JSON');
		}

		$idNewArr = array();
		$Menu = M ('Menu');
		foreach ($idArr as $k=>$v){
			$where['parentid'] = $v;
			$where['status'] = 1;
			$where['hidden'] = 0;
			$menu = $Menu->where($where)->select();
			if (empty($menu))
				$idNewArr[] = $v;
		}

		unset($where);
		$AdminMenu = M("AdminMenu");
		//删除原来数据
		$where['uid'] = $this->user['id'];
		$AdminMenu->where($where)->delete();
		unset($where);
		$successnum = 0;
		//存入数据库
		foreach ($idNewArr as $v) {
			$where['id'] = $v;
			$where['status'] = 1;
			$where['hidden'] = 0;
			$menu = $Menu->where($where)->find();
			$d['mid'] = $v;
			$d['uid'] = $this->user['id'];
			$d['name'] = $menu['name'];
			$d['url'] = $menu['url'];
			$d['type'] = $menu['type'];
			if ($AdminMenu->data($d)->add()) $successnum++;
		}

		$data['status'] = 1;
		$data['msg'] = "共添加了".$successnum."条常用操作:)";

		//写入日志
		$Operationlog = D ('Operationlog');
		$info = "提示语：".$data['msg']." <br />模块：".MODULE_NAME.",控制器：".CONTROLLER_NAME.",方法：".ACTION_NAME." <br />请求方式：AJAX";
		$get = __SELF__;
		$Operationlog->write($this->user['id'],1,$info,$get);

		$this->ajaxReturn($data,'JSON');
	}
}