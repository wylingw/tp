<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\Menu;

use think\Controller;
use think\Db;
use think\Config;
use think\Exception;

use app\common\model\AuthRule;

class Admin extends Controller {
    public $model_info; //自定义模型配置信息
    protected $two_assign;//统一赋值数据
    public function __construct(){
        /* 读取数据库中的配置 */
        $config = cache('db_config_data');
        if(!$config){
            $config =   api('Config/lists');
            $config ['template'] = config('template');
            $config ['template']['view_path'] = APP_PATH.'admin/view/'.$config['admin_view_path'].'/'; //模板主题
            $config['dispatch_error_tmpl' ]    =  APP_PATH .'admin'. DS .'view' . DS .$config['admin_view_path'].DS. 'public' . DS . 'error.html'; // 默认错误跳转对应的模板文件
            $config['dispatch_success_tmpl' ]  =  APP_PATH .'admin'. DS .'view' . DS .$config['admin_view_path'].DS. 'public' . DS . 'success.html'; // 默认成功跳转对应的模板文件
            cache('db_config_data', $config);
        }
        config($config);//添加配置

        parent::__construct();

    }
    /**
     * 后台控制器初始化
     */
    public function _initialize(){
        // SESSION_ID设置的提交变量,解决flash上传跨域
        $session_id=input(config('session.var_session_id'));
        if($session_id){
            session_id($session_id);
        }
        // 获取当前用户ID
        if(defined('UID')) return ;
        define('UID',is_login());
        if( !UID ){// 还没登录 跳转到登录页面
            $this->redirect('Login/index');
        }
        // 是否是超级管理员
        define('IS_ROOT',   is_administrator());
        if(!IS_ROOT && config('admin_allow_ip')){
            // 检查IP地址访问
            if(!in_array(get_client_ip(),explode(',',config('admin_allow_ip')))){
                $this->error('403:禁止访问');
            }
        }
        // 检测系统权限
        if(!IS_ROOT){
            $access =   $this->accessControl();
            if ( false === $access ) {
                $this->error('403:禁止访问');
            }elseif(null === $access ){
                //检测访问权限
                $rule  = strtolower($this->request->module().'/'.$this->request->controller().'/'.$this->request->action());
                if ( !$this->checkRule($rule,array('in','1,2')) ){
                    $this->error('未授权访问!');
                }else{
                    // 检测分类及内容有关的各项动态权限
                    $dynamic    =   $this->checkDynamic();
                    if( false === $dynamic ){
                        $this->error('未授权访问!');
                    }
                }
            }
        }
        $this->getmenus();
    }
    public function getmenus(){
        $Menu_obj = new Menu();
        $MeunTree=$Menu_obj->setAttr(['module'=>$this->request->module(),'controller'=>$this->request->controller(),'action'=>$this->request->action()])
            ->extra_menu($this->extra_menu())
            ->getMenuTree();
        $this->assign('__MENU__', $MeunTree);
    }
    /*
     * @title 动态扩展菜单
     */
    protected function extra_menu(){}

    /**
     * 权限检测
     * @param string  $rule    检测的规则
     * @param string  $mode    check模式
     * @return boolean
     */
    final protected function checkRule($rule, $type=AuthRule::rule_url, $mode='url'){
        static $Auth    =   null;
        if (!$Auth) {
            $Auth       =   new \com\Auth();
        }
        if(!$Auth->check($rule,UID,$type,$mode)){
            return false;
        }
        return true;
    }

    /**
     * 检测是否是需要动态判断的权限
     * @return boolean|null
     *      返回true则表示当前访问有权限
     *      返回false则表示当前访问无权限
     *      返回null，则表示权限不明
     *
     * @author 艺品网络  <twothink.cn>
     */
    protected function checkDynamic(){}


