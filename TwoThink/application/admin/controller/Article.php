<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;
use think\modelinfo\System;
use app\common\controller\Menu;
use app\admin\model\AuthGroup;

/**
 * 后台内容控制器
 * @author 艺品网络  <twothink.cn>
 */
class Article extends Admin {

    /* 保存允许访问的公共方法 */
    static protected $allow = array( 'draftbox','mydocument');

    private $cate_id        =   null; //文档分类id
    /*
         * @title 动态扩展菜单
         */
    protected function extra_menu(){
        $obj = new Menu();
        $category =  $obj->getCategory();
        return $category;
    }

    /**
     * 检测需要动态判断的文档类目有关的权限
     *
     * @return boolean|null
     *      返回true则表示当前访问有权限
     *      返回false则表示当前访问无权限
     *      返回null，则会进入checkRule根据节点授权判断权限
     */
    protected function checkDynamic(){
        $cates = AuthGroup::getAuthCategories(UID);
        switch(strtolower($this->request->action())){
            case 'index':   //文档列表
            case 'add':   // 新增
                $cate_id =  input('cate_id');
                break;
            case 'edit':    //编辑
            case 'update':  //更新
                $doc_id  =  input('id');
                $cate_id =  Db::name('Document')->where(array('id'=>$doc_id))->value('category_id');
                break;
            case 'setstatus': //更改状态
            case 'permit':    //回收站
                $doc_id  =  (array)input('ids');
                $cate_id =  Db::name('Document')->where(array('id'=>array('in',$doc_id)))->column('category_id',true);
                $cate_id =  array_unique($cate_id);
                break;
        }
        if(!$cate_id){
            return null;//不明
        }elseif( !is_array($cate_id) && in_array($cate_id,$cates) ) {
            return true;//有权限
        }elseif( is_array($cate_id) && $cate_id==array_intersect($cate_id,$cates) ){
            return true;//有权限
        }else{
            return false;//无权限
        }
    }

    /**
     * 分类文档列表页
     * @param integer $cate_id 分类id
     * @param url article/index?cate_id=44 查询44分类列表
     */
    public function index($cate_id = 2){
        $param = $this->request->param();
        if($cate_id===null)
            $cate_id = $this->cate_id;
        // 获取分类绑定的模型
        $pid = isset($param['pid']) && !empty($param['pid'])?$param['pid']:0;
        if ($pid == 0) {
            $category_model_id     =   get_category($cate_id,'model');
            // 获取分组定义
            $groups		=	get_category($cate_id, 'groups');
            if($groups){
                $groups	=	parse_field_attr($groups);
            }
        }else{ // 子文档列表
            $category_model_id     =   get_category($cate_id, 'model_sub');
        }
        $category_model_id || $this->error('该分类未绑定模型');
        $model = $model_id = explode(',', $category_model_id);
        $model_id = !is_array($model_id)? $model_id:$model_id['0'];

        //绑定多个模型获取基础模型的列表定义(即分支模型V形模型)
        if(!is_numeric($category_model_id)){
            $model_type = 2;
        }else{
            $model_type = 1;
        }

        $ModelSystem = (new System(['type'=>$model_type]))->info($model_id)->getListField()->getSearchList();
        $model_info = $ModelSystem->getParam('info');

        if($this->request->isPost()){
            // 列表查询
            $list   =   $ModelSystem->getSearchList()->getWhere()->getViewList()->parseList()->parseListIntent(false,false,[['[DELETE]','[EDIT]','[LIST]'],['setstatus?status=-1&ids=[id]&cate_id=[category_id]','edit?id=[id]&model=[model_id]&cate_id=[category_id]','index?pid=[id]&model=[model_id]&cate_id=[category_id]']])->getParam('info.data');
            $list['code'] = 1;
            return $list;
        }

        $this->assign('meta_title', '内容管理');
        //获取面包屑信息
        /*文档列表面包屑*/
        if($nav_crumbs= get_parent_category($cate_id)){
            foreach ($nav_crumbs as $key=>$value){
                $nav_crumbs[$key]['url'] = url('index',['cate_id'=>$value['id']]);
            }
            $title_bar[] =[
                    'title' =>'文档列表',
                    'extra' => $nav_crumbs
                ];
        }
        /*模型列表面包屑*/
        $model_crumbs = false;
        if(!empty($model)){
            foreach ($model as $value){
                $model_crumbs[] = [
                    'url' => url('index',array('pid'=>$pid,'cate_id'=>$cate_id,'model_id'=>$value)),
                    'title' => get_document_model($value,'title')
                ];
            }
            $title_bar[] =[
                'title' =>'模型',
                'extra' => $model_crumbs
            ];
        }
        $this->assign('title_bar',$title_bar);
        //模型定义
        $model_info['pk'] = 'id';
        if(count($model) > 1){
            foreach ($model as $value){
                $add_button[] = ['title'=>get_document_model($value,'title'),'url'=>'article/add?cate_id='.$cate_id.'&model_id='.$value.'&pid='.$pid,'class'=>'ajax-get iframe'];
            }
            $add_button = ['title'=>'新增','type'=>'select','extra'=>$add_button,'class'=>'bg-aqua'];
        }else{
            $add_button = ['title'=>'新增','url'=>'article/add?cate_id='.$cate_id.'&pid='.$pid.'&model_id='.$model_id,'class'=>'bg-aqua ajax-get iframe','icon'=>'','ExtraHTML'=>''];
        }
        $model_info['button']     = [
            $add_button,
            ['title'=>'启用','url'=>'setstatus?status=1&cate_id='.$cate_id,'icon'=>'','class'=>'bg-teal ajax-post','ExtraHTML'=>'target-form="ids"'],
            ['title'=>'禁用','url'=>'setstatus?status=0&cate_id='.$cate_id,'icon'=>'','class'=>'bg-yellow ajax-post confirm','ExtraHTML'=>'target-form="ids"'],
            ['title'=>'删除','url'=>'setstatus?status=-1&cate_id='.$cate_id,'icon'=>'','class'=>'bg-red ajax-post confirm','ExtraHTML'=>'target-form="ids"']
        ];

        $model_info['url'] = $this->request->url();
        $this->assign('model_info',$model_info);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $tpl = !empty($model_info['template_list'])?'think/'.$model_info['template_list']:'base/list';
        return $this->fetch($tpl);
    }

