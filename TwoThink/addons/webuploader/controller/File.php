<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 小矮人 <82550565@qq.com>
// +----------------------------------------------------------------------
namespace addons\webuploader\controller; 
use app\home\controller\Addons;

class File extends Addons{
    /**
     * 上传图片
     */
    public function uploadpicture(){
        //TODO: 用户登录检测
        /* 调用文件上传组件上传文件 */
        $file = request()->file('addonwebuploader_file');
        if (empty($file)) {
            $this->error('请选择上传文件');
        }
        $Picture = new \addons\webuploader\model\Picture();
        $info = $Picture->upload($file,config('picture_upload'));
        //TODO:上传到远程服务器
        /* 记录图片信息 */
        if($info){
            $return['code'] = 1;
            $info['path']=$info['path'];
            $return = array_merge($info, $return);
        } else {
            $return['code'] = 0;
            $return['msg']   = $Picture->getError();
        }
        /* 返回JSON数据 */
        return json($return);
    }
}
