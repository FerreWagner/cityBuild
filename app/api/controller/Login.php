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

    /**
     * @param Request $request
     * @return \think\response\Json
     * 前台用户注册
     */
    public function userLogin(Request $request)
    {
        if ($request->isPost()){
            $param = $request->param();
            $res = db('user')->where(['username' => $param['username']])->find();
            if ($res){
                $ress = db('user')->where(['username' => $param['username'], 'password' => md5($param['password'])])->find();
                if ($ress){
                    $token = base64_encode(config('salt.url_salt').time().$ress['id'].$ress['password']);
                    return json(['code' => '200', 'msg' => '登陆成功', 'data' => ['userid' => $ress['id'], 'username' => $ress['username'], 'token' => $token]]);
                }else{
                    return json(['code' => '99', 'msg' => '登录失败']);
                }
            }else{
                return json(['code' => '99', 'msg' => '请输入正确的用户名']);
            }
        }
    }

    public function userData()
    {

    }

}
