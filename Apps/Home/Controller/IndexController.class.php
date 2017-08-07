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
        $noticeClass = $classes[55];
        $classify->templateId2Info($noticeClass);
		$noticeLists = $Content->getContent($noticeClass, $this->prePage);
        $this->assign('noticeClass',$noticeClass);
		$this->assign('noticeLists',$noticeLists);

		//中心简介
        $centerClass = $classes[46];
        $classify->templateId2Info($centerClass);
        $centerProfile = $Content->getContent($centerClass, $this->prePage);
        $this->assign('centerClass',$centerClass);
        $this->assign('centerProfile',$centerProfile[0]);


        //教学反馈
        $teachingFeedbackClass = $classes[56];
        $classify->templateId2Info($teachingFeedbackClass);
        $teachingFeedback = $Content->getContent($teachingFeedbackClass, $this->prePage);
        $this->assign('teachingFeedbackClass',$teachingFeedbackClass);
        $this->assign('teachingFeedback', $teachingFeedback);
        //dd($teachingFeedback);

        //实验室一览
        $laboratoryClass = $classes['47'];
        $classify->templateId2Info($laboratoryClass);
        $laboratory = $Content->getContent($laboratoryClass, $this->prePage);
        $this->assign('laboratoryClass' , $laboratoryClass);
        $this->assign('laboratory' , $laboratory);


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

        //获取首页大图
        $bigPic = M('big_pic');
        $bigPics = $bigPic->order('sort_index asc, addtime desc')->select();
        $this->assign('bigPics', $bigPics);
		$this->display();
    }
    
}