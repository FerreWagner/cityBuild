<?php
namespace app\api\controller;

use app\api\Base;
use think\Request;

class Sign extends Base
{
    public function index()
    {
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * 学生报名
     */
    public function signOnWebsite(Request $request)
    {
        if ($request->isPost()){
            $param = $request->param();
            $res   = db('student')->insert($param);
            if($res) return json(['code' => '200', 'msg' => '报名成功']);
            return json(['code' => '99', 'msg' => '报名失败,请认真填写',]);
        }
    }

}
