<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络
// +----------------------------------------------------------------------


namespace Addons\devteam;

/**
 * 开发团队信息插件
 * @author twothink
 */

    class Devteam extends \think\Addons {

        public $info = array(
            'name'=>'devteam',
            'title'=>'开发团队信息',
            'description'=>'开发团队成员信息',
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
            if($config['display'])
               return  $this->fetch('widget');
        }
    }