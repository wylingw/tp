<?php

namespace app\admin\controller;

use app\admin\model\AuthGroup;
use think\Db;

class Property extends Admin
{
    public function index()
    {
        //总条数
        //$counts = Db::table('twothink_repair')->count();
        //  var_dump($counts);
        // $page=input('page',1);
        $request = $this->request;
        $page = $request->get('page')?? 1;
        $pageSize = 3;
        $list = Db::table('twothink_repair')->paginate($pageSize, false, ['page' => $page]);
        $_page = $list->render();//分页显示
        $propertys = Db::table('twothink_repair')->limit($pageSize * $page - 2, $pageSize)->select();
        $this->assign('_page', $_page);
        $this->assign('propertys', $propertys);
        $this->assign('list', $list);
        return $this->fetch();
    }

    //添加
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
//            $result = $this->validate($data, "Repair");
//            if ($result) {
            //插入數據
            \db($table, [], false)->insert($data);
//            }
            //跳转页面
            return $this->success('添加成功', url('admin/property/index'));
        }

        return $this->fetch("add");
    }

    //修改
    public function edit()
    {
        $request = $this->request;
        if ($request->isPost()) {
            $data = $request->post();
            $res = Db::table('twothink_repair')->where('id', $data['id'])->update($data);
            if ($res) {
                return $this->success('修改成功', url('index'));
            } else {
                return $this->error('修改失败');
            }
        }

        $id = $request->get('id');
        $ps = Db::table('twothink_repair')->where('id', $id)->find();
        $this->assign('ps', $ps);
        return $this->fetch("edit");
    }

    //删除
    public function del()
    {
        $request = $this->request;
        $id = $request->get('id');
        $res = Db::table('twothink_repair')->delete($id);
        if ($res) {
            return $this->success('删除成功', url('index'));
        } else {
            return $this->error('修改失败');
        }
    }

    //分页刷新
    public function hit()
    {
        //
    }

}