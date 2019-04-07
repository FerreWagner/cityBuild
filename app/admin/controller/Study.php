<?php

namespace app\admin\controller;

use think\Request;
use app\admin\common\Base;
use app\admin\model\Study as StudyModel;
use think\Validate;

class Study extends Base
{
    
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $count   = db('study')->count();
        //search function
        if ($request->isPost()){
            $search  = $request->param();
            $article = db('study')->order('id desc')->where(['del' => 0])->where('major|layer|type|esystem|money', 'like', '%'.$search['title'].'%')->paginate(config('conf.page'));
        }else{
            $article = db('study')->order('id desc')->where(['del' => 0])->paginate(config('conf.page'));
        }
        //list
        $this->view->assign([
            'article' => $article,
            'count'   => $count,
        ]);
        return $this->view->fetch('study-list');
    }


    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function add(Request $request)
    {
        //add
        if ($request->isPost()){
            $token      = Validate::token('__token__','',['__token__'=>input('param.__token__')]);    //CSRF validate
            if (!$token) $this->error('CSRF ATTACK.');

            $data  = input('post.');
            $study = new StudyModel();
            if($study->allowField(true)->save($data)){
                $this->redirect('admin/study/add');
            }else{
                $this->error('添加失败');
            }
        }
        //page
        return $this->view->fetch('study-add');
    }
    

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->isPost()){
            $data = $request->param();
            $validate = Loader::validate('Article');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $article = new ArticleModel;
            $save=$article->update($data);
            if($save){
                $this->success('修改文章成功！',url('admin/article/index'));
            }else{
                $this->error('修改文章失败！');
            }
            return;
        }
        //cate data && article data
        $cate    = db('category')->field(['id', 'catename'])->order('sort', 'asc')->select();
        $article = db('article')->find($id);
        
        $type    = ArticleModel::getSystem()['type'];   //缩略图type
        
        //当然这里只是做简略处理，为了不让article表性能变低，我们将type字段分离到system表，如果在三方服务器和本地均存有图片，那么我们可以通过判断路径名来确定是否添加http://这样的完整路径
        $article['thumb'] = $type == 0 ? $article['thumb'] : 'http://'.$article['thumb'];
        $this->assign(['cate' => $cate, 'article' => $article]);
        return $this->view->fetch('article-edit');
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $res = StudyModel::delStatus($id);
        if ($res){
           $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    
    /**
     * 邮件服务
     */
//     public function mailServe()
//     {
//         if (Mail::isMail() == config('mail.close')) return true;
        
//         $user_email = session('user_data')['email'];
// //         halt($user_email);
//         $mail = new Mail();
//         $mail->getXml('admin');
//         $mail->recive = $user_email;
//         $mail->init();
//         $mail->content();
//         $mail->replay();
//         if (!$mail->send()){
//             $this->error('Mail Server Error.');
//         }
        
//     }
}