    /**
     * 设置一条或者多条数据的状态
     */
    public function setStatus($cate_id=null,$pk='id'){
    	// 检查支持的文档模型
        if(!empty($cate_id)){
        	$modelList =   Db::name('Category')->getFieldById($cate_id,'model');   // 当前分类支持的文档模型
        }else{
        	$modelList = 1;
        }
    	$model = Db::name('Model')->getById($modelList);
    	if($model['extend'] == 0){
        	$model_name = $model['name'];
        }else{
        	$model_name = Db::name('Model')->getFieldById($model['extend'],'name');
        }
        return parent::setStatus($model_name,$pk);
    }

    /**
     * 文档新增页面初始化
     * @author 艺品网络  <twothink.cn>
     */
    public function add(){
        $cate_id    =   input('cate_id',0);
        $model_id   =   input('model_id',0);

        empty($cate_id) && $this->error('分类参数不能为空！');
        empty($model_id) && $this->error('该分类未绑定模型！');

        //检查该分类是否允许发布
        $allow_publish = check_category($cate_id);
        !$allow_publish && $this->error('该分类不允许发布内容！');
        if($this->request->isPost()){
            return $this->update();
        }
        // 获取模型信息
        $model_info = (new System())->info($model_id,false,true)->getFields()->FieldDefaultValue()->setInit()->getParam('info');

        //获取表单字段排序
        $model_info['url'] = $this->request->url();
        $this->assign('data',$model_info['field_default_value']);
        $this->assign('model_info', $model_info);
        $this->assign('meta_title','新增'.$model_info['title']);
        $tpl = !empty($model_info['template_add'])?'think/'.$model_info['template_add']:'base/add';
        return $this->fetch($tpl);
    }

