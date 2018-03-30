<?php

namespace addons\webuploader;

//use app\common\controller\Addon;
use app\common\api\Addon as AddonApi;

/**
 * 百度文件上传插件插件
 * @author 小矮人
 */

    class Webuploader extends \think\Addons {

        public $info = array(
            'name'=>'webuploader',
            'title'=>'百度文件上传',
            'description'=>'支持图片文件多文件同时上传',
            'status'=>1,
            'author'=>'小矮人',
            'version'=>'0.1'
        );

//        public $admin_list = array(
//            'model'=>'example',		//要查的表
//			'fields'=>'*',			//要查的字段
//			'map'=>'',				//查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
//			'order'=>'id desc',		//排序,
//			'list_grid'=>array( 		//这里定义的是除了id序号外的表格里字段显示的表头名和模型一样支持函数和链接
//                'cover_id|preview_pic:封面',
//                'title:书名',
//                'description:描述',
//                'link_id|get_link:外链',
//                'update_time|time_format:更新时间',
//                'id:操作:[EDIT]|编辑,[DELETE]|删除'
//            ),
//        );

        public function install(){
            //添加钩子
            $AddonApi = new AddonApi;
            $AddonApi->existHook('webuploader','webuploader','百度图片上传');
            return true;
        }

        public function uninstall(){
            //删除钩子
            $AddonApi = new AddonApi;
            $AddonApi->delHooks('webuploader');
            return true;
        }
        /*实现的 	webuploader钩子方法
         * @param string name 表单name
         * @param string value value值 列多文件 1,2,3
         * @param string type  配置标识
         * @param array  extend   文件上传后的扩展信息 列如  ['name'=>'size']
                            id	7
                            path	/static/uploads/picture/201708…61b3950a6a65900892ea99939.gif
                            url
                            md5	cedf51bbbea8d89167bc84956d8ebc00
                            sha1	2228577efa684e214b302d3db51cf15b8fbc424c
                            status	1
                            create_time	2017-08-28 16:58:48
                            code	1
                            size 1985
         */
        public function  webuploader($param){
            $param['value'] = explode(',',$param['value']);
            $config = $this->getConfig();
            $config['param'] = $this->config_attr($config['param'],$param['type']);
            $accept = explode(',', $config['param']['accept']);
            $accept_string = '';
            foreach ($accept as $value){
                $accept_string.= $this->mimeTypes[$value].',';
            }
            $config['param']['mimeTypes'] = $accept_string;
            $this->assign('addons_config',$config);
            $this->assign('addons_param', $param);
            return $this->fetch('content');
        }
        protected function config_attr($string,$name) {
            if(is_array($string)){
                return $string;
            }
            $array = preg_split('/[\r\n]+/', trim($string, "\r\n"));
            foreach ($array as $val) {
                $arr  =   [];
                foreach (explode(';', $val) as $value) {
                    list($k, $v) = explode(':', $value);
                    $arr[$k]   = $v;
                }
                if($arr['name'] == $name)
                    return $arr;
            }
        }
        protected $mimeTypes = array(
            'ez' => 'application/andrew-inset',
            'hqx' => 'application/mac-binhex40',
            'cpt' => 'application/mac-compactpro',
            'doc' => 'application/msword',
            'bin' => 'application/octet-stream',
            'dms' => 'application/octet-stream',
            'lha' => 'application/octet-stream',
            'lzh' => 'application/octet-stream',
            'exe' => 'application/octet-stream',
            'class' => 'application/octet-stream',
            'so' => 'application/octet-stream',
            'dll' => 'application/octet-stream',
            'oda' => 'application/oda',
            'pdf' => 'application/pdf',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            'smi' => 'application/smil',
            'smil' => 'application/smil',
            'mif' => 'application/vnd.mif',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'wbxml' => 'application/vnd.wap.wbxml',
            'wmlc' => 'application/vnd.wap.wmlc',
            'wmlsc' => 'application/vnd.wap.wmlscriptc',
            'bcpio' => 'application/x-bcpio',
            'vcd' => 'application/x-cdlink',
            'pgn' => 'application/x-chess-pgn',
            'cpio' => 'application/x-cpio',
            'csh' => 'application/x-csh',
            'dcr' => 'application/x-director',
            'dir' => 'application/x-director',
            'dxr' => 'application/x-director',
            'dvi' => 'application/x-dvi',
            'spl' => 'application/x-futuresplash',
            'gtar' => 'application/x-gtar',
            'hdf' => 'application/x-hdf',
            'js' => 'application/x-javascript',
            'skp' => 'application/x-koan',
            'skd' => 'application/x-koan',
            'skt' => 'application/x-koan',
            'skm' => 'application/x-koan',
            'latex' => 'application/x-latex',
            'nc' => 'application/x-netcdf',
            'cdf' => 'application/x-netcdf',
            'sh' => 'application/x-sh',
            'shar' => 'application/x-shar',
            'swf' => 'application/x-shockwave-flash',
            'sit' => 'application/x-stuffit',
            'sv4cpio' => 'application/x-sv4cpio',
            'sv4crc' => 'application/x-sv4crc',
            'tar' => 'application/x-tar',
            'tcl' => 'application/x-tcl',
            'tex' => 'application/x-tex',
            'texinfo' => 'application/x-texinfo',
            'texi' => 'application/x-texinfo',
            't' => 'application/x-troff',
            'tr' => 'application/x-troff',
            'roff' => 'application/x-troff',
            'man' => 'application/x-troff-man',
            'me' => 'application/x-troff-me',
            'ms' => 'application/x-troff-ms',
            'ustar' => 'application/x-ustar',
            'src' => 'application/x-wais-source',
            'xhtml' => 'application/xhtml+xml',
            'xht' => 'application/xhtml+xml',
            'zip' => 'application/zip',
            'au' => 'audio/basic',
            'snd' => 'audio/basic',
            'mid' => 'audio/midi',
            'midi' => 'audio/midi',
            'kar' => 'audio/midi',
            'mpga' => 'audio/mpeg',
            'mp2' => 'audio/mpeg',
            'mp3' => 'audio/mpeg',
            'aif' => 'audio/x-aiff',
            'aiff' => 'audio/x-aiff',
            'aifc' => 'audio/x-aiff',
            'm3u' => 'audio/x-mpegurl',
            'ram' => 'audio/x-pn-realaudio',
            'rm' => 'audio/x-pn-realaudio',
            'rpm' => 'audio/x-pn-realaudio-plugin',
            'ra' => 'audio/x-realaudio',
            'wav' => 'audio/x-wav',
            'pdb' => 'chemical/x-pdb',
            'xyz' => 'chemical/x-xyz',
            'bmp' => 'image/bmp',
            'gif' => 'image/gif',
            'ief' => 'image/ief',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'jpe' => 'image/jpeg',
            'png' => 'image/png',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'djvu' => 'image/vnd.djvu',
            'djv' => 'image/vnd.djvu',
            'wbmp' => 'image/vnd.wap.wbmp',
            'ras' => 'image/x-cmu-raster',
            'pnm' => 'image/x-portable-anymap',
            'pbm' => 'image/x-portable-bitmap',
            'pgm' => 'image/x-portable-graymap',
            'ppm' => 'image/x-portable-pixmap',
            'rgb' => 'image/x-rgb',
            'xbm' => 'image/x-xbitmap',
            'xpm' => 'image/x-xpixmap',
            'xwd' => 'image/x-xwindowdump',
            'igs' => 'model/iges',
            'iges' => 'model/iges',
            'msh' => 'model/mesh',
            'mesh' => 'model/mesh',
            'silo' => 'model/mesh',
            'wrl' => 'model/vrml',
            'vrml' => 'model/vrml',
            'css' => 'text/css',
            'html' => 'text/html',
            'htm' => 'text/html',
            'asc' => 'text/plain',
            'txt' => 'text/plain',
            'rtx' => 'text/richtext',
            'rtf' => 'text/rtf',
            'sgml' => 'text/sgml',
            'sgm' => 'text/sgml',
            'tsv' => 'text/tab-separated-values',
            'wml' => 'text/vnd.wap.wml',
            'wmls' => 'text/vnd.wap.wmlscript',
            'etx' => 'text/x-setext',
            'xsl' => 'text/xml',
            'xml' => 'text/xml',
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'mxu' => 'video/vnd.mpegurl',
            'avi' => 'video/x-msvideo',
            'movie' => 'video/x-sgi-movie',
            'ice' => 'x-conference/x-cooltalk',
        );
}