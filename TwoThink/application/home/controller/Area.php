<?php
namespace app\home\controller;

use think\Db;

class Area extends Home
{
    //通知列表頁
    public function index()
    {
        $notices=Db::table('twothink_area')->select();
        $this->assign('notices',$notices);
        return $this->fetch('index');
    }

    //詳情
    public function detail()
    {
        $request=$this->request;
        $id=$request->get('id');
        $data=Db::table('twothink_area')->where('id',$id)->select();
        //开启redis
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        //自增1
        $data['view'] = $redis->incr('view');
        unset($data['0']);
        $res=Db::table('twothink_area')->where('id',$id)->update($data);
        if (!$res){
            return $this->error('更新浏览量失败');
        }
        //var_dump($id);die();
        $detail=Db::table('twothink_area')->where('id',$id)->select();
        // var_dump($detail);die();
        $this->assign('detail',$detail);
        return $this->fetch('area_detail');
    }


}