<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn> 
// +----------------------------------------------------------------------
namespace addons\code\controller;
use app\admin\controller\Addons;
use addons\code\model\Table as TableModel;
use app\common\controller\Modelinfo;

/*
 * model_info代码生成器
 * @Author 苹果 593657688@qq.com
 */
class Table extends Addons{
    public $model_info=[
        'design'=>[
            //表单显示排序
            "fields"=>[
                '1'=>[
                    ['name'=>'field_group','title'=>'表单显示分组','type'=>'string','remark'=>'用于表单显示的分组，以及设置该模型表单排序的显示[1:基础,2:扩展]','value'=>'1:基础','is_show'=>1],
                    ['name'=>'','title'=>'表单显示排序','type'=>'function','extra'=>':addons_action(addons://code/table/sort, ,controller)','remark'=>'直接拖动进行排序','is_show'=>1],
                    ['name'=>'list_grid','title'=>'列表定义','type'=>'textarea','extra'=>'','remark'=>'默认列表模板的展示规则','is_show'=>1],
//                    ['name'=>'search_key','title'=>'默认搜索字段','type'=>'string','extra'=>'','remark'=>'默认列表模板的默认搜索项','is_show'=>1],
//                    ['name'=>'search_list','title'=>'高级搜索字段','type'=>'string','extra'=>'','remark'=>'默认列表模板的高级搜索项','is_show'=>1]
                ]
            ]
        ]
    ];
    public $param;
    public function _initialize()
    {
        $this->param = $this->request->param();
        parent::_initialize();
    }
    public function field()
    {
        $TableModel = new TableModel();
        $list = $TableModel->getparam('data.table.field');
        $data = $TableModel->getparam('data.info.field');
        $this->assign('list',$list);
        $this->assign('data',$data);
        $html = $this->fetch(T('addons://code@table/field'));
        $this->success('','',$html);
    }
    //模型设计
    public function design(){
        $model_info = $this->model_info['design'];
        $obj = new TableModel();
        if(!$data = $obj->getparam('data.info'))
            $data = Modelinfo()->FieldDefaultValue($model_info['fields'])->Getparam('info.field_default_value');
        $this->assign('data',$data);
        $this->assign('model_info',$model_info);
        $theme = config('admin_view_path');
        $html = $this->fetch(T("admin://admin@{$theme}/base/input"));
        $this->success('','',$html);
    }
    //表单显示排序
    public function sort(){
        $obj = new TableModel();
        $model_info = $obj->sort()->getparam('data.info');
        $this->assign('model_info',$model_info);
        return $this->fetch(T("addons://code@table/sort"));

    }
    //生成代码
    public function grcode(){
        $param = $this->request->param();
        $obj = new TableModel();
        $model_info = $obj->code_info();
        $this->assign('model_info',$model_info);
        $file_path = '../addons/code/data/code/'.$param['addons_module_name'].'.tpl';
        if(!file_exists($file_path)){
            $file_path = '../addons/code/data/code/base.tpl';
        }
        $code = $this->fetch($file_path);
        $this->success('','',$code);
    }
    //配置处理解析
    public function info(){
        $path = '../addons/code/data/form/'.$this->param['addons_table_name'].'.json';
        $data = json_encode($this->param);
        $file = fopen($path, "w") or die("Unable to open file!");
        fwrite($file, $data);
        fclose($file);
        $this->success('配置保存成功');
    }
}