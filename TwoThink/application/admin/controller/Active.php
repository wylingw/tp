<?php

namespace app\admin\controller;
use think\Db;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Active extends Admin
{
    //列表页
    public function index()
    {
        $lists = Db::table('twothink_active')->select();
        $this->assign('lists', $lists);
        return $this->fetch('index');
    }

    //添加活动
    public function add()
    {
        $request = $this->request;
        if ($request->isPost()) {
            //加載數據
            $data = $request->post();
            $data['start_time'] = strtotime( $data['start_time']);
            $data['end_time'] = strtotime( $data['end_time']);
            $result = $this->validate($data, "Notice");
            if ($result) {
                unset($data['file']);
                Db::table('twothink_active')->insert($data);
                //跳转页面
                return $this->success('添加成功', url('index'));
            }
        }
        return $this->fetch('add');
    }

    //处理webuploader上传图片,并上传到七牛云
    public function picture()
    {
//        var_dump($_FILES);die();
        /* 调用文件上传组件上传文件 */
        /* 调用文件上传组件上传文件 */
        $file = request()->file('file');
        //var_dump($file);die();
        if (empty($file)) {
            $this->error('请选择上传文件');
        }
        // var_dump(ROOT_PATH . 'public' . DS .'static'. DS . 'uploads'. DS .'picture');die();

        $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads' . DS . 'picture');
        if ($info) {
            //图片上传到七牛云
            //>>>1. 需要填写你的 Access Key 和 Secret Key
            $accessKey = "IUIg3xvfZl9XNi-VOVc36zOFD5q2vFBYvQHef4gY";
            $secretKey = "ZnfIqCNx1sPF4J75Tbmg8yZKriqbStB--eOJ41XY";
            $bucket = "twothink";
            // 构建鉴权对象
            $auth = new Auth($accessKey, $secretKey);
            // 生成上传 Token
            $token = $auth->uploadToken($bucket);
            // 要上传文件的本地路径
            $filePath = ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads' . DS . 'picture/' . $info->getSaveName();
            // 上传到七牛后保存的文件名
            $key = $info->getSaveName();
            // 初始化 UploadManager 对象并进行文件的上传。
            $uploadMgr = new UploadManager();
            // 调用 UploadManager 的 putFile 方法进行文件的上传。
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
            if ($err == null) {
                //上传七牛云成功
                //访问地址格式http://<domain>/<key>
                return json_encode([
                    'url' => "http://p64k7mtc0.bkt.clouddn.com/" . urlencode($key)
                ]);
            }

        }
    }

    //修改
    public function edit()
    {
        $request = $this->request;
        $id = $request->get('id');
        if ($request->isPost()) {
            $data = $request->post();
            $data['start_time'] = strtotime( $data['start_time']);
            $data['end_time'] = strtotime( $data['end_time']);
            // var_dump($data['id']);die();
            unset($data['file']);
            $res = Db::table('twothink_active')->where('id', $data['id'])->update($data);
            if ($res) {
                return $this->success('修改成功', url('index'));
            } else {
                return $this->error('修改失败');
            }
        }
        //var_dump($data);die();
        $services = Db::table('twothink_active')->where('id', $id)->find();
//         var_dump($services);die();
        $this->assign('services', $services);
        return $this->fetch('edit');
    }

    //删除
    public function del()
    {
        $request = $this->request;
        $id = $request->get('id');
        //var_dump($id);die();
        $model = Db::table('twothink_active')->delete($id);
        if ($model) {
            return $this->success('删除成功', url('index'));
        } else {
            return $this->error('删除失败');
        }
    }
}