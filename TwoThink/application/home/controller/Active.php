<?php

namespace app\home\controller;

use think\Db;

class Active extends Home
{
    //通知列表頁
    public function index()
    {
        $notices = Db::table('twothink_active')->where('status', 1)->select();
        $this->assign('notices', $notices);
        return $this->fetch('index');
    }

    //詳情
    public function detail()
    {
        $request = $this->request;
        $id = $request->get('id');
        $data = Db::table('twothink_active')->where('id', $id)->find();
        //开启redis
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        //自增1
        $data['view'] = $redis->incr('view');
        unset($data['0']);
        $now_time = time();
        if ($now_time > $data['end_time']) {
            $data['status'] = 0;
            $result = Db::table('twothink_active')->where('id', $id)->update($data);
            if ($result) {
                return $this->error('活动已经结束！！！！');
            }
        }
        $res = Db::table('twothink_active')->where('id', $id)->update($data);
        if (!$res) {
            return $this->error('更新浏览量失败');
        }
        //var_dump($id);die();
        $detail = Db::table('twothink_active')->where('id', $id)->select();
        // var_dump($detail);die();
        $this->assign('detail', $detail);
        return $this->fetch('active_detail');
    }

    public function hit()
    {
        $uid = 2;
        $res = Db::table('twothink_ucenter_member')->where('id', $uid)->find();
        if ($res) {
            $res['status'] = 2;
            $hit=Db::table('twothink_ucenter_member')->where('id', $uid)->update($res);
            if ($hit){
                echo 1;
            }else{
                echo 0;
            }
        }
    }


}