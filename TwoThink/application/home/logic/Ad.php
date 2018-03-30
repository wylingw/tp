<?php
/**
 * Created by PhpStorm.
 * User: LM-SAMA
 * Date: 2018/3/23
 * Time: 10:16
 */

namespace app\admin\controller;


use think\Db;
//use yii\web\UploadedFile;
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
class Ad extends Admin
{
    /**
     * 分类文档列表页
     */
    public function index(){;
        $list = Db::table('twothinkad')->select();
        $page = input ( 'page', 1 );
        $number = 2; // 每页显示
        $voList = Db::name ( 'repair' )->paginate ( $number, false, array (
            'page' => $page
        ) );
        $_page = $voList->render (); // 获取分页显示
        $voList = array_slice ( $list, bcmul ( $number, $page ) - $number, $number );
        $this->assign( '_page', $_page );
        $this->assign( '_list', $voList );
        return $this->fetch ();
    }
    /**
     * 添加
     */
    public function add(){

        if($this->request->isPost()){
            $post=$_POST;
            $post['create_time']=time();
            $res=Db::table('twothinkad')->insert($post);
            //跳转页面
            if($res){
                return $this->success('添加成功',url('index'));
            }else{
                return $this->error('添加失败');
            }
        }else{
            return $this->fetch ('add');
        }
    }
    /**
     * 删除
     */
    public function del()
    {
        $id = $_GET['id'];
        if ($this->request->isGet()) {
            $res = Db::table('twothinkad')->delete($id);
            if ($res) {
                return $this->success('删除成功', url('index'));
            } else {
                return $this->error('删除失败');
            }
        }
    }
    /**
     * 修改
     * @return mixed|void
     */
    public function edit()
    {
        $id = $_GET['id'];
        if($this->request->isPost()){
            $post=$_POST;
            $result=Db::table('twothinkad')->where('id',$post['id'])->update($post);
            //跳转页面
            if($result){
                return $this->success('修改成功',url('index'));
            }else{
                return $this->error('失败');
            }
        }
        $ad=Db::table('twothinkad')->where('id',$id)->find();
        $this->assign('ad',$ad);
        return $this->fetch ('edit');
    }
    /**
     * 上传图片
     */
    public function upload(){
        $file = $this->request->file('file');
        //保存 文件
        //$fileName='/uploads/'.uniqid().'.'.$file;
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

        //var_dump(ROOT_PATH . 'public' . DS . 'uploads'.$info->getFilename());die;
        //ROOT_PATH . 'public' . DS . 'uploads'.$info->getFilename();
        if($info){//如果保存成功 返回json对象
            //将图片上传到七牛云
            // 需要填写你的 Access Key 和 Secret Key
            $accessKey ="h1Ky68acfOL28m_eds9AaO_8lp-4NWBtH0Avc3j1";
            $secretKey = "JNoxpsRZ52eO1njDemvmxZaDMv_Ve8L12oouer1u";
            $bucket = "twothink";
            // 构建鉴权对象
            $auth = new Auth($accessKey, $secretKey);
            // 生成上传 Token
            $token = $auth->uploadToken($bucket);

            // 要上传文件的本地路径
            $filePath = ROOT_PATH . 'public' . DS . 'uploads/'.$info->getSaveName();

            //var_dump($filePath);exit;
            // 上传到七牛后保存的文件名
            $key = $info->getFilename();
            // 初始化 UploadManager 对象并进行文件的上传。
            $uploadMgr = new UploadManager();
            // 调用 UploadManager 的 putFile 方法进行文件的上传。
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
            if($err==null){
                //七牛云上传成功
                //访问七牛云图片的地址http://<domain>/<key>
                return json_encode([
                    'url'=>"http://p618v6z1e.bkt.clouddn.com/{$key}"
                ]);
            }else{
                return $err;
            }
        }
    }
    /**
     * 启用
     */
    public function on(){
        $id=$_GET['id'];
        if ($this->request->isGet()){
            $res = Db::table('twothinkad')->where('id',$id)->update(['status'=>0]);
            if ($res) {
                return $this->success('启动成功', url('index'));
            }
        }
        return $this->error('启动失败');

    }
    /**
     * 禁用
     */
    public function off(){
        $id=$_GET['id'];
        if ($this->request->isGet()){
            $res = Db::table('twothinkad')->where('id',$id)->update(['status'=>1]);
            if ($res) {
                return $this->success('禁用成功', url('index'));
            }
        }
        return $this->error('禁用失败');

    }
}