<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn> 
// +----------------------------------------------------------------------
namespace addons\adver\controller;

//use app\home\controller\Addons;
use think\Db;

/*
 * @title 广告位 内容管理
 * @Author 小矮人 <82550565@qq.com> twothink.cn
 */
class Advertising extends \think\addons\Controller {
    public $model_info = [
        'default'=>
        [
            'name' => 'advsr_details',
            'url' => true,
            'button' => [
                ['title'=>'新增','url'=>'admin/addons/execute?_addons=adver&_controller=advertising&_action=edit&adver_id=[adver_id]','icon'=>'','class'=>'ajax-get iframe btn-success','ExtraHTML'=>''],
                ['title'=>'删除','url'=>'admin/addons/execute?_addons=adver&_controller=advertising&_action=setstatus&status=del','icon'=>'','class'=>'btn-danger ajax-post confirm','ExtraHTML'=>'target-form="ids"']
            ],
            //特殊字符串替换用于列表定义解析
            'replace_string' => [
                ['[ADDONPATH]','[DELETE]','[EDIT]','[ADDONSETUS]'],
                [   'admin/addons/execute?_addons=adver&_controller=advertising&_action',
                    'admin/addons/execute?_addons=adver&_controller=advertising&_action=setstatus&ids=[id]&status=del',
                    'admin/addons/execute?_addons=adver&_controller=advertising&_action=edit&id=[id]&adver_id=[adver_id]',
                    'admin/addons/execute?_addons=adver&_controller=advertising&_action=setstatus&ids=[id]']
                ],
            'field_group'=>'1:基础',
            "fields"=>[
                '1'=>[
                    ['name'=>'id','title'=>'UID','type'=>'string','remark'=>'','is_show'=>4],
                    ['name'=>'adver_id','title'=>'广告位置','type'=>'disabled','remark'=>'请选择广告位置','is_show'=>4],
                    ['name'=>'title','title'=>'标题','type'=>'string','remark'=>'请输入广告显示标题','is_show'=>1],
                    ['name'=>'img_id','title'=>'图片','type'=>'picture','remark'=>'请上传图片','value'=>'','is_show'=>1],
                    ['name'=>'advstext','title'=>'文字广告','type'=>'textarea','remark'=>'请填写广告内容','value'=>1,'is_show'=>1],
                    ['name'=>'advshtml','title'=>'代码广告','type'=>'textarea','remark'=>'请填写广告代码','value'=>1,'is_show'=>1],
                    ['name'=>'link','title'=>'链接','type'=>'string','remark'=>'用于调转的URL，支持带http://的URL或url函数参数格式','is_show'=>1],
                    ['name'=>'start_time','title'=>'开始时间','type'=>'datetime','value'=>':date("Y-m-d H:i:s",time())','is_show'=>1],
                    ['name'=>'end_time','title'=>'结束时间','type'=>'datetime','value'=>':date("Y-m-d H:i:s",time())','is_show'=>1],
                    ['name'=>'level','title'=>'优先级','type'=>'string','value'=>'0','is_show'=>1],
                    ['name'=>'status','title'=>'状态','type'=>'radio','extra'=>'禁用;启用','is_show'=>0],
                ]
            ],
            'list_grid' => [        //这里定义的是除了id序号外的表格里字段显示的表头名和模型一样支持函数和链接
                'id:编号',
                'title:标题',
                'adver_id|addons_adver_list:广告位',
                'link:链接',
                'start_time:开始时间',
                'end_time:结束时间',
                'status:状态',
                'id:操作:[EDIT]|编辑,[status]|{0.启用.[ADDONSETUS]&status=1 1.禁用.[ADDONSETUS]&status=0},[DELETE]|删除'
            ],
            'search_fixed' => [["name" => "adver_id", "exp" => "eq" ,"value" =>":[adver_id]"]],
        ],
        'edit' =>
        [
            'url' => 'admin/addons/execute?_addons=adver&_controller=advertising&_action=edit',
        ]
    ];
    public function index(){
//        $getList = $this->getList($this->model_info);
//        if($this->request->isPost()){
//            $getList['data']['code'] = 1;
//            return $getList['data'];
//        }else{
//            $id = $this->request->param('adver_id');
//            if($adver_detail = Db::name('adver')->find(['id'=>$id])){
//                $this->assign('meta_title',"[{$adver_detail['title']}]广告位内容列表");
//            }
//            $this->assign('model_info',$getList);
//            Cookie('__forward__',$_SERVER['REQUEST_URI']);
//            if($admin_view_path = config('admin_view_path'))
//                $admin_view_path = $admin_view_path.'/';
//            return $this->fetch('admin@'.$admin_view_path.'addons/adminlist');
//        }

        return $this->fetch();
    }
    public function edit(){
        $param = $this->request->param();
        if($param['id']){
            $get_data['model_info'] = $this->getEdit($this->model_info);
        }else{
            $get_data['model_info'] = $this->getAdd($this->model_info);
        }

        $model = new \addons\adver\model\AdvsrDetails();
        if($this->request->isPost()){
            $res = $model->editData();
            !$res && $this->error($model->getError());
            $this->success(!empty($this->request->param('id'))?'更新成功':'新增成功', Cookie('__forward__'));
        }else{

            if($adver_detail = Db::name('adver')->find(['id'=>$param['adver_id']])){
                $get_data['meta_title']="添加{$adver_detail['title']}广告位置内容";
            }
            //1:单图;2:多图;3:文字;4:代码
            switch ($adver_detail['type']) {
                case 1:
                    unset($get_data['model_info']['fields'][1]['advstext'],$get_data['model_info']['fields'][1]['advshtml']);
                    break;
                case 2:
                    unset($get_data['model_info']['fields'][1]['advstext'],$get_data['model_info']['fields'][1]['advshtml']);
                    break;
                case 3:
                    unset($get_data['model_info']['fields'][1]['img_id'],$get_data['model_info']['fields'][1]['advshtml']);
                    break;
                default:
                    unset($get_data['model_info']['fields'][1]['advstext'],$get_data['model_info']['fields'][1]['img_id']);
            }
            $get_data['model_info']['codeFooter'] ='<script type="text/javascript" src="__ADDONS__/adver/adver.js"></script>';

            $get_data['data'] = $get_data['model_info']['data'];
            if(!$param['id']){
                $get_data['data']['adver_id'] = $param['adver_id'];
            }
            $this->assign($get_data);
            if($admin_view_path = config('admin_view_path'))
                $admin_view_path = $admin_view_path.'/';
            return $this->fetch('admin@'.$admin_view_path.'addons/edit');
        }
    }
    public function setstatus(){
        $this->setState('advsr_details');
    }
}