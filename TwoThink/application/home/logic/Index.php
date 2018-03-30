<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace app\home\controller;
use app\home\model\Document;
use think\Db;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class Index extends Home{


	//系统首页
    public function index(){
        //$this->assign();//分页
        return $this->fetch('index');
    }

    /**
     * 添加修改内容
     * @return mixed|string|void
     */
    public function add(){
        if($this->request->isPost()){
        $post=$_POST;
        $post['sn']='TT'.uniqid();
        $post['create_time']=time();
        if(Db::table('twothinkrepair')->insert($post)){
            $result = $this->validate($post,'Property');
            if(true!==$result){
                // 验证失败 输出错误信息
                return $this->error($result);
            }else{
                //跳转页面
                return $this->success('添加成功',url('index'));
            }
        }

        }else{
        return $this->fetch ('add');
        }
    }

    /**
     * 广告
     * @return mixed|string
     */
    public function ad(){
        $list = Db::query('select * from `twothinkad`');
        $page = input ( 'page', 1 );
        $number = 2; // 每页显示
        $voList = Db::name ( 'repair' )->paginate ( $number, false, array (
            'page' => $page
        ) );
        $_page = $voList->render (); // 获取分页显示
        $voList = array_slice ( $list, bcmul ( $number, $page ) - $number, $number );
        $this->assign( '_page', $_page );
        $this->assign( '_list', $voList );
        return $this->fetch ();
    }

}
