<?php

namespace app\home\controller;


use think\Db;

class Repair extends Home
{
    //添加页
    public function add()
    {
        $request = $this->request;
        if ($request->isPost()) {
            //接收數據
            $data = $request->post();
            //var_dump($data);die();
            $data['status'] = 1;
            $data['create_time'] = time();
            $table = "Repair";
            $result = $this->validate($data, "Repair");
            if ($result) {
                //插入數據
                \db($table, [], false)->insert($data);
            }
            //跳转页面
            return $this->success('添加成功', url('index/index'));
        }

        return $this->fetch("online");
    }

}