    /**
     * 文档编辑页面初始化
     * @author 艺品网络  <twothink.cn>
     */
    public function edit(){
        if($this->request->isPost()){
            return $this->update();
        }

        $id     =   input('id','');
        if(empty($id)){
            $this->error('参数不能为空！');
        }
        $model_id = input('param.model',0);
        $cate_id =   input('param.cate_id',0);

        // 获取模型信息
        if(empty($model_id) && !empty($cate_id)){
        	$model_id =   Db::name('Category')->getFieldById($cate_id,'model');   // 当前分类支持的文档模型
        }

        $ModelSystem = modelinfo();
        $model_info = $ModelSystem->info($model_id,true,true)->getFields()->getQueryModel('logic')->getFind(['id'=>$id]);

        $model_info || $this->error($ModelSystem->getError());
        $model_info = $model_info->setInit()->getParam('info');
        $model_info['url'] = $this->request->url();

        // 获取当前的模型信息
        $this->assign('data', $model_info['data']);
        $this->assign('model_info', $model_info);
        $this->assign('meta_title', '编辑文档');
        $tpl = !empty($model_info['template_edit'])?'think/'.$model_info['template_edit']:'base/edit';
        return $this->fetch($tpl);
    }

    /**
     * 更新一条数据
     * @author 艺品网络  <twothink.cn>
     */
    public function update(){
    	/* 获取数据对象 */
    	$model_id = $this->request->param('model_id',0);
    	$data = $this->request->param();
    	if(!$model_id)
    		$this->error('模型id不能为空');
    	//获取模型信息
        $ModelSystem = modelinfo()->info($model_id);
        //自动验证
        $validate = $ModelSystem->getFields()->checkValidate();
        $validate || $this->error($ModelSystem->getError());

        $res = $ModelSystem->getQueryModel('logic')->getUpdate();
        $res || $this->error($ModelSystem->getError());
        $this->success(!empty($data['id'])?'更新成功':'新增成功', Cookie('__forward__'));
    }

    /**
     * 待审核列表
     */
    public function examine(){

        $map['status']  =   2;
        if ( !IS_ROOT ) {
            $cate_auth  =   AuthGroup::getAuthCategories(UID);
            if($cate_auth){
                $map['category_id']    =   array('IN',$cate_auth);
            }else{
                $map['category_id']    =   -1;
            }
        }
        $list = $this->lists(db('Document'),$map,'update_time desc');
        //处理列表数据
        if(is_array($list)){
            foreach ($list as $k=>&$v){
                $v['username']      =   get_nickname($v['uid']);
            }
        }

        $this->assign('list', $list);
        $this->assign('meta_title','待审核');
        return $this->fetch();
    }

    /**
     * 回收站列表
     * @param int $model_id 模型ID
     * @author 艺品网络  <twothink.cn>
     */
    public function recycle($model_id = 1){
        //获取模型信息
        $model = get_document_model($model_id);
        $this->model_info = $model_info = Modelinfo()->modelinfo($model['id'])->list_field()->Getparam('info');
        if($this->request->isPost()){
            $map['status']  =   -1;
            if ( !IS_ROOT ) {
                $cate_auth  =   AuthGroup::getAuthCategories(UID);
                if($cate_auth){
                    $map['category_id']    =   array('IN',$cate_auth);
                }else{
                    $map['category_id']    =   -1;
                }
            }
            $this->model_info['where_solid'] = $map;
            return parent::_index();
        }else{

            $this->assign('meta_title','回收站');
            //模型定义
            $model_info['pk'] = 'id';
            $model_info['button'] = [
                ['title'=>'清空','url'=>'clear?model_id='.$model_id,'icon'=>'','class'=>'btn-success ajax-post confirm','ExtraHTML'=>'target-form="ids"'],
                ['title'=>'还原','url'=>'permit?model_id='.$model_id,'icon'=>'','class'=>'btn-danger ajax-post confirm','ExtraHTML'=>'target-form="ids"']
            ];
            $this->assign('model_info',$model_info);
            return $this->fetch('base/list');
        }
    }

    /**
     * 写文章时自动保存至草稿箱
     * @author 艺品网络  <twothink.cn>
     */
    public function autoSave(){
        $res = model('Document')->autoSave();
        if($res !== false){
            $return['data']     =   $res;
            $return['info']     =   '保存草稿成功';
            $return['status']   =   1;
            return json($return);
        }else{
            $this->error('保存草稿失败：'.Db::name('Document')->getError());
        }
    }

