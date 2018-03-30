// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn> 
// +----------------------------------------------------------------------
namespace app\{$model_info['addons_module_name']}\controller;

use think\Controller;
/**
 * @title 代码由twothink代码生成器自动生成
 * @author 小矮人  <82550565@qq.com>
 */
class {$model_info['addons_controller_name']} extends {:parse_name($model_info['addons_module_name'],1)} {
    //自定义模型信息
    public $model_info = [
        'default'=>[
            'meta_title' => '标题',
            //表单提交地址
            'url' => '',
            //操作方法(方法不存在的时候起作用)
            'action'=>'',
            //特殊字符串替换用于列表定义解析
            'replace_string' => [['[DELETE]','[EDIT]'],['delete?ids=[id]','edit?id=[id]']],
            //按钮组
            'button'     => [
                ['title'=>'新增','url'=>'add','icon'=>'','class'=>'list_add btn-success','ExtraHTML'=>''],
                ['title'=>'删除','url'=>'del','icon'=>'','class'=>'btn-danger ajax-post confirm','ExtraHTML'=>'target-form="ids"'],
                ['title'=>'排序','url'=>'sort','icon'=>'','class'=>'btn-info list_sort','ExtraHTML'=>'']
            ],
            //表名
            'name' => '{$model_info['addons_table_name']}',
            //主键
            'pk' => 'id',
            //列表定义
            'list_grid'  => '{$model_info['list_grid']}',
           //自由组合的搜索字段  ['字段'=>'标题'] 为空取列表定义的
            'seach_field'=> [],
            //默认搜索条件[]填写查询条件
            'where'      => [],
            //固定搜索条件
            'where_solid' => [],
            //表单显示分组
            'field_group'=>'{$model_info['field_group']}',
            //表单显示排序
            "fields"=>[
            {volist name="model_info['fields']" id="vo"}
                '{$key}'=>[
                    {volist name="vo" id="value"}
                        ['name'=>'{$value.name}','title'=>'{$value.title}','remark'=>'{$value.remark}','type'=>'{$value.type}','extra'=>'{$value.extra}','value'=>'{$value.value}','is_show'=>'{$value.is_show}','is_must'=>'{$value.is_must}'],
                    {/volist}
                ],
            {/volist}
            ]
        ]
    ];
}