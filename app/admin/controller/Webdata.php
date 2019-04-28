<?php
namespace app\admin\controller;

use app\admin\common\Base;
use think\Request;
use app\admin\model\Webdata as WebdataModel;
class Webdata extends Base
{
    
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    
    public function index(Request $request)
    {
        //config update
        if ($request->isPost()) {
            $data = $request->param();
            if (isset($data['file'])) unset($data['file']);
            $res  = WebdataModel::update($data, ['id' => 1]);
            $res ? $this->success('设置成功') : $this->error('更新失败,请稍后重试');
        }
        $this->view->assign('webdata', WebdataModel::get(1));
        return $this->view->fetch('website-data');
    }
}