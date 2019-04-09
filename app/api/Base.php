<?php
namespace app\api;

use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        header('Access-Control-Allow-Origin: *'); // "*"号表示允许任何域向服务器端提交请求；也可以设置指定的域名，那么就允许来自这个域的请求：
        header('Access-Control-Allow-Methods: POST,GET');
        header('Access-Control-Max-Age: 1000');
    }


}
