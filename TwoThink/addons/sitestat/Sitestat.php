<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 小矮人 <82550565@qq.com>
// +----------------------------------------------------------------------
namespace addons\sitestat;

use think\Db;
/**
 * 系统环境信息插件
 */
class Sitestat extends \think\Addons {

    public $info = array(
        'name'=>'sitestat',
        'title'=>'站点统计信息',
        'description'=>'统计站点的基础信息',
        'status'=>1,
        'author'=>'twothink',
        'version'=>'0.1'
    );

    public function install(){
        return true;
    }

    public function uninstall(){
        return true;
    }

    //实现的AdminIndex钩子方法
    public function AdminIndex($param){
        $config = $this->getConfig(); 
        $this->assign('addons_config', $config);
        if($config['display']){
            $info['user']		=	Db::name('Member')->count();
            $info['action']		=	Db::name('ActionLog')->count();
            $info['document']	=	Db::name('Document')->count();
            $info['category']	=	Db::name('Category')->count();
            $info['model']		=	Db::name('Model')->count();
            $this->assign('info',$info);
            return $this->fetch('info');
        }
    }
}