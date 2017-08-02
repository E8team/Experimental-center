<?php
namespace Home\Controller;
use Boris\Config;
use Think\Controller;
use Think\Page;

/**
 * 网站首页
 * 
 * @author webdd
 *
 */

class IndexController extends BaseController {

    private $prePage;

    public function __construct()
    {
        $this->prePage = is_null(C('prePage')) ? 8:C('prePage');
        return parent::__construct();
    }

    public function index(){
	
		$Content = D ('Content');
        $classify = D('Class');
		
        $classes = $classify->allClasses();
		//通知公告
        //$noticeClass = $this->getClassByName('通知公告');
        $noticeClass = $classes[36];
        $classify->templateId2Info($noticeClass);
		$noticeList = $Content->getContent($noticeClass, $this->prePage);
        $this->assign('noticeClass',$noticeClass);
		$this->assign('noticeList',$noticeList);


		//教学管理
        //$teachingClass = $this->getClassByName('教学管理');
        $teachingClass = $classes[3];
        $classify->templateId2Info($teachingClass);
        $teaching = $Content->getContent($teachingClass, $this->prePage);
        $this->assign('teachingClass',$teachingClass);
        $this->assign('teaching', $teaching);

        //科学研究
        //$scienceClass = $this->getClassByName('科学研究');
        $scienceClass = $classes[4];
        $classify->templateId2Info($scienceClass);
        $scientific = $Content->getContent($scienceClass, $this->prePage);
        $this->assign('scienceClass',$scienceClass);
        $this->assign('scientific',$scientific);

        //党团建设
        //$dtjsClass = $this->getClassByName('党团建设');
        $dtjsClass = $classes[5];
        $classify->templateId2Info($dtjsClass);
        $dtjsList = $Content->getContent($dtjsClass, $this->prePage);
        $this->assign('dtjsClass',$dtjsClass);
        $this->assign('dtjsList',$dtjsList);

        //政法要闻
        //$newsClass = $this->getClassByName('政法要闻');
        $newsClass = $classes[37];
        $classify->templateId2Info($newsClass);

        $this->assign('newsClass', $newsClass);
		
        //政法要闻里面的有图新闻
        $imgNews = $Content->getImgNews($newsClass['class_id'], 1);
        //dd($imgNews);
        $this->assign('imgNews', $imgNews['0']);

        $newsList = $Content->getContent($newsClass, $this->prePage, $imgNews[0]['content_id']);
        $this->assign('newsList', $newsList);

        //设置页面标题
        $this->setTitle('首页');

        /*
		//获取焦点图
		$jdtList = $Content->getJdt(3,4);
		$this->assign('jdtList',$jdtList);

		//专题专栏
		$zhuantiList = $Content->getContent(5,11);
		$this->assign('zhuantiList',$zhuantiList);
		//获取专题专栏下面的子栏目
		$Class = D ('Class');
		$zhuantiClass = $Class->getChildClassArr(5);

		//获取专题专栏图片
		$Flink = M('Flink');
		$condition['type_id'] = 7;
		$zhuantiImg = $Flink->where($condition)->select();

		//循环加入专题专栏对应图片
		foreach ($zhuantiClass as $k=>$v) {
			$zhuantiClass[$k]['img'] = $zhuantiImg[$k]['logo'];
		}
		//p($zhuantiClass);
		$this->assign('zhuantiClass',$zhuantiClass);
        */
        //获取首页大图
        $bigPic = M('big_pic');
        $bigPics = $bigPic->order('sort_index asc, addtime desc')->select();
        $this->assign('bigPics', $bigPics);
		
		$this->display();
    }
    
}