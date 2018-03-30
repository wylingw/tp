<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"D:\www\TwoThink\public/../application/admin/view/default/index\index.html";i:1521685276;s:73:"D:\www\TwoThink\public/../application/admin/view/default/public\base.html";i:1521685276;s:77:"D:\www\TwoThink\public/../application/admin/view/default/public\sidemenu.html";i:1521685276;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if(!(empty($meta_title) || (($meta_title instanceof \think\Collection || $meta_title instanceof \think\Paginator ) && $meta_title->isEmpty()))): ?>
        <?php echo $meta_title; else: isset($title_bar)?$title_bar:''; endif; ?>|TwoThink内容管理系统</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="__PUBLIC__/static/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="__PUBLIC__/static/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="__PUBLIC__/static/adminlte/dist/css/AdminLTE.min.css">
    <!-- layui -->
    <link rel="stylesheet" href="__PUBLIC__/static/layui/css/layui.css">

    <link rel="stylesheet" href="__PUBLIC__/admin/css/twothink.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load.-->
    <link rel="stylesheet" href="__PUBLIC__/static/adminlte/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 3 -->
    <!--<script src="__PUBLIC__/static/adminlte/bower_components/jquery/dist/jquery.min.js"></script>-->
    <script src="__PUBLIC__/static/js/jquery.js"></script>
    
<style>
    .main-sidebar{
        display: none;
    }
    .content-wrapper, .main-footer {
        margin-left: 0px !important;
    }
</style>

    <!-- 页面代码扩展，一般用于加载模板部分差异CSS与JS文件和代码 -->
    <?php if(!(empty($model_info['codeHeader']) || (($model_info['codeHeader'] instanceof \think\Collection || $model_info['codeHeader'] instanceof \think\Paginator ) && $model_info['codeHeader']->isEmpty()))): ?><?php echo $model_info['codeHeader']; endif; ?>
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
<?php
    //iframe连接参数
    $tpl_param = request()->param();
    $is_iframe = isset($tpl_param['is_iframe'])?$tpl_param['is_iframe']:'';
if(!(empty($is_iframe) || (($is_iframe instanceof \think\Collection || $is_iframe instanceof \think\Paginator ) && $is_iframe->isEmpty()))): ?>
    <style>
        .content-wrapper, .main-footer {
            margin-left: 0px !important;
        }
        .content-wrapper {
            background-color: #FFF;
        }
        .main-sidebar{
            display: none;
        }
        .btn-submit-group {
            padding: 5px 20px;
            font-size: 14px;
            overflow: hidden;
            border-radius: 0 0 2px 2px;
            background: #F8F8F8;
            position: fixed;
            bottom: 0px;
            z-index: 999999999999999;
            left: 0px;
            width: 100%;
        }
        .content-bottom{
            margin-bottom: 50px;
        }
    </style>
