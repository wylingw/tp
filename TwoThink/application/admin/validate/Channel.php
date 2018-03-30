<?php
 
namespace app\admin\validate;
use app\common\validate\Base;

class Channel extends Base {
     
    protected $rule = [ 
        ['title', 'require', '标题不能为空'],
        ['url', 'require', 'URL不能为空'], 
    ];   
}