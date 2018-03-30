<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn>
// +----------------------------------------------------------------------

namespace app\home\model;
use think\Model;
use think\Db;
use app\common\api\Uc;
/**
 * @title 文档基础模型
 * @Author 小矮人 82550565@qq.com
 */
class Member extends Model{
	protected $autoWriteTimestamp = false;

    /**
     * 登录指定用户
     * @param  integer $uid 用户ID
     * @return boolean      ture-登录成功，false-登录失败
     */
    public function login($uid){
        /* 检测是否在当前应用注册 */
        $user = $this->field(true)->find($uid);
        if(!$user){ //未注册
            /* 在当前应用中注册用户 */
        	$Api = new Uc();
        	$info = $Api->info($uid);
            $map=['uid'=>$uid,'nickname' => $info[1], 'status' => 1];
            if(!$this->create($map)){
                $this->error = '前台用户信息注册失败，请重试！';
                return false;
            }
        } elseif(1 != $user['status']) {
            $this->error = '用户未激活或已禁用！'; //应用级别禁用
            return false;
        }
 
        /* 登录用户 */
        $this->autoLogin($user); 
        //记录行为
        action_log('user_login', 'member', $uid, $uid);

        return true;
    }

    /**
     * 注销当前用户
     * @return void
     */
    public function logout(){
        session('user_auth', null);
        session('user_auth_sign', null);
    }

    /**
     * 自动登录用户
     * @param  integer $user 用户信息数组
     */
    private function autoLogin($user){
        /* 更新登录信息 */
        $data = array(
            'uid'             => $user['uid'],
            'login'           => array('exp', '`login`+1'),
            'last_login_time' => time(),
            'last_login_ip'   => get_client_ip(1),
        );
        $this->where('uid','eq',$user['uid'])->update($data);
        /* 记录登录SESSION和COOKIES */
        $auth =[
            'uid'             => $user['uid'],
            'username'        => get_username($user['uid']),
            'last_login_time' => $user['last_login_time'],
        ];

        session('user_auth', $auth);
        session('user_auth_sign', data_auth_sign($auth));

    }

}
