<?php
namespace Home\Controller;

use Admin\Model\AdminGroupModel;

class ContentController extends BaseController
{

    public function index()
    {
        if (empty($_GET['id'])) {
            return $this->error("缺少指定参数!");
        }
        $id = intval($_GET['id']);
        $contentModel = D('Content');
        $content = $contentModel->where(['content_id' => $id, 'state' => 'publish'])->find();
        if (is_null($content)) {
            $this->error("您要访问的内容不存在!");
        }
        $contentModel->where('content_id=' . $id)->setInc('views');
        $classModel = D('Class');
        $class = $classModel->find($content['class_id']);
        $this->setTitle($content['title'] . ' - ' . $class['name']);
        $this->setCurrentClassId($class['class_id']);
        if ($class['father_id'] == 0)//一级栏目
        {
            $fatherClass = null;
        } else {
            $fatherClass = $classModel->where(['class_id' => $class['father_id']])->find();
        }
        //获取文章详细内容
        $article = M('ConArticle');
        $a = $article->find($id);
        $content['body'] = $a['body'];
        $classModel->templateId2Info($class);
        $classModel->templateId2Info($fatherClass);
        $this->assign('content', $content);
        $this->assign('fatherClass', $fatherClass);
        $this->assign('class', $class);
        $this->display();
    }

    public function addFeedback()
    {
        //创建各个模型
        $Content = D('Content');
        $Con_article = D('Con_article');
        if (IS_POST) {
            if(!$Content->validate($Content->_validate)->create()){
                $this->error($Content->getError());
            }else {
                //以下数据直接写死
                $Content->class_id = 56;
                $Content->admin_id = (new AdminGroupModel())->join('__ADMIN__ a on a.admin_group_id = g.admin_group_id', 'left')->alias("g")->where('g.admin_group_id = 1')->getField('admin_id');
                $Content->channel_id = 1;
                $Content->title = I('post.title', '', 'htmlspecialchars');
                $Content->author = I('post.email');
                $addtime = time();
                $addtime = date('Y-m-d', $addtime);
                $Content->addtime = $addtime;
                $Content->uptime = time();
                $Content->state = 'publish';
                if ($Content->add()) {
                    $Con_article->content_id = $Content->add();
                    $Con_article->class_id = 56;
                    $Con_article->body = I('post.body', '', 'htmlspecialchars');;
                    $Con_article->add();
                    $this->success('提交成功', __APP__ . '/Home/Index/index');
                } else {
                    $this->error('提交失败', __APP__ . '/Home/Content/addFeedback');
                }
            }
        } else {
            $this->display();
        }
    }
}
