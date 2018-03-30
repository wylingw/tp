<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\www\TwoThink\public/../application/admin/view/default/property\edit.html";i:1521960127;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>在线报修</title>

    <!-- Bootstrap -->
    <link href="__PUBLIC__/twothink/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/twothink//css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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

        <form action=" <?php echo url('admin/property/edit'); ?>" method="post">
            <div class="form-group">
                <label>您的姓名(必填):</label>
                <input type="text"  name="name" value="<?=$ps['name']?>" class="form-control" />
                <input type="hidden"  name="id" value="<?=$ps['id']?>" class="form-control" />
            </div>
            <div class="form-group">
                <label>您的电话(必填):</label>
                <input type="text" name="tel" value="<?=$ps['tel']?>" class="form-control" />
            </div>
            <div class="form-group">
                <label>您的地址(必填):</label>
                <input type="text" class="form-control" value="<?=$ps['address']?>" name="address"/>
            </div>
            <div class="form-group">
                <label>内容(详细描述需要报修的内容):</label>
                <textarea type="text" class="form-control"  value="<?=$ps['content']?>" name="content"></textarea>
            </div>
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
<script src="../jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>