    /**
     * 草稿箱
     * @author 艺品网络  <twothink.cn>
     */
    public function draftBox(){

        $Document   =   \think\Loader::model('Document','logic');
        $map        =   array('status'=>3,'uid'=>UID);
        $list       =   $this->lists($Document,$map);
        //获取状态文字
        //int_to_string($list);

        $this->assign('list', $list);
        $this->assign('meta_title','草稿箱');
        return $this->fetch();
    }

    /**
     * 我的文档
     * @author 艺品网络  <twothink.cn>
     */
    public function mydocument($status = null, $title = null){

        $Document   =   \think\Loader::model('Document','logic');
        /* 查询条件初始化 */
        $map['uid'] = UID;
        if(isset($title)){
            $map['title']   =   array('like', '%'.$title.'%');
        }
        if(isset($status)){
            $map['status']  =   $status;
        }else{
            $map['status']  =   array('in', '0,1,2');
        }
        $get_data = input();
        if ( isset($get_data['time-start']) ) {
            $map['update_time'][] = array('egt',strtotime(I('time-start')));
        }
        if ( isset($get_data['time-end']) ) {
            $map['update_time'][] = array('elt',24*60*60 + strtotime(I('time-end')));
        }
        //只查询pid为0的文章
        $map['pid'] = 0;
        $list = $this->lists($Document,$map,'update_time desc');
        int_to_string($list);
//         $list = $this->parseDocumentList($list,1);

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->assign('meta_title','我的文档');
        return $this->fetch();
    }

    /**
     * 还原被删除的数据
     * @author 艺品网络  <twothink.cn>
     */
    public function permit(){
        /*参数过滤*/
        $data = $this->request->param();
        $ids = $data['id'];
        if(empty($ids)){
            $this->error('请选择要操作的数据');
        }
        //获取模型信息
        $model = get_document_model($data['model_id']);
        if($model['extend'] > 0){
        	$model_name =get_document_model($model['extend'],'name');
        }else{
        	$model_name = $model['name'];
        }
        /*拼接参数并修改状态*/
        $Model  =   $model_name;
        $map    =   array();
        if(is_array($ids)){
            $map['id'] = array('in', $ids);
        }elseif (is_numeric($ids)){
            $map['id'] = $ids;
        }
        $this->restore($Model,$map);
    }

    /**
     * 清空回收站
     * @author 艺品网络  <twothink.cn>
     */
    public function clear($model_id){

    	//获取模型信息
    	$model = get_document_model($model_id);
    	if($model['extend'] > 0){
    		$model_id =get_document_model($model['extend'],'id');
    	}
    	$model = logic($model_id,'Documentbase');
        $res = $model->remove();
        if($res !== false){
            $this->success('清空回收站成功！');
        }else{
            $this->error('清空回收站失败！');
        }
    }

    /**
     * 移动文档
     * @author 艺品网络  <twothink.cn>
     */
    public function move() {
    	$data= input('ids/a');
        if(empty($data)) {
            $this->error('请选择要移动的文档！');
        }
        session('moveArticle', $data);
        session('copyArticle', null);
        $this->success('请选择要移动到的分类！');
    }

    /**
     * 拷贝文档
     * @author 艺品网络  <twothink.cn>
     */
    public function copy() {
    	$data= input('ids/a');
        if(empty($data)) {
            $this->error('请选择要复制的文档！');
        }
        session('copyArticle', $data);
        session('moveArticle', null);
        $this->success('请选择要复制到的分类！');
    }

