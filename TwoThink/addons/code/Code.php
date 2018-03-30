<?php

namespace addons\code;

/**
 * twothink代码生成器插件
 * @author 小矮人
 */

    class Code extends \think\Addons {

        public $info = array(
            'name'=>'code',
            'title'=>'twothink代码生成器',
            'description'=>'code是twothink官方推出的编程助手,快速生成代码,让开发更简单',
            'status'=>1,
            'author'=>'小矮人',
            'version'=>'0.1'
        );

        public $admin_list = array(
            'model'=>'Code',		//要查的表
        );
        //自定义后台模版
        public $custom_adminlist = 'adminlist.html';
        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的AdminIndex钩子方法
        public function AdminIndex($param){

        }

    }