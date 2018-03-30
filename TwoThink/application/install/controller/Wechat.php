<?php

namespace app\install\controller;
class Wechat extends \think\Controller
{
    public function oauth2()
    {
        $appid = "wxf1e51df276d7a5b7";
        $scope="snsapi_userinfo";
        $redicet_url=url('wechat/red','',true,true);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?'.'
       appid={$appid}&redirect_uri={$redicet_url}&
       '.'response_type=code&scope={$scope}&state=STATE#wechat_redirect ";
    }
    public function red(){

    }
}