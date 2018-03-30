<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn> 
// +----------------------------------------------------------------------
namespace addons\code\model;
use app\common\model\AddonsBase;

/**
 * code模型
 * @Author 小矮人 <82550568@qq.com>
 */
class Table extends AddonsBase{
    public $param;
    public $file_path = '../addons/code/data/form/';
    public $data; //table 表数据集 info配置数据集

    public function initialize()
    {
        if(!$this->param)
            $this->param = request()->param();
        if(!$this->data['info']['name'])
            $this->data['info']['name'] = $this->param['addons_table_name'];
        parent::initialize();
        $this->generate();
        $this->modelAttr();
    }

    /**
     * 根据数据表生成模型及其属性数据
     * @author 艺品网络  <twothink.cn>
     */
    protected function generate(){
        $table = config('database.prefix').$this->param['addons_table_name'];

        $fields = db()->query('SHOW FULL COLUMNS FROM '.$table);
        $fields = array_map('array_change_key_case', $fields);
        //生成属性数据
        $data = array();
        $attribute_from_type = config('attribute_from_type');
        foreach ($fields as $key=>$value){
            //根据字段定义生成合适的数据类型
            if(preg_match('/(.*?)\(/',$value['type'],$matches)){
                $value['type'] = $attribute_from_type[$matches[1]];
            }
            $value['group'] = 1;
            $value['is_show'] = 1;
            $data[] = $value;
        }
        $this->data['table']['field'] = $data;
        return $this;
    }

    /*
     * @title 获取保存的配置模型信息
     * @tableName string 表名不带表前缀
     * @Author 小矮人 <82550568@qq.com>
     */
    protected function modelAttr()
    {
        $tableName = $this->param['addons_table_name'];
        $file_path = $this->file_path.$tableName.'.json';
        $data = false;
        if(file_exists($file_path)) {
            $str = file_get_contents($file_path);
            $data = json_decode($str, true);
        }
        $this->data['info'] = $data;
        return $this;
    }
    /*
     * @title 生成代码 解析模型信息组合模型配置
     * @tableName string 表名不带表前缀
     * @Author 小矮人 <82550568@qq.com>
     */
    public function code_info()
    {
        $this->sort();
        return $this->data['info'];
    }

    /*
     * @title 字段排序
     * @Author 小矮人 <82550568@qq.com>
     */
    public function sort()
    {
        $str = $this->data['info'];
        $fields = $str['field'];
        // 获取模型排序字段
        if(isset($str['field_sort'])){
            $field_sort = $str['field_sort'];
            foreach($field_sort as $group => $ids){
                $ids = array_filter($ids);
                foreach($ids as $key => $value){
                    $fields[$value]['group']  =  $group;
                    $fields[$value]['sort']   =  $key;
                }
            }
        }
        if(!$fields){
            return $this;
        }
        foreach ($fields as $key=>$value){
            if($value['is_show'] == '0')
                unset($fields[$key]);
        }

        // 字段列表排序
        $fields = list_sort_by($fields,"sort");
        foreach ($fields as $key=>$value){
            $fields_arr[$value['group']][] = $value;
        }
        $this->data['info']['fields'] = $fields_arr;
        return $this;
    }
}