    /**
     * action访问控制,在 **登陆成功** 后执行的第一项权限检测任务
     *
     * @return boolean|null  返回值必须使用 `===` 进行判断
     *
     *   返回 **false**, 不允许任何人访问(超管除外)
     *   返回 **true**, 允许任何管理员访问,无需执行节点权限检测
     *   返回 **null**, 需要继续执行节点权限检测决定是否允许访问
     * @author 艺品网络  <twothink.cn>
     */
    final protected function accessControl(){
        $allow = config('allow_visit');
        $deny  = config('deny_visit');
        $check = strtolower($this->request->controller() . '/' . $this->request->action());
        if (!empty($deny) && in_array_case($check, $deny)) {
            return false; //非超管禁止访问deny中的方法
        }
        if (!empty($allow) && in_array_case($check, $allow)) {
            return true;
        }
        return null; //需要检测节点权限
    }
    /**
     * 返回后台节点数据
     * @param boolean $tree    是否返回多维数组结构(生成菜单时用到),为false返回一维数组(生成权限节点时用到)
     * @retrun array
     *
     * 注意,返回的主菜单节点数组中有'controller'元素,以供区分子节点和主节点
     *
     * @author 艺品网络  <twothink.cn>
     */
    final protected function returnNodes($tree = true){
        static $tree_nodes = array();

        if ( $tree && !empty($tree_nodes[(int)$tree]) ) {
            return $tree_nodes[$tree];
        }
        if((int)$tree){
            $list = Db::name('Menu')->field('id,pid,title,module,url,tip,hide')->order('sort asc')->select();
            foreach ($list as $key => $value) {
                if( stripos($value['url'],$value['module'])!==0  && !empty($value['url'])){
                    $list[$key]['url'] = $value['module'].'/'.$value['url'];
                }
            }
            $nodes = list_to_tree($list,$pk='id',$pid='pid',$child='operator',$root=0);
            foreach ($nodes as $key => $value) {
                if(!empty($value['operator'])){
                    $nodes[$key]['child'] = $value['operator'];
                    unset($nodes[$key]['operator']);
                }
            }
        }else{
            $nodes = Db::name('Menu')->field('id,title,module,url,tip,pid')->order('sort asc')->select();
            foreach ($nodes as $key => $value) {
                if( stripos($value['url'],$value['module'])!==0 && !empty($value['url'])){
                    $nodes[$key]['url'] = $value['module'].'/'.$value['url'];
                }
            }
        }
        $tree_nodes[(int)$tree]   = $nodes;
        return $nodes;
    }
    /*
     * @title 空操作
     * @author 小矮人 82550565@qq.com
     */
    public function _empty(){
        $action = $this->request->action();
        if(method_exists($this,'_'.$action)){
            return call_user_func([$this,'_'.$action]);
        }else{
            $model_info = Modelinfo()->info($this->model_info)->getParam('info');
            if(!empty($model_info['action']) && method_exists($this,$model_info['action'])){
                $action = $model_info['action'];
                return $this->$action();
            }else{
                $this->error($action.'不存在');
            }
        }
    }
    /**
     * @title        列表
     * @author 小矮人 82550565@qq.com
     * $arr ['tpl'=>模版]
     */
    public function _index(){
        $model_info = modelinfo()->getList($this->model_info);
        if($this->request->isPost()){
            $model_info['data']['code'] = 1;
            return $model_info['data'];
        }
        $model_info['meta_title'] = isset($model_info['meta_title'])?$model_info['meta_title']:$this->request->controller().'列表';
        if(!isset($model_info['title_bar']) && $model_info['meta_title']){
            $model_info['title_bar'] = $model_info['meta_title'];
        }else{
            $model_info['title_bar'] = $model_info['title_bar'].'列表';
        }
        $this->two_assign['model_info'] = $model_info;
        $this->two_assign['meta_title'] = $model_info['meta_title'];
        $this->two_assign['title_bar'] = $model_info['title_bar'];
        $this->assign($this->two_assign);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $tpl = 'base/list';
        if(isset($model_info['template']) && $model_info['template']){
            $tpl = $model_info['template'];
        }elseif (isset($model_info['template_list']) && $model_info['template_list']){
            $tpl = $model_info['template_list'];
        }
        return $this->fetch($tpl);
    }
    /**
     * @title        新增
     * @author 艺品网络 593657688@qq.com
     * $arr ['tpl'=>模版]
     */
    public function _add(){
        if($this->request->isPost()){
            $this->_updates();
        }else{
            $model_info = modelinfo()->getAdd($this->model_info);
            $model_info['meta_title'] = isset($model_info['meta_title'])?$model_info['meta_title']:$this->request->controller().'新增';
            if(!isset($model_info['title_bar']) && $model_info['meta_title']){
                $this->two_assign['title_bar'] = $model_info['meta_title'];
            }else{
                $this->two_assign['title_bar'] = $model_info['title_bar'].'新增';
            }
            $this->two_assign['model_info'] = $model_info;
            $this->two_assign['meta_title'] = $model_info['meta_title'];
            $this->two_assign['data'] = $model_info['field_default_value'];

            $this->assign($this->two_assign);
            // 记录当前列表页的cookie
            Cookie('__forward__',$_SERVER['REQUEST_URI']);
            $tpl = 'base/add';
            if(isset($model_info['template']) && $model_info['template']){
                $tpl = $model_info['template'];
            }elseif (isset($model_info['template_add']) && $model_info['template_add']){
                $tpl = $model_info['template_add'];
            }
            return $this->fetch($tpl);
        }
    }
    /**
     * @title        编辑
     * @author 艺品网络 593657688@qq.com
     * $arr ['tpl'=>模版]
     */
    public function _edit(){
        $id = $this->request->param('id');
        $id || $this->error('缺少唯一参数');

        if($this->request->isPost()){
            $this->_updates();
        }else{
            $model_info = modelinfo()->getEdit($this->model_info);

            $this->two_assign['data'] = $model_info['data'];
            $this->two_assign['model_info'] = $model_info;
            $model_info['meta_title'] = isset($model_info['meta_title'])?$model_info['meta_title']:$this->request->controller().'编辑';
            if(!isset($model_info['title_bar']) && $model_info['meta_title']){
                $model_info['title_bar'] = $model_info['meta_title'];
            }else{
                $model_info['title_bar'] = $model_info['title_bar'].'编辑';
            }
            $this->two_assign['meta_title'] = $model_info['meta_title'];
            $this->two_assign['title_bar'] = $model_info['title_bar'];

            $this->assign($this->two_assign);
            // 记录当前列表页的cookie
            Cookie('__forward__',$_SERVER['REQUEST_URI']);
            $tpl = 'base/edit';
            if(isset($model_info['template']) && $model_info['template']){
                $tpl = $model_info['template'];
            }elseif (isset($model_info['template_edit']) && $model_info['template_edit']){
                $tpl = $model_info['template_edit'];
            }
            return $this->fetch($tpl);
        }
    }
    /**
     * @title       新增|编辑 数据处理
     * @author 小矮人 82550565@qq.com
     */
    public function _updates(){
        try{
            $model_obj  = modelinfo();
            $res = $model_obj->getUpdate($this->model_info);
            $res || $this->error( $model_obj->getError());

            $param =$this->request->param();
            $info = modelinfo()->info($this->model_info)->getParam('info');
            if(!isset($info['pk']) || empty($info['pk'])){
                $info['pk'] = 'id';
            }
            $this->success(!empty($param[$info['pk']])?'更新成功':'新增成功');
        }
        catch (Exception $e){
            $this->error($e->getMessage());
        }
    }
    /*
     * @title 数据真删除
     * @param $model 表名或模型对象
     * @param $pk 主键
     * @author 小矮人 82550565@qq.com
     */
    public function _del($model='',$pk='id'){
        if(empty($model)){
            extract($this->request->param());
        }
        empty($model)&&$this->error('model参数必须');
        $ids    =   input('ids/a');
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        $map[$pk] = ['in',$ids];
        $model = is_object($model)?$model:Db::name($model);
        if($model->where($map)->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
     * @author 艺品网络  <twothink.cn>
     *
     * @return array|false
     * 返回数据集
     */
    protected  function lists ($model,$where=array(),$order='',$field=true){
        $options    =   array();
        $REQUEST    =  (array)input('request.');
        if(is_string($model)){
            $model  =   Db::name($model);
        }
        $pk         =   $model->getPk();

        if($order===null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);

        if(empty($where)){
            $where  =   array('status'=>array('egt',0));
        }
        if( !empty($where)){
            $options['where']   =   $where;
        }

        $total        =   $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = config('list_rows') > 0 ? config('list_rows') : 10;
        }
        // 分页查询
        $list = $model->where($options['where'])->order($order)->field($field)->paginate($listRows);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('_page', $page);
        $this->assign('_total',$total);
        if($list && !is_array($list)){
            $list=$list->toArray();
        }
        return $list['data'];//TODO 可以返回带分页的$list
    }
    /**
     * 设置一条或者多条数据的状态
     * $model 表名
     * $pk 主键
     */
    public function setstatus($model=false,$pk='id'){
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
            case 0  :
                $this->forbid($model, $map,['success'=>'禁用成功','error'=>'禁用失败']);
                break;
            case 1  :
                $this->resume($model, $map,['success'=>'启用成功','error'=>'启用失败']);
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
        $this->editRow(   $model , $data, $where, $msg);
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
        $id=input('id/a');
        if(!empty($id)){
            $id    = array_unique($id);
            $id    = is_array($id) ? implode(',',$id) : $id;
            //如存在id字段，则加入该条件
            $fields = db()->getTableFields(Config::get('database.prefix').$model);
            if(in_array('id',$fields) && !empty($id)){
                $where = array_merge( ['id' => ['in', $id]] ,(array)$where );
            }
        }
        $msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>var_export(Request()->isAjax(), true)) , (array)$msg );
        if(!$msg['url'])
            $msg['url'] = url('index');
        if(is_string($model))
            $model = db($model);
        if( $model->where($where)->update($data)!==false ) {
            $this->success($msg['success'],$msg['url'],$msg['ajax']);
        }else{
            $this->error($msg['error'],$msg['url'],$msg['ajax']);
        }
    }
    /**
     * 模板变量赋值
     * @access protected
     * @param mixed $name  要显示的模板变量
     * @param mixed $value 变量的值
     * @return void
     */
    protected function assign($name, $value = '')
    {
        $this->view->assign($name, $value);
        if (is_array($name)) {
            $this->two_assign = array_merge($this->two_assign, $name);
        } else {
            $this->two_assign[$name] = $value;
        }
    }
}