    /**
     * 粘贴文档
     * @author 艺品网络  <twothink.cn>
     */
    public function paste() {
        $moveList = session('moveArticle');
        $copyList = session('copyArticle');
        if(empty($moveList) && empty($copyList)) {
            $this->error('没有选择文档！');
        }
        $post_data = input('param.');
        if(!isset($post_data['cate_id'])) {
            $this->error('请选择要粘贴到的分类！');
        }
        $cate_id = $post_data['cate_id'];   //当前分类
        $pid = input('post.pid',0);        //当前父类数据id
        //检查所选择的数据是否符合粘贴要求
        $check = $this->checkPaste(empty($moveList) ? $copyList : $moveList, $cate_id, $pid);
        if(!$check['status']){
            $this->error($check['info']);
        }

        if(!empty($moveList)) {// 移动    TODO:检查name重复
            foreach ($moveList as $key=>$value){
                $Model              =   db('Document');
                $map['id']          =   $value;
                $data['category_id']=   $cate_id;
                $data['pid']        =   $pid;
                //获取root
                if($pid == 0){
                    $data['root'] = 0;
                }else{
                    $p_root = $Model->getFieldById($pid, 'root');
                    $data['root'] = $p_root == 0 ? $pid : $p_root;
                }
                $res = $Model->where($map)->save($data);
            }
            session('moveArticle', null);
            if(false !== $res){
                $this->success('文档移动成功！');
            }else{
                $this->error('文档移动失败！');
            }
        }elseif(!empty($copyList)){ // 复制
            foreach ($copyList as $key=>$value){
            	// 检查支持的文档模型
            	if($pid){
            		$modelList =   Db::name('Category')->getFieldById($cate_id,'model_sub');   // 当前分类支持的文档模型
            	}else{
            		$modelList =   Db::name('Category')->getFieldById($cate_id,'model');   // 当前分类支持的文档模型
            	}
            	$model = Db::name('Model')->getById($modelList);
            	if($model['extend'] == 0){
            		$Model = logic($model['id'],'Documentbase');
            	}else{
            		$Model = logic($model['extend'],'Documentbase');
            	}
                $Model  =   Db::name('Document');
                $data   =   $Model->find($value);
                unset($data['id']);
                unset($data['name']);
                $data['category_id']    =   $cate_id;
                $data['pid']            =   $pid;
                $data['create_time']    =   time();
                $data['update_time']    =   time();
                //获取root
                if($pid == 0){
                    $data['root'] = 0;
                }else{
                    $p_root = $Model->getFieldById($pid, 'root');
                    $data['root'] = $p_root == 0 ? $pid : $p_root;
                }
                $result   =  $Model->insertGetId($data);
                if($result){
                    $logic      =   logic($data['model_id']);
                    $data       =   $logic->detail($value); //获取指定ID的扩展数据

                    $data['id'] =   $result;
                    $res        =   $logic->insert($data);
                }
            }
            session('copyArticle', null);
            if($res){
                $this->success('文档复制成功！');
            }else{
                $this->error('文档复制失败！');
            }
        }
    }

    /**
     * 检查数据是否符合粘贴的要求
     * @author 艺品网络  <twothink.cn>
     */
    protected function checkPaste($list, $cate_id, $pid){
        $return     =   array('status'=>1);
        // 检查支持的文档模型
        if($pid){
            $modelList =   Db::name('Category')->getFieldById($cate_id,'model_sub');   // 当前分类支持的文档模型
        }else{
            $modelList =   Db::name('Category')->getFieldById($cate_id,'model');   // 当前分类支持的文档模型
        }
        $model = Db::name('Model')->getById($modelList);
        if($model['extend'] == 0){
        	$Document = logic($model['id'],'Documentbase');
        }else{
        	$Document = logic($model['extend'],'Documentbase');
        }
        foreach ($list as $key => $value){
            //不能将自己粘贴为自己的子内容
            if($value == $pid){
                $return['status'] = 0;
                $return['info'] = '不能将编号为 '.$value.' 的数据粘贴为他的子内容！';
                return $return;
            }
            // 移动文档的所属文档模型
            $modelType  =   $Document->getFieldById($value,'model_id');
            if(!in_array($modelType,explode(',',$modelList))) {
                $return['status'] = 0;
                $return['info'] = '当前分类的文档模型不支持编号为 '.$value.' 的数据！';
                return $return;
            }
        }

        // 检查支持的文档类型和层级规则
        $typeList =   Db::name('Category')->getFieldById($cate_id,'type'); // 当前分类支持的文档模型
        foreach ($list as $key=>$value){
            // 移动文档的所属文档模型
            $modelType  =   $Document->getFieldById($value,'type');
            if(!in_array($modelType,explode(',',$typeList))) {
                $return['status'] = 0;
                $return['info'] = '当前分类的文档类型不支持编号为 '.$value.' 的数据！';
                return $return;
            }
            $res = $Document->checkDocumentType($modelType, $pid);
            if(!$res['status']){
                $return['status'] = 0;
                $return['info'] = $res['info'].'。错误数据编号：'.$value;
                return $return;
            }
        }

        return $return;
    }
}
