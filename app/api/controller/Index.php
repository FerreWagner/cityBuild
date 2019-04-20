<?php
namespace app\api\controller;

use app\api\Base;
use think\Request;

class Index extends Base
{
    //TODO 如果后期需求存在多个前台用户需求,那么洗澡能common控制器,cookie比对,重构验证登录token的api
    public function index()
    {
        if (request()->isGet()){
            return json(['code' => '200','msg' => '过分了get老铁']);
        }elseif(request()->isPost()){
            return json(['code' => '200','msg' => 'post老铁']);
        }
    }

    /**
     * @return \think\response\Json
     * 成考列表
     */
    public function studyLst()
    {
        $data = db('study')->field('major,layer,type,esystem,money')->where(['del' => 0])->order('id', 'asc')->select();
        if (empty($data)){
            return json(['code' => '400', 'msg' => '暂无数据']);
        }
        return json(['code' => '200', 'data' => $data]);
    }

    /**
     * @return \think\response\Json
     * 网站资料
     */
    public function getWebData()
    {
        $data = db('webdata')->field('adult_desc,adult_use,adult_where,adult_time,adult_money,adult_major,adult_score,adult_query')->find(1);
        return json(['code' => '200', 'data' => $data]);
    }

    /**
     * @return \think\response\Json
     * 友链列表
     */
    public function getLink()
    {
        $data = db('link')->field('name,url')->order('sort desc')->select();
        if ($data){
            return json(['code' => '200', 'msg' => '获取成功', 'data' => $data]);
        }
        return json(['code' => '99', 'msg' => '暂无数据']);

    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * 获取用户报名数据
     */
    public function userData(Request $request)
    {
        if ($request->isPost()){
            $form   = request()->param();
            $token  = base64_decode($form['token']);
//            $token = base64_decode('ODFkYzliZGI1MmQwNGRjMjAwMzZkYmQ4MzEzZWQwNTUxNTU1NzQ0MDAyMQ==');
            $pass   = substr($token, 0, -11);
            $userid = substr($token, -1);
            $data = db('user')->where(['id' => $userid, 'password' => $pass])->find();
            if ($data){
                return json(['code' => '200', 'msg' => '请求成功', 'data' => $data]);
            }
            return json(['code' => '99', 'msg' => '暂无此用户']);
        }

    }
    
}
