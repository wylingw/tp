<?php

namespace app\admin\validate;
use think\Validate;

class Notice extends Validate{
    // 验证规则
    protected $rule = [
        ['title', 'require', '标题名必填|用户名长度6-30'],
        ['content', 'require|length:1,10000', '內容必须|內容长度255'],
        ['author', 'require', '发布者必填'],


    ];

}