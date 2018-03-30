<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn>
// +----------------------------------------------------------------------

namespace app\home\controller;

use think\Controller;
use think\Cache;
use think\Loader;
use think\Db;
use app\common\controller\ModelSystem;
/**
 * 插件执行默认控制器
 * @Author 苹果 <593657688@qq.com>
 */
class Addons extends Controller
{
    public $addon_path; // 插件路径

    public function _initialize(){

        /* 读取数据库中的配置 */
        $config = Cache::get('db_config_data_addons');
        if(!$config){
            $config = api('Config/lists');
            Cache::set('db_config_data_addons',$config);
        }
        config($config); //添加配置

        if(!$this->addon_path){
            $param = $this->request->param();
            $this->addon_path = "../addons/{$param['_addons']}/";
        }
        //加载插件函数文件
        if (file_exists($this->addon_path.'common.php')) {
            include_once $this->addon_path.'common.php';
        }
    }
    /**
     * 插件执行
     */
    public function execute($_addons = null, $_controller = null, $_action = null)
    {
        if (!empty($_addons) && !empty($_controller) && !empty($_action)) {
            // 获取类的命名空间
            $class = get_addon_class($_addons, 'controller', $_controller);

            if(class_exists($class)) {
                $model = new $class();
                if ($model === false) {
                    $this->error(lang('addon init fail'));
                }

                // 调用操作
                return  \think\App::invokeMethod([$class, $_action]);
            }else{
                $this->error(lang('控制器不存在'.$class));
            }
        }
        $this->error(lang('没有指定插件名称，控制器或操作！'));
    }
    /**
     * 解析和获取模板内容 用于输出
     * @param string    $template 模板文件名或者内容
     * @author 苹果 593657688@qq.com <twothink.cn>
     */
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        $param = $this->request->param();
        if(empty($template)){
            $template = T('addons://'.$param['_addons'].'@'.$param['_controller'].'/'.$param['_action']);
        }elseif(strstr($template, "@")){
            //TODO
        }else{
            $template_arr = explode('/',$template);
            $count = count($template_arr);
            if($count <= 2){
                $tpl = $param['_addons'].'@'.$template;
            }else{
                $tpl = $template_arr[0];
                unset($template_arr[0]);
                $tpl .= '@'.implode('/',$template_arr);
            }
            $template = T('addons://'.$tpl);
        }
        return $this->view->fetch($template, $vars, $replace, $config);
    }
    /**
     * 通用列表查询
     * @param array|int    $model_info 模型定义规则 或者  系统模型ID
     * @param int          $type       模式 1单线继承模型 2为V类型模型
     * return  array
     * @author 苹果 593657688@qq.com <twothink.cn>
     */
    protected function getList($model_info,$type=true){
        $param = $this->request->param();
        if(is_array($model_info)){
            $Modelinfo = Modelinfo();
            if($this->request->isPost()){
                $Modelinfo = $Modelinfo->info($model_info)->scene($param['_action']) //初始化模型
                     ->getSearchList() //获取搜索配置
                     ->getWhere() //拼装搜索条件
                     ->getViewList() //列表查询
                     ->parseList()
                     ->parseListIntent()
                     ->getParam('info');
            }else{
                $Modelinfo = $Modelinfo->info($model_info)->scene($param['_action']) //初始化模型
                     ->getListField()
                     ->getSearchList() //获取搜索配置
                     ->getParam('info');
            }
        }else{
            $ModelSystem =new ModelSystem(['type'=>$type]);
            if($this->request->isPost()) {
                $Modelinfo = $ModelSystem->info($model_info)->scene($param['_action'])
                    ->getSearchList()
                    ->getWhere()
                    ->getViewList()
                    ->parseList()
                    ->parseListIntent()
                    ->getParam('info');
            }else{
                $Modelinfo = $ModelSystem->info($model_info)->scene($param['_action'])
                    ->getListField()
                    ->getSearchList()
                    ->getParam('info');
            }
        }
        return $Modelinfo;
    }
    /**
     * 通用模型新增
     * @param $model_info 模型定义规则 或者  系统模型ID
     * @return $model_info 解析后的模型规则
     * @author 苹果 593657688@qq.com
     */
    protected function getAdd($model_info){
        if(is_numeric($model_info)){
            $ModelSystem = new ModelSystem();
            $model_info  = $ModelSystem->info($model_info,false,true)->getFields()->FieldDefaultValue()->setInit()->getParam('info');
        }else{
            $model_info = Modelinfo()->info($model_info)->getFields()->FieldDefaultValue()->setInit()->getParam('info');
        }
        return $model_info;
    }
    /**
     * 通用模型编辑
     * $model_info 模型定义规则 或者  系统模型ID
     * $where      查询条件
     * @author 小矮人 <twothink.cn>
     */
    protected function getEdit($model_info,$where = false){
        $param = $this->request->param();
        if($where){
            $where = ['id'=>$param['id']];
        }
        if(is_numeric($model_info)){
            $ModelSystem = new ModelSystem();
            $model_info = $ModelSystem->info($model_info,true,true)->getFields()->getQueryModel('logic')->getFind($where)->setInit()->getParam('info');
        }else{
            $model_info = Modelinfo()->info($model_info)->getQueryModel()->getFind($where)->setInit()->getParam('info');
        }
        return $model_info;
    }
    /**
     * 新增和更新数据
     * $model_info 模型定义规则 或者  系统模型ID
     * $laye       模型分层
     * @author 小矮人 <twothink.cn>
     */
    protected function getUpdate($model_info,$laye = 'model'){
        //获取模型信息
        if(is_numeric($model_info)) {
            $model_obj = new ModelSystem();
            $model_obj->info($model_info);
        }else{
            $model_obj = Modelinfo()->info($model_info);
        }
        //自动验证
        $validate = $model_obj->checkValidate();
        $validate || $this->error($model_obj->getError());

        $res = $model_obj->getQueryModel($laye)->getUpdate();
        $res || $this->error($model_obj->getError());
        $param = $this->request->param();

        $info = $model_obj->getParam('info');
        $this->success(!empty($param[$info['pk']])?'更新成功':'新增成功');
    }

    /**
     * 设置一条或者多条数据的状态
     * $model 模型名称或模型对象
     * $pk 主键
     */
    protected function setState($model=false,$pk='id'){
        $ids    =   input('ids/a');
        $status =   input('status');

        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        $map[$pk] = ['in',$ids];
        switch ($status){
            case -1 :
                $this->delete($model, $map,['success'=>'删除成功','error'=>'删除失败']);
                break;
            case '0'  :
                $this->forbid($model, $map,['success'=>'禁用成功','error'=>'禁用失败']);
                break;
            case 1  :
                $this->resume($model, $map,['success'=>'启用成功','error'=>'启用失败']);
                break;
            case 'del': //z真删除
                $this->delRow($model, $map,['success'=>'删除成功','error'=>'删除失败']);
                break;
            default :
                $this->error('参数错误');
                break;
        }
    }
    /**
     * 条目假删除
     * @param string $model 模型名称,供D函数使用的参数
     * @param array  $where 查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     * * @author 艺品网络 <twothink.cn>
     */
    protected function delete ( $model , $where = [] , $msg = ['success'=>'删除成功！', 'error'=>'删除失败！']) {
        $data['status']  =   -1;
        $this->editRow($model , $data, $where, $msg);
    }
    /**
     * 条目真删除
     * @param string $model 模型名称,供D函数使用的参数
     * @param array  $where 查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     * * @author 艺品网络 <twothink.cn>
     */
    final protected function delRow ( $model,$where , $msg=false ){
        $msg   = array_merge( array( 'success'=>'删除成功！', 'error'=>'删除失败！', 'url'=>'' ,'ajax'=>var_export($this->request->isAjax(), true)) , (array)$msg );
        if(empty($model)){
            $param = $this->request->param();
            $model = Loader::parseName($param['_controller'],1);
        }
        if(!is_object($model)){
            $model = Db::name($model);
        }
        if( $model->where($where)->delete()!==false ) {
            $this->success($msg['success']);
        }else{
            $this->error($msg['error']);
        }
    }
    /**
     * 还原条目
     * @param string $model 模型名称,供D函数使用的参数
     * @param array  $where 查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     * @author 艺品网络  <twothink.cn>
     */
    protected function restore (  $model , $where = array() , $msg = array( 'success'=>'状态还原成功！', 'error'=>'状态还原失败！')){
        $data    = array('status' => 1);
        $where   = array_merge(array('status' => -1),$where);
        $this->editRow(   $model , $data, $where, $msg);
    }
    /**
     * 禁用条目
     * @param string $model 模型名称,供D函数使用的参数
     * @param array  $where 查询时的 where()方法的参数
     * @param array  $msg   执行正确和错误的消息,可以设置四个元素 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     * * @author 艺品网络 <twothink.cn>
     */
    protected function forbid ( $model , $where = [] , $msg = ['success'=>'状态禁用成功！', 'error'=>'状态禁用失败！']){
        $data    =  ['status' => 0];
        $this->editRow( $model , $data, $where, $msg);
    }
    /**
     * 恢复条目
     * @param string $model 模型名称,供D函数使用的参数
     * @param array  $where 查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     * * @author 艺品网络 <twothink.cn>
     */
    protected function resume (  $model , $where = [] , $msg = ['success'=>'状态恢复成功！', 'error'=>'状态恢复失败！']){
        $data    =  ['status' => 1];
        $this->editRow(   $model , $data, $where, $msg);
    }
    /**
     * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
     *
     * @param string $model 模型名称
     * @param array  $data  修改的数据
     * @param array  $where 查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     * * @author 艺品网络 <twothink.cn>
     */
    final protected function editRow ( $model ,$data, $where , $msg=false ){
        $msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>var_export($this->request->isAjax(), true)) , (array)$msg );
        if(empty($model)){
            $param = $this->request->param();
            $model = Loader::parseName($param['_controller'],1);
        }
        if(!is_object($model)){
//            $path = 'addons\adver\model\\'.$model;
//            $model = new $path;
            $model = Db::name($model);
        }
        if( $model->where($where)->update($data)!==false ) {
            $this->success($msg['success']);
        }else{
            $this->error($msg['error']);
        }
    }
}
