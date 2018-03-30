<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 小矮人  82550565@qq.com <www.twothink.cn>
// +----------------------------------------------------------------------

namespace addons\adver;

//use app\common\controller\Addon;
use think\Addon;
use addons\adver\model\Adver as AdverModel;
use app\common\api\Addon as AddonApi;
/*
 * 广告插件
 * @author 小矮人  82550565@qq.com
 */

class Adver extends \think\Addons{

    public $info = array(
        'name'=>'adver',
        'title'=>'广告位管理',
        'description'=>'广告位管理插件前端调用方式{:hook(\'Advs\',\'1\')}',
        'status'=>1,
        'author'=>'小矮人',
        'version'=>'0.1'
    );
    public $addon_path = './addons/adver/';
    /**
     * 配置列表页面
     */
    public $admin_list = [
        'model'=>'Adver',       //要查的表
    ];
    //自定义后台模版
//    public $custom_adminlist = 'adminlist.html';
    //安装插件
    public function install(){
        $AddonApi = new AddonApi;
        $AddonApi->existHook('Advs','adver','广告位管理');
        return true;
    }
    //卸载插件
    public function uninstall(){
        $AddonApi = new AddonApi;
        $AddonApi->delHooks('Advs');
        return true;
    }

    //实现的广告钩子
    public function Advs($param){
        $Adver = new AdverModel;
        $list = $Adver->AdverList($param);
        if(!$list)
            return true;
        $this->assign('list',$list);
        return $this->fetch('content');
    }
}