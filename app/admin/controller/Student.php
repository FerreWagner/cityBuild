<?php

namespace app\admin\controller;

use think\Request;
use app\admin\common\Base;

class Student extends Base
{
    
    /**
     * 显示报名信息
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $count   = db('student')->count();
        //search function
        if ($request->isPost()){
            $search  = $request->param();
            $article = db('student')->order('id desc')->where('name|sex|idcard|major|level|city|work|phone', 'like', '%'.$search['title'].'%')->paginate(config('conf.page'));
        }else{
            $article = db('student')->order('id desc')->paginate(config('conf.page'));
        }
        //list
        $this->view->assign([
            'article' => $article,
            'count'   => $count,
        ]);
        return $this->view->fetch('student-list');
    }

}
