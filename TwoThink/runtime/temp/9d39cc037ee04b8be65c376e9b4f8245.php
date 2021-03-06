<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\www\TwoThink\public/../application/home/view/default/notice\index.html";i:1522341970;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="__PUBLIC__/twothink/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="__PUBLIC__/twothink/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main {
            margin-bottom: 60px;
        }

        .indexLabel {
            padding: 10px 0;
            margin: 10px 0 0;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="index.html" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="#" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid" id="content" page="1">
        <?php foreach($notices as $n):?>
        <div class="row noticeList">
            <a href="<?php echo url('notice/detail'); ?>?id=<?=$n['id']?>">

                <div class="col-xs-2">
                    <img class="noticeImg" src="<?=$n['picture']?>"/>
                </div>

                <div class="col-xs-10">
                    <p class="title"><?=$n['title']?></p>
                    <p class="intro"><?=$n['content']?></p>
                    <p class="info">浏览数: <?=$n['view']?> <span class="pull-right"><?=date('Y-m-d H:i:s',$n['time'])?></span></p>
                </div>

            </a>
        </div>
        <?php endforeach;?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="__PUBLIC__/static/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="__PUBLIC__/twothink/bootstrap/js/bootstrap.js"></script>
    <script>
        //分页
        $(function () {
            $('#content').click(function () {

                var page=$(this).attr('page');
               $.getJSON('home/notice/hit',{page:page},function (data) {
                   if (data){
                       //输出HTML
                       //console.log(66)
                       $(data).each(function (i,v) {
//                            console.log(v.id)
                           // console.log(data)
                           var html="" ;
                           html="<div class='row noticeList'>" +
                               "<a href='/home/notice/detail.html?id="+v.id+"'>" +
                               "<div class='col-xs-2'><img class='noticeImg' src='"+v.picture+"' />" +
                               "</div><div class='col-xs-10'><p>"+v.title+"</p><p>"+v.content+"</p>" +
                               "<p>浏览:"+v.view+"<span class='pull-right'>"+v.time+"</span></p>" +
                               "</div></a></div>";
                           $('#content').append(html);
                       });
                       $("#content").attr('page',page);
                   }

               })

           })
       });
    </script>
</body>
</html>