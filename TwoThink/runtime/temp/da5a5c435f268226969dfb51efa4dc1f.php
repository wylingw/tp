<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\www\TwoThink\public/../application/admin/view/default/service\add.html";i:1522029436;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>后台发布通知</title>

    <!-- Bootstrap -->
    <link href="__PUBLIC__/twothink/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/twothink//css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <script src="../jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="__PUBLIC__/static/js/jquery.js"></script>
    <link href="__PUBLIC__/addons/webuploader/webuploader/webuploader.css">
    <script src="__PUBLIC__/addons/webuploader/webuploader/webuploader.js"></script>
    <script src="__PUBLIC__/static/bootstrap/js/bootstrap.js"></script>

    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->

    <!--导航结束-->

    <div class="container-fluid">

        <form action=" <?php echo url('admin/service/add'); ?>" method="post">
            <div class="form-group">
                <label>标题(必填):</label>
                <input type="text"  name="title" class="form-control" />
            </div>
            <div class="form-group">
                <label>内容(必填):</label>
                <input type="text" name="content" class="form-control" />
            </div>
            <div class="form-group">
                <label>发布状态(必填):</label><br>
                发布:<input type="radio" name="status"   value="1"/>
                禁用:<input type="radio" name="status"   value="2"/>
            </div>
            <div class="form-group">
                <label>发布者(必填):</label>
                <input type="text" class="form-control" name="author"/>
            </div>
            <div class="form-group">
                <label>图片(小区配图):</label>
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker">选择图片</div>
                </div>
                <img id="logo_view" width="150px">
                <input type="hidden" class="form-control" id="picture" name="picture"></input>
            </div>
            <!--dom结构部分-->

            <!--<div class="form-group">-->
                <!--<div><a href="#"><span class="glyphicon glyphicon-plus onlineUpImg"></span></a></div>-->
                <!--<label>图片(最多上传5张,可不上传):</label>-->
            <!--</div>-->
            <div class="form-group">
                <button class="btn btn-primary onlineBtn">确认提交</button>
            </div>
        </form>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script>
    // 初始化Web Uploader
    var uploader = WebUploader.create({

// 选完文件后，是否自动上传。
        auto: true,

// swf文件路径
        swf:  '__PUBLIC__/addons/webuploader/webuploader/Uploader.swf',

// 文件接收服务端。
        server: "<?php echo url('admin/notice/picture'); ?>",

// 选择文件的按钮。可选。
// 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

// 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    //图片上传成功
    uploader.on( 'uploadSuccess', function( file,response ) {
        var imgUrl = response.url;
// console.log(imgUrl);
//将上传成功的文件的路径赋值给logo字段
        $("#picture").val(imgUrl);
//图片回显
        $("#logo_view").attr('src',imgUrl);
        $('#logo_view').attr('width','150px');
//$( '#'+file.id ).addClass('upload-state-done');
    });

</script>

</body>
</html>
