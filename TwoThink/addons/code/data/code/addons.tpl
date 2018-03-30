// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn>
// +----------------------------------------------------------------------
namespace addons\{$model_info['addons_table_name']}\controller;

use app\home\controller\Addons;
use think\Db;
use addons\{$model_info['addons_table_name']}\model\{$model_info['addons_controller_name']} as {$model_info['addons_controller_name']}Model;

/*
 * @title 广告位 内容管理
 * @Author 小矮人 <82550565@qq.com> twothink.cn
 */
class {$model_info['addons_controller_name']} extends Addons{
    public $model_info = [
        'default'=>
        [
            'name' => '{$model_info['addons_table_name']}',
            'url' => false,
            'field_group'=>'{$model_info['field_group']}',
            "fields"=>[
            {volist name="model_info['fields']" id="vo"}
                '{$key}'=>[
                {volist name="vo" id="value"}
                    ['name'=>'{$value.name}','title'=>'{$value.title}','remark'=>'{$value.remark}','type'=>'{$value.type}','extra'=>'{$value.extra}','value'=>'{$value.value}','is_show'=>'{$value.is_show}','is_must'=>'{$value.is_must}'],
                {/volist}
                ],
            {/volist}
            ],
            'list_grid' => [        //这里定义的是除了id序号外的表格里字段显示的表头名和模型一样支持函数和链接
                {$model_info['list_grid']}
            ]
        ]
    ];
    /* @title 列表页
     * @Author 小矮人 <82550565@qq.com> twothink.cn
     */
    public function index(){
        $getList = $this->getList($this->model_info);
        if($this->request->isPost()){
            return json($getList['list']);
        }else{
            $this->assign($getList);
            Cookie('__forward__',$_SERVER['REQUEST_URI']);
            //模版主题
            if($admin_view_path = config('admin_view_path'))
                $admin_view_path = $admin_view_path.'/';
            return $this->fetch(T('admin://admin@'.$admin_view_path.'addons/adminlist'));
        }
    }
    /* @title 编辑页
     * @Author 小矮人 <82550565@qq.com> twothink.cn
     */
    public function edit(){
        $get_data = $this->getEdit($this->model_info);
        $model = new {$model_info['addons_controller_name']}Model();
        if($this->request->isPost()){
            $res = $model->editData();
            !$res && $this->error($model->getError());
            $this->success(!empty($this->request->param('id'))?'更新成功':'新增成功', Cookie('__forward__'));
        }else{
            if($admin_view_path = config('admin_view_path'))
                $admin_view_path = $admin_view_path.'/';
            return $this->fetch(T('admin://admin@'.$admin_view_path.'addons/edit'));
        }
    }
    /* @title 更新数据状态
     * @Author 小矮人 <82550565@qq.com> twothink.cn
     */
    public function setstatus(){
        $this->setState('{$model_info['addons_table_name']}');
    }
}