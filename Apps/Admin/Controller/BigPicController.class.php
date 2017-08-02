<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 2014/7/9
 * @author webff
 * Sever App Template page Controller
 */
class BigPicController extends BaseController{
	
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
        $bigPic = M('big_pic');
        $pics = $bigPic->order('sort_index asc, addtime desc')->select();
        $this->assign('pics', $pics);
		$this->display();
	}

	 public function add(){
         $Assign = A ( 'Assign' );
         $Assign->index ();
         $bigPic = M ( 'big_pic' );
         if (IS_POST){
             $bigPic->title = I('title', null);
             $bigPic->describtion = I('describtion', null);
             $bigPic->url = I('url', null);
             $bigPic->addtime = time ();
             //上传图片
             if ($_FILES ['logo'] ['name'] != "") {
                 $fileInfo = $this->upload ( 'image', true );
                 $bigPic->logo = $fileInfo;
             }else{
                 return $this->error('请上传图片!',__APP__.'/Admin/BigPic/index');
             }
             if ($bigPic->add()){
                 return $this->success('添加成功!',__APP__.'/Admin/BigPic/index');
             } else {
                 return $this->error('添加失败!',__APP__.'/Admin/BigPic/index');
             }

         } else {
             $this->display ();
         }
	}
 	
	/**
	 * 编辑首页大图
	 */
	public function edit(){

        $Assign = A ( 'Assign' );
        $Assign->index ();
        $bigPic = M ( 'big_pic' );



        if (IS_POST){
            if(empty($_POST['big_pic_id']))
            {
                $this->error('参数错误');
            }
            $big_pic_id = intval($_POST['big_pic_id']);
            $bigPic->find($big_pic_id);
            $bigPic->title = I('title', null);
            $bigPic->describtion = I('describtion', null);
            $bigPic->url = I('url', null);
            $bigPic->addtime = time ();
            //上传图片
            if ($_FILES ['logo'] ['name'] != "") {
                $fileInfo = $this->upload ( 'image', true );
                $bigPic->logo = $fileInfo;
            }
            if ($bigPic->save()){
                $this->success('修改成功!',__APP__.'/Admin/BigPic/index');
            } else {
                $this->error('修改失败!',__APP__.'/Admin/BigPic/index');
            }
        }else{
            if(empty($_GET['big_pic_id']))
            {
                $this->error('参数错误');
            }
            $big_pic_id = intval($_GET['big_pic_id']);
            $bigPic = $bigPic->where("id = $big_pic_id")->find();
            $this->assign('bigPic',$bigPic);
            $this->display();

        }

	}

    /**
     * 删除首页大图
     */
    public function del(){
        $bigPic = M ('big_pic');
        if (isset($_GET['big_pic_id'])){
            $big_pic_id = intval($_GET['big_pic_id']);
            if ($bigPicData = $bigPic->find($big_pic_id)){
                $logo = $bigPicData['logo'];

                if ($bigPic->where("id = $big_pic_id")->delete()){
                    @unlink(APP_PATH.'Public/upload/'.$logo);
                    $this->success('删除成功!' , __APP__.'/Admin/BigPic/index');
                }

            } else {
                $this->error('指定首页大图不存在!');
            }
        }
    }

}