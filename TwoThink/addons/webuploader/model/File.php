<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络  82550565@qq.com <www.twothink.cn>
// +----------------------------------------------------------------------
namespace addons\webuploader\model;
use think\Model;
/**
 * 文件上传
 */

class File extends Model{
    /**
     * 文件上传
     * @param  array  $files   要上传的文件列表（通常是$_FILES数组）
     * @param  array  $setting 文件上传配置
     */
    public function upload($files, $setting){
    	/* 检测文件是否存在 */
    	$isData=$this->isFile(['md5'=>$files->hash('md5'),'sha1'=>$files->hash()]);
    	if($isData){
    		return $isData; //文件上传成功
    	}
    	// 上传文件验证
    	$info = $files->validate([
    			'ext' => $setting['ext'],
    			'size' => $setting['size']
    	]
    	)->rule($setting['saveName'])->move($setting['rootPath'],true,$setting['replace']);


    	if($info){
    		/* 记录文件信息 */
    		$value['name']  = $info->getInfo('name');
    		$value['savename']  = $info->getBasename();
    		$value['savepath']  = basename($info->getPath()).'/';
    		$value['ext']      = $info->getExtension();
    		$value['mime']   = $info->getInfo('type');
    		$value['size'] = $info->getInfo('size');
    		$value['md5']  = $files->hash('md5');
    		$value['sha1']  = $files->hash('sha1');
    		$value['location']  = 0;
    		$value['create_time']  = time();
    		if($add=$this->create($value)){
    			$value['id'] = $add->id;
    		}
    		return $value; //文件上传成功
    	} else {
    		$this->error = $files->getError();
    		return false;
    	}
    }
    /**
     * 检测当前上传的文件是否已经存在
     * @param  array   $file 文件上传数组
     * @return boolean       文件信息， false - 不存在该文件
     */
    public function isFile($file){
        if(empty($file['md5'])){
            throw new \Exception('缺少参数:md5');
        }
        /* 查找文件 */
        $map = ['md5' => $file['md5'],'sha1'=>$file['sha1']];
        if($data=$this->field(true)->where($map)->find()){
        	return $data->toArray();
        }else{
        	return false;
        }
    }
	/**
	 * 清除数据库存在但本地不存在的数据
	 * @param $data
	 */
	public function removeTrash($data){
		$this->where(['id'=>$data['id']])->delete();
	}

}
