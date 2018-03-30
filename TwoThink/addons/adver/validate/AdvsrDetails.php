<?php

namespace addons\adver\validate;
use think\Validate;
use think\Db;
/**
 *  广告详情验证器
 */
class AdvsrDetails extends Validate{
    // 验证规则
    protected $rule = [
        ['title', 'require', '标题必须'],
        ['adver_id','require|Countnumber','adver_id必须']
    ];

    protected function Countnumber($value,$rule,$data){
        $adver = Db::name('adver')->where('id','eq',$value)->find();
        $adver_detail = Db::name('AdvsrDetails')->where(['adver_id'=>$value,'status'=>1])->count();
        //1:单图;2:多图;3:文字;4:代码
        switch ($adver['type']) {
            case 1:
                if($adver_detail >= 1 && empty($data['id']))
                    return '单图广告启用数据超出';
                if (empty($data['img_id']))
                    return '请上传广告图片';
                break;
            case 2:
                if(empty($data['img_id']))
                    return '请上传广告图片';
                break;
            case 3:
                if(empty($data['advstext']))
                    return '请填写广告文字';
                break;
            default:
                if(empty($data['advshtml']))
                    return '请填写广告代码';
        }
        return true;
    }

}