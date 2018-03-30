<?php

namespace app\home\validate;
use think\Validate;

class Repair extends Validate{
    // 验证规则
    protected $rule = [
        ['name', 'require|unique:Repair|length:1,30', '用户名必须|用户已存在|用户名长度6-30'],
        ['tel', 'require|unique:Repair|length:1,11', '電話必须|電話已存在|電話格式不正确|電話长度不合法'],
        ['address', 'require|unique:Repair', '地址必填'],
        ['content', 'require|length:1,255', '內容必须|內容长度255'],
    ];

}