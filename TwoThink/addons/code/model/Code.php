<?php

namespace addons\code\model;
use app\common\model\AddonsBase;

/**
 * code模型
 */
class code extends AddonsBase{
    public $model_info = [
        'name' => 'code',
        'button' => [
            ['title'=>'新增','url'=>'edit?name=code','icon'=>'','class'=>'ajax-get iframe bg-aqua','ExtraHTML'=>''],
            ['title'=>'删除','url'=>'del?name=code','icon'=>'','class'=>'btn-danger ajax-post confirm','ExtraHTML'=>'']
        ],
        //特殊字符串替换用于列表定义解析
        'replace_string' => [['[DELETE]','[EDIT]','[ADDON]'],['del?ids=[id]&name=[ADDON]','edit?id=[id]&name=[ADDON]','code']],
        'field_group'=>'1:基础,2:扩展',//表单显示分组
        "fields"=>[
            '1'=>[
                [
                    'name'=>'id',//字段名
                    'title'=>'ID',//显示标题
                    'type'=>'num',//字段类型
                    'remark'=>'',// 备注，相当于配置里的tip
                    'is_show'=>3,// 1-始终显示 2-新增显示 3-编辑显示 0-不显示
                    'value'=>0,//默认值
                ], 
            ],
            '2'=>[
                [
                    'name'=>'id',//字段名
                    'title'=>'ID',//显示标题
                    'type'=>'num',//字段类型
                    'remark'=>'',// 备注，相当于配置里的tip
                    'is_show'=>3,// 1-始终显示 2-新增显示 3-编辑显示 0-不显示
                    'value'=>0,//默认值
                ], 
            ]
        ],
        'list_grid' => [        //这里定义的是除了id序号外的表格里字段显示的表头名和模型一样支持函数和链接
            'title:广告位名称',
            'type:广告位类型',
            'width:广告位宽度',
            'height:广告位高度',
            'status:位置状态',
            'id:操作:[EDIT]|编辑,[DELETE]|删除'
        ]
    ]; 
}
