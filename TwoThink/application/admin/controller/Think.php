<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Db;
use app\common\controller\ModelSystem;
/**
 * 模型数据管理控制器
 * @author 小矮人 <82550565@qq.com>
 */
class Think extends Admin {

    /**
     * 显示指定模型列表数据
     * @param  String $model 模型标识
     * @author 小矮人 <82550565@qq.com>
     */
    public function listquery($model = null){
        $model || $this->error('模型名标识必须！');
        //获取模型信息
        $model = Db::name('Model')->getByName($model);
        $model || $this->error('模型不存在！');
        $model_obj = new ModelSystem();
        $model_obj = $model_obj->info($model['id'],true,true)->getListField();

        if(!$this->request->isPost()){
            $model_info = $model_obj->getParam('info');
            $model_info['url'] = $this->request->url();
            $this->assign('model_info',$model_info);
            $this->assign('meta_title','本页面只作为数据的展示');
            $this->assign('meta_bar','['.$model_info['title'].']列表');
            $template_list = !empty($model['template_list'])?$model['template_list']:'base/list';
            return $this->fetch($template_list);
        }else{
            $list = $model_obj->getSearchList() //获取搜索配置
                    ->getWhere() //拼装搜索条件
                    ->getViewList() //列表查询
                    ->parseList()->parseListIntent()
                    ->getParam('info.data');
            $list['code'] = 1;
            return $list;
        }
    }

    public function del($model = null, $ids=null){
        $model = Db::name('Model')->find($model);
        $model || $this->error('模型不存在！');

        $ids = input('ids/a');

        if ( empty($ids) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $ids) );
        if(!Db::name(get_table_name($model['id']))->where($map)->delete())
            $this->error('删除失败！');
        if($model['extend']){
            //删除基础模型
            if(!Db::name(get_table_name($model['extend']))->where($map)->delete())
                $this->error('删除失败！');
        }
        $this->success('删除成功');
    }



    public function edit($model = null, $id = 0){
        //获取模型信息
        $model = Db::name('Model')->find($model);
        $model || $this->error('模型不存在！');

        if($this->request->isPost()){
            if($model['extend']){
                //更新基础模型
                $logic = logic($model['extend']);
                $res = $logic->editData();
                $res || $this->error($logic->getError());
            }
            //更新当前模型
            $logic = logic($model['id']);
            $res = $logic->editData();
            $res || $this->error($logic->getError());
            $this->success('保存'.$model['title'].'成功！', url('listquery?model='.$model['name']));
        } else {
            $model_obj = Modelinfo()->modelinfo($model['id'])->list_field();
            $data = $model_obj->Viewquery()->where('id','eq',$id)->find();
            $data || $this->error('数据不存在！');

            $this->assign('model_info', $model_obj->fields()->setInfo(['url'=>request()->url()])->Getparam('info'));
            $this->assign('data', $data);
            $this->assign('meta_title','编辑'.$model['title']);
            return $this->fetch($model['template_edit']?$model['template_edit']:'base/edit');
        }
    }

    public function add($model = null){
        //获取模型信息
        $model = Db::name('Model')->where('status','eq',1)->find($model);
        $model || $this->error('模型不存在！');
        if($this->request->isPost()){
            if($model['extend']){
                //新增基础模型
                $logic = logic($model['extend']);
                $res = $logic->editData();
                $res || $this->error($logic->getError());
            }
            //新增当前模型
            $logic = logic($model['id']);
            $res = $logic->editData();
            $res || $this->error($logic->getError());
            $this->success('添加'.$model['title'].'成功！', url('lists?model='.$model['name']));
        } else {
            $model_obj = Modelinfo()->modelinfo($model['id'])->list_field();

            $this->assign('model_info', $model_obj->fields()->setInfo(['url'=>request()->url()])->Getparam('info'));
            $this->assign('meta_title','新增'.$model['title']);
            return $this->fetch($model['template_add']?$model['template_add']:'base/add');
        }
    }
}