<?php else: ?>
    <header class="main-header">
        <!-- Logo -->
        <div class="logo navbar">
            <button class="navbar-toggle sidebar-toggle tnav_button_logo" data-toggle="push-menu" role="button">
                <span class="sr-only">左侧导航</span>
            </button>

            <button type="button" class="navbar-toggle navbar-toggle-right" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">顶部导航</span>
                <i class="fa fa-fw fa-ellipsis-h"></i>
            </button>
            <!--</div>-->
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>TWO</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Two</b>Think</span>
        </div>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top collapse navbar-collapse" id="navbar">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle hidden-xs" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu" style="float: left;">
                <div class="nav navbar-nav">
                    <?php if(is_array($__MENU__['main']) || $__MENU__['main'] instanceof \think\Collection || $__MENU__['main'] instanceof \think\Paginator): $i = 0; $__LIST__ = $__MENU__['main'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?>
                    <li class="<?php if(!(empty($menu['current']) || (($menu['current'] instanceof \think\Collection || $menu['current'] instanceof \think\Paginator ) && $menu['current']->isEmpty()))): ?>active<?php endif; ?>">
                        <a href="<?php echo $menu['url']; ?>"><i class="<?php echo $menu['icon']; ?>" aria-hidden="true"></i> <?php echo $menu['title']; ?></a>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="__PUBLIC__/static/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="__PUBLIC__/static/adminlte/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                AdminLTE Design Team
                                                <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="__PUBLIC__/static/adminlte/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Developers
                                                <small><i class="fa fa-clock-o"></i> Today</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="__PUBLIC__/static/adminlte/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Sales Department
                                                <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="__PUBLIC__/static/adminlte/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Reviewers
                                                <small><i class="fa fa-clock-o"></i> 2 days</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                            page and may cause design problems
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-red"></i> 5 new members joined
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user text-red"></i> You changed your username
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks: style can be found in dropdown.less -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Create a nice theme
                                                <small class="pull-right">40%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">40% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Some task I need to do
                                                <small class="pull-right">60%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">60% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Make beautiful transitions
                                                <small class="pull-right">80%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                                                     aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">80% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a target="_blank" href="<?php echo url('home/index/delcache'); ?>" title="网站首页">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo url('Clear/delcache'); ?>" title="清空缓存" class="ajax-get">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </li>


                    <!-- 用户信息 -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="__PUBLIC__/static/adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">您好:<?php echo session('user_auth.username'); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="__PUBLIC__/static/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>
                                    您好，<?php echo session('user_auth.username'); ?>
                                    <small><?php echo date("Y-m-d H:i:s",session('user_auth.last_login_time'));  ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a target="_blank" href="http://www.twothink.cn/">官网</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="<?php echo url('User/update_nickname'); ?>" class="ajax-get iframe">修改昵称</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo url('User/update_password'); ?>" class="btn btn-default btn-flat ajax-get iframe">修改密码</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo url('Login/logout'); ?>" class="btn btn-default btn-flat ajax-get">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- /用户信息 -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- 侧边栏 -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="__PUBLIC__/static/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>您好:<?php echo session('user_auth.username'); ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- 子导航 -->
            
            <ul class="side-sub-menu sidebar-menu" data-widget="tree">


    <!-- 子导航 -->
    <?php if(!(empty($__MENU__['operater']) || (($__MENU__['operater'] instanceof \think\Collection || $__MENU__['operater'] instanceof \think\Paginator ) && $__MENU__['operater']->isEmpty()))): ?>
        <?php echo action('Menu/sidetree', array($__MENU__['operater'],'menu/sidenodes')); endif; ?>
    <!--/ 子导航 -->
    <li class="header">LABELS</li>
    <li><a href="http://twothink.cn" target="_blank"><i class="fa fa-home text-red"></i> <span>官方网站</span></a></li>
    <li><a href="https://www.kancloud.cn/ming118116/twothink" target="_blank"><i class="fa fa-book text-yellow"></i> <span>官方文档</span></a></li>
    <li><a href="http://shang.qq.com/wpa/qunwpa?idkey=e44ea31a37e47815528c511f139e43c4e80de8edf8aa9c016134450dbbbd5a67" target="_blank"><i class="fa fa-qq text-aqua"></i> <span>QQ交流</span></a></li>
</ul>
            
            <!-- /子导航 -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- /侧边栏 -->
<?php endif; ?>
    <!-- 内容区 -->
    <div class="content-wrapper">
        <!-- 内容标题 -->
        <section class="content-header">
            
            <h5><i class="fa fa-fw fa-connectdevelop"></i>
                <?php
                if(!empty($title_bar)){
                    if(is_array($title_bar)){
                        foreach($title_bar as $key=>$value){
                            if(isset($value['url'])){
                                echo '&nbsp;<a href="'.$value['url'].'">'.$value['title'].'</a>&nbsp;';
                            }else{
                                if($value['extra']){
                                    echo '&nbsp;'.$value['title'].'[';
                                    foreach($value[extra] as $k=>$v){
                                        if(isset($v['url'])){
                                            echo '&nbsp;<a href="'.$v['url'].'">'.$v['title'].'</a>&nbsp;';
                                        }else{
                                            echo '&nbsp;'.$v['title'].'&nbsp;';
                                        }
                                    }
                                    echo ']&nbsp;';
                                }else{
                                    echo '&nbsp;'.$value['title'].'&nbsp;';
                                }
                            }
                        }
                    }else{
                        echo $title_bar;
                    }
                }else{
                    echo $meta_title;
                }
                ?>
                </h5>
            
        </section>
        <!-- /内容标题 -->

        <!-- 内容主体 -->
        <section class="content">
            <div class="content-bottom">
             
<!-- 主体 -->
<section class="content">
    <!-- 插件块 -->
    <div class="row"><?php echo hook('AdminIndex'); ?></div>
</section>

            </div>
        </section>
        <!-- /内容主体 -->
    </div>
    <!-- /内容区 -->
<?php if(empty($is_iframe) || (($is_iframe instanceof \think\Collection || $is_iframe instanceof \think\Paginator ) && $is_iframe->isEmpty())): ?>
    
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>TwoThink</b> <?php echo TWOTHINK_VERSION; ?>
            </div>
            <strong>Copyright &copy; 2014-2017 <a href="http://www.twothink.cn" target="_blank">YiPinWangLuo Studio</a>.</strong> All rights
            reserved.
        </footer>
    

    
<?php endif; ?>

    <!-- 添加边栏的背景。必须放置此div -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



<!-- Bootstrap 3.3.7 -->
<script src="__PUBLIC__/static/bootstrap/js/bootstrap.min.js"></script>
<!-- layui -->
<script src="__PUBLIC__/static/layui/layui.js"></script>

<!-- jQuery Knob Chart -->
<script src="__PUBLIC__/static/adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- FastClick -->
<script src="__PUBLIC__/static/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="__PUBLIC__/static/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="__PUBLIC__/static/adminlte/dist/js/demo.js"></script>

<!-- Twothink -->
<script src="__PUBLIC__/admin/js/common.js"></script>


<!-- 页面代码扩展，一般用于加载模版部分差异CSS与JS文件和代码 -->
<?php if(!(empty($model_info['codeFooter']) || (($model_info['codeFooter'] instanceof \think\Collection || $model_info['codeFooter'] instanceof \think\Paginator ) && $model_info['codeFooter']->isEmpty()))): ?><?php echo $model_info['codeFooter']; endif; if(!(empty($is_iframe) || (($is_iframe instanceof \think\Collection || $is_iframe instanceof \think\Paginator ) && $is_iframe->isEmpty()))): ?>
<script>
    $(function () {
        //为ajax的iframe请求方式添加提交标识
        $(".btn-submit-group .ajax-post").addClass('iframe');
        $(".btn-submit-group .btn-return").hide();
    });
</script>
<?php endif; ?>
</body>
</html>
