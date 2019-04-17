<?php
namespace app\api\validate;

use think\Validate;

class User extends Validate
{
    // 验证规则
    protected $rule = [
        'username'      => 'unique:user|require|min:2',
    ];

    protected $scene = [    //场景
        'userRegister' => ['username' => 'unique:user|require|min:2'],
    ];
}