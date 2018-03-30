<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn> 
// +----------------------------------------------------------------------
namespace app\admin\widget;

use think\Controller;
use think\Db;
use app\admin\model\Modelmodel;
class Model extends Controller {
    /*
     * @title 字段管理
     * @Author 小矮人 <82550568@qq.com>
     */
    public function fields($data)
    {
        $Two_assign['fields'] = $this->field($data);
        $Two_assign['data'] = $data;
        $this->assign($Two_assign);
        return $this->fetch('widget/model_fields');
    }
    /*
     * @title 字段排序
     * @Author 小矮人 <82550568@qq.com>
     */
    public function sort($data)
    {
        $Two_assign['fields'] = $this->field($data);
        $Two_assign['data'] = $data;
        $this->assign($Two_assign);
        return $this->fetch('widget/model_sort');
    }
    /*
     * @title 获取模型字段
     * @Author 小矮人 <82550568@qq.com>
     */
    public function field($data){
        //获取所有父级模型
        if(!$model_list = get_parent_model($data['id']))
            return false;
        $fields = Db::name('Attribute')->where('model_id','in',arr2str(Array_mapping($model_list,'id','id')))->column('id,name,title,is_show');
        $fields = empty($fields) ? array() : $fields;

        // 梳理属性的可见性
        foreach ($fields as $key=>$field){
            if (!empty($data['attribute_list']) && !in_array($field['id'], $data['attribute_list'])) {
                $fields[$key]['is_show'] = 0;
            }
        }

        // 获取模型排序字段
        $field_sort = json_decode($data['field_sort'], true);
        if(!empty($field_sort)){
            foreach($field_sort as $group => $ids){
                foreach($ids as $key => $value){
                    $fields[$value]['group']  =  $group;
                    $fields[$value]['sort']   =  $key;
                }
            }
        }
        // 模型字段列表排序
        return list_sort_by($fields,"sort");
    }
    //模型搜索配置扩展
    public function search($name,$model_id,$data){
        $model = new Modelmodel();
        $fields = $model->getModelField($model_id);
        $this->assign('fields',$fields);
        $this->assign('name',$name);
        $this->assign('data',$data);
        return $this->fetch('widget/search');
    }
    public function searchfixed($name,$model_id,$data){

        $model = new Modelmodel();
        $fields = $model->getModelField($model_id);
        $this->assign('fields',$fields);
        $this->assign('name',$name);
        $this->assign('data',$data);
        return $this->fetch('widget/searchfixed');
    }
}