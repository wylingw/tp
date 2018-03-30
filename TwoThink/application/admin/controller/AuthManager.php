<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn> 
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\model\AuthRule;
use app\admin\model\AuthGroup;
use think\Db;

/**
 * 权限管理控制器
 * @author 小矮人 82550565@qq.com
 */
class AuthManager extends Admin {
    public $model_info = [
        'default'=>[
            'meta_title' => '权限管理',
            //特殊字符串替换用于列表定义解析
            'replace_string' => [['[DELETE]','[EDIT]'],['del?model=auth_group&ids=[id]','auth_manager/editgroup?id=[id]']],
            //按钮组
            'button'     => [
                ['title'=>'新增','url'=>'creategroup','icon'=>'','class'=>'ajax-get iframe btn-success','ExtraHTML'=>''],
                ['title'=>'启用','url'=>'changestatus?method=resumeGroup','icon'=>'','class'=>'btn-info ajax-post','ExtraHTML'=>'target-form="ids"'],
                ['title'=>'禁用','url'=>'changestatus?method=forbidGroup','icon'=>'','class'=>'btn-primary ajax-post','ExtraHTML'=>'target-form="ids"'],
                ['title'=>'删除','url'=>'changestatus?method=deleteGroup','icon'=>'','class'=>'btn-danger  ajax-post confirm','ExtraHTML'=>'target-form="ids"']
            ],
            //表名
            'name' => 'AuthGroup',
            //主键
            'pk' => 'id',
            //列表定义
            'list_grid'  => 'id:编号;title:用户组:[EDIT];id|mb_strimwidth([description] 0 60 ... utf-8):描述;id:授权:access?group_name=[title]&group_id=[id]|访问授权,category?group_name=[title]&group_id=[id]|分类授权,user?group_name=[title]&group_id=[id]|成员授权;status|{0.禁用 1.正常}:状态;id:操作:[EDIT]|编辑,[status]|{ 0.启用.setstatus?model=auth_group&status=1&ids=[id] 1.禁用.setstatus?model=auth_group&status=0&ids=[id]},[DELETE]|删除',
            'field_group'=>'1:基础',
            //表单显示排序
            "fields"=>[
                '1'=>[
                    ['name'=>'id','title'=>'id','type'=>'string','remark'=>'','is_show'=>3],
                    ['name'=>'title','title'=>'用户组','type'=>'string','remark'=>'','is_show'=>1],
                    ['name'=>'description','title'=>'描述','type'=>'textarea','remark'=>'','is_show'=>1]
                ]
            ]
        ],
        'index'=>['url'=>true],
        'creategroup'=>[
            'meta_title' => '新增用户组',
            'action' => '_add',
            'url'=>'writegroup'
        ],
        'editgroup'=>[
            'meta_title' => '编辑用户组',
            'action' => '_edit',
            'url'=>'writegroup'
        ]
    ];
    /**
     * 管理员用户组数据写入/更新
     * @author 小矮人 82550565@qq.com
     */
    public function writeGroup(){
        $data=$this->request->param();
        if(isset($data['rules'])){
            sort($data['rules']);
            $data['rules']  = implode( ',' , array_unique($data['rules']));
        }
        $data['module'] =  'admin';
        $data['type']   =  AuthGroup::type_admin;
        $AuthGroup       =  model('auth_group');

        if(isset($data['id']) && !empty($data['id'])){
            $r = $AuthGroup->update($data);
        }else{
            $result = $this->validate($data,[
                ['title', 'require', '必须设置用户组标题'],
                ['description', 'length:0,80', '描述最多80字符'],
            ]);
            if(true !== $result){
                return $this->error($result);
            }
            $r = $AuthGroup->save($data);
        }

        if($r===false){
            $this->error(!empty($data['id'])?'更新失败'.$AuthGroup->getError():'新增失败'.$AuthGroup->getError());
        } else{
            $this->success(!empty($data['id'])?'更新成功':'新增成功',url('index'));
        }
    }
    /**
     * 后台节点配置的url作为规则存入auth_rule
     * 执行新节点的插入,已有节点的更新,无效规则的删除三项任务
     * @author 艺品网络 <twothink.cn>
     */
    public function updateRules()
    {
        //需要新增的节点必然位于$nodes
        $nodes = $this->returnNodes(false);

        $AuthRule = Db::name('auth_rule');

        $map = array('type' => array('in', '1,2'));//status全部取出,以进行更新
        //需要更新和删除的节点必然位于$rules
        $rules = $AuthRule->where($map)->order('name')->select();
        $rules = Array_mapping($rules, 'menu_id');

        //构建insert数据
        $data = array();//保存需要插入和更新的新节点
        foreach ($nodes as $value) {
            if(empty($value['url']))
                continue;
            $temp['menu_id'] = $value['id'];
            $temp['name'] = $value['url'];
            $temp['title'] = $value['title'];
            $temp['module'] = $value['module'];
            if ($value['pid'] > 0) {
                $temp['type'] = AuthRule::rule_url;
            } else {
                $temp['type'] = AuthRule::rule_main;
            }
            $temp['status'] = 1;
            $data[] = $temp;
        }
        //更新和创建数据
        foreach ($data as $key => $value) {
            if ($rules[$value['menu_id']]) { //更新
                unset($value['status']);
                $AuthRule->where('menu_id', $value['menu_id'])->update($value);
            } else {
                $AuthRule->insert($value);
            }
        }
        //删除垃圾数据
        if($id = array_column($nodes,'id')){
            $where['menu_id'] = ['not in',$id] ;
            $AuthRule->where($where)->update(['status'=>'-1']);
            //删除规则是否需要从每个用户组的访问授权表中移除该规则?
        }

    }

