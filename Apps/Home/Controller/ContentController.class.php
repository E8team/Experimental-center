<?php
namespace Home\Controller;

class ContentController extends BaseController {

	public function index()
    {
        if (empty($_GET['id'])) {
            return $this->error("缺少指定参数!");
        }

        $id = intval($_GET['id']);
        $contentModel = D ('Content');
        $content = $contentModel->where(['content_id'=>$id, 'state'=>'publish'])->find();

        if (is_null($content)) {
            $this->error("您要访问的内容不存在!");
        }
        $contentModel->where('content_id='.$id)->setInc('views');
        $classModel = D('Class');
        $class = $classModel->find($content['class_id']);
        $this->setTitle($content['title'].' - '.$class['name']);
        $this->setCurrentClassId($class['class_id']);
        if($class['father_id'] == 0)//一级栏目
        {
            $fatherClass = null;
        }else{
            $fatherClass = $classModel->where(['class_id'=>$class['father_id']])->find();
        }

        //获取文章详细内容
        $article = M ('ConArticle');
        $a = $article->find($id);
        $content['body'] = $a['body'];

        $classModel->templateId2Info($class);
        $classModel->templateId2Info($fatherClass);
        $this->assign('content', $content);
        $this->assign('fatherClass', $fatherClass);
        $this->assign('class', $class);
        //dd($fatherClass);
        $this->display();
    }
}