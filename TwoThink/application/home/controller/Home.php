<?php


namespace app\home\controller;
use app\common\controller\Common;


/**
 * 前台公共控制器
 */
class Home extends Common {
	public function __construct(){
        /* 读取站点配置 */
        $config = cache('db_config_data_home');
        if(!$config){
            $config = api('Config/lists');
            $config ['template'] = config('template');
            $config ['template']['view_path'] = APP_PATH.'home/view/'.$config['home_view_path'].'/';
            cache('db_config_data_home', $config);
        }
        config($config); //添加配置
        parent::__construct();
	}
    protected function _initialize(){
        if(!config('web_site_close')){
            $this->error('站点已经关闭，请稍后访问~');
        }
    }
	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}
}