    /**
     * 访问授权页面
     * @author 小矮人 82550565@qq.com
     */
    public function access(){
        $this->updateRules();
        $auth_group = Db::name('AuthGroup')->where( array('status'=>array('egt','0'),'type'=>AuthGroup::type_admin) )
            ->column('id,id,title,rules');
        $auth_group[(int)input('group_id')]['checked'] = true; //当前权限组
        $node_list   = $this->returnNodes(false);
        $rules_array = array_flip(explode(',',$auth_group[(int)input('group_id')]['rules']));
        //权限规则
        $map         = ['type'=>['in','1,2'],'status'=>1];
        $child_rules = Db::name('AuthRule')->where($map)->column('name,id');

        foreach ($node_list as $key=>&$value){
            $auth_rule_id = '';
            if(!empty($value['url'])){
                $value['auth_rule_id'] = $auth_rule_id = $child_rules[$value['url']];
            }
            if(isset($rules_array[$auth_rule_id]) && !empty($auth_rule_id))
                $value['checked'] = true;
        }

        $this->assign('node_list',  $node_list);//权限节点
        $this->assign('auth_group', $auth_group);//权限组
        $this->assign('meta_title','访问授权');

        return $this->fetch('managergroup');
    }
    /**
     * 将分类添加到用户组的编辑页面
     * @author 艺品网络 <twothink.cn>
     */
    public function category(){
        $auth_group     =   Db::name('AuthGroup')->where( array('status'=>array('egt','0'),'module'=>'admin','type'=>AuthGroup::type_admin) )
            ->column('id,id,title,rules');
        $auth_group[(int)input('group_id')]['checked'] = true; //当前权限组

        $Category_list     =   Db::name('Category')->field('id,title,pid')->select();

        $authed_group   =   AuthGroup::getCategoryOfGroup(input('group_id'));
        $authed_group = array_flip($authed_group);
        foreach ($Category_list as $key=>&$value){
            if(isset($authed_group[$value['id']]))
                $value['checked'] = true;
        }

        $this->assign('category_list',     $Category_list);
        $this->assign('auth_group',     $auth_group);

        $this->assign('meta_title','分类授权');
        return $this->fetch();
    }
    public function tree($tree = null){
        $this->assign('tree', $tree);
        return $this->fetch('tree');
    }
    /**
     * @title 将用户添加到用户组的编辑页面
     * @author 小矮人 <82550565@qq.com>
     */
    public function group(){
        $uid            =   $this->request->param('uid');
        $auth_groups    =   model('AuthGroup')->getGroups()->toArray();
        $user_groups    =   AuthGroup::getUserGroup($uid);
        $ids = array();
        foreach ($user_groups as $value){
            $ids[]      =   $value['group_id'];
        }
        $nickname       =   model('Member')->getNickName($uid);
        $model_info = [];
        $model_info['url'] = url('AuthManager/addToGroup');
        $model_info["fields"] = [
            '1' => [
                ['name'=>'uid','title'=>'uid','type'=>'hiden','value'=>'','remark'=>'','is_show'=>4],
                ['name'=>'group_id','title'=>$nickname.'所属的用户组列表','type'=>'checkbox','extra'=>Array_mapping($auth_groups,'id','title'),'value'=>'','remark'=>'','is_show'=>1]
            ]
        ];
        $this->assign('model_info',$model_info);
        $this->assign('data',['uid'=>$uid,'group_id'=>$ids]);
        $this->assign('meta_title','用户组授权');
        return $this->fetch('base/edit');
    }
    /**
     * 将分类添加到用户组  入参:cid,group_id
     * @author 艺品网络 <twothink.cn>
     */
    public function addToCategory(){
        $param = $this->request->param();
        $cid = $param['cid'];
        $gid = $param['group_id'];
        if( empty($gid) ){
            $this->error('参数有误');
        }
        $AuthGroup = model('auth_group');
        if( !$AuthGroup->find($gid)){
            $this->error('用户组不存在');
        }

        if( $cid && !$AuthGroup->checkCategoryId($cid)){
            $this->error($AuthGroup->getError());
        }
        if ( $data=$AuthGroup->addToCategory($gid,$cid) ){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }
    /**
     * 用户组授权用户列表
     * @author 艺品网络 <twothink.cn>
     */
    public function user($group_id){
        if(empty($group_id)){
            $this->error('参数错误');
        }

        $auth_group = Db::name('auth_group')->where( array('status'=>array('egt','0'),'module'=>'admin','type'=>AuthGroup::type_admin) )
            ->column('id,id,title,rules');
        $prefix   = config('database.prefix');
        $l_table  = AuthGroup::member;//$prefix.(AuthGroup::MEMBER);
        $r_table  = AuthGroup::auth_group_access;//$prefix.(AuthGroup::AUTH_GROUP_ACCESS);

        $model    = db($l_table)->alias('m')->join ( $prefix.$r_table.' a','m.uid=a.uid' );
        $where=array('a.group_id'=>$group_id,'m.status'=>array('egt',0));
        $field='m.uid,m.nickname,m.last_login_time,m.last_login_ip,m.status';

        $listRows = config('list_rows') > 0 ? config('list_rows') : 10;

        // 分页查询
        $list = $model->where($where)->order('m.uid asc')->field($field)->paginate($listRows);
        // 获取分页显示
        $page = $list->render();
        $list = $list->toArray();
        $list = $list['data'];
        int_to_string($list);
        $this->assign('_page', $page);
        $this->assign( '_list',     $list );
        $this->assign('auth_group', $auth_group);
        $this->assign('this_group', $auth_group[(int)input('group_id')]);
        $this->assign('meta_title', '成员授权');
        return $this->fetch();
    }
    /**
     * 将用户添加到用户组,入参uid,group_id
     * @author 艺品网络 <twothink.cn>
     */
    public function addToGroup(){
        $uid = input('uid');
        $gid = input('group_id/a');
        if( empty($uid) ){
            $this->error('参数有误');
        }
        $AuthGroup = model('AuthGroup');
        if(is_numeric($uid)){
            if ( is_administrator($uid) ) {
                $this->error('该用户为超级管理员');
            }
            if( !Db::name('Member',[],false)->where(array('uid'=>$uid))->find() ){
                $this->error('用户不存在');
            }
        }
        if( $gid && !$AuthGroup->checkGroupId($gid)){
            $this->error($AuthGroup->getError());
        }
        if ( $AuthGroup->addToGroup($uid,$gid) ){
            $this->success('操作成功');
        }else{
            $this->error($AuthGroup->getError());
        }
    }

    /**
     * 将用户从用户组中移除  入参:uid,group_id
     * @author 艺品网络 <twothink.cn>
     */
    public function removeFromGroup(){
        $uid = input('uid');
        $gid = input('group_id');
        if( $uid==UID ){
            $this->error('不允许解除自身授权');
        }
        if( empty($uid) || empty($gid) ){
            $this->error('参数有误');
        }
        $AuthGroup = model('AuthGroup');
        if( !$AuthGroup->find($gid)){
            $this->error('用户组不存在');
        }
        if ( $AuthGroup->removeFromGroup($uid,$gid) ){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }
}