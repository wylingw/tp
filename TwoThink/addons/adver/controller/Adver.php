<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 小矮人 <82550565@qq.com>
// +----------------------------------------------------------------------
namespace addons\adver\controller;

use app\home\controller\Addons;

/*
 * @title 广告位 管理控制器
 * @Author 小矮人 <82550565@qq.com> twothink.cn
 */
class Adver extends Addons{
    public function setstatus(){
        $this->setState();
    } 
}