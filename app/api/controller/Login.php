<?php
namespace app\api\controller;

use app\api\Base;
use think\Loader;
use think\Request;

class Login extends Base
{
    public function index()
    {
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * 前台用户注册
     */
    public function userRegister(Request $request)
    {
        if ($request->isPost()){
            $param    = $request->param();
            $validate = Loader::validate('User');
            if (!$validate->scene('userRegister')->check($request->param())){
                $this->error($validate->getError());
            }

            $data = [
                'username' => $param['username'],
                'password' => md5($param['password']),
                'createTime' => date('Y-m-d H:i:s'),
            ];

            $res = db('user')->insert($data);
            if($res) return json(['code' => '200', 'msg' => '注册成功']);
            return json(['code' => '99', 'msg' => '注册失败']);
        }
    }

}
