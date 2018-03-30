<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:73:"D:\www\TwoThink\public/../application/admin/view/default/notice\list.html";i:1522228451;s:73:"D:\www\TwoThink\public/../application/admin/view/default/public\base.html";i:1521685276;s:77:"D:\www\TwoThink\public/../application/admin/view/default/public\sidemenu.html";i:1521685276;s:76:"D:\www\TwoThink\public/../application/admin/view/default/public\sidebar.html";i:1521685276;}*/ ?>
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
            
<h5><i class="fa fa-fw fa-connectdevelop"></i> 导航管理(系统菜单请勿随意拖动)</h5>

        </section>
        <!-- /内容标题 -->

        <!-- 内容主体 -->
        <section class="content">
            <div class="content-bottom">
             
<div class="container-fluid" id="content" page="1">
    <?php if(is_array($service) || $service instanceof \think\Collection || $service instanceof \think\Paginator): $i = 0; $__LIST__ = $service;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <div class="row noticeList">
        <a href="<?php echo url('communityArticle/detail',['id'=>$vo['id']]); ?>">
            <div class="col-xs-2">
                <img class="noticeImg" src="http://p615vqxbt.bkt.clouddn.com/<?php echo $vo['img']; ?>" />
            </div>
            <div class="col-xs-10">
                <p class="title"><?php echo $vo['title']; ?></p>
                <p class="content"><?php echo $vo['content']; ?></p>
                <p class="view_times">浏览: <?php echo $vo['view_times']; ?> <span class="pull-right"><?php echo date('Y-m-d',$vo['add_time']); ?></span> </p>
            </div>
        </a>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</div>
<script type="text/javascript">
    $(window).scroll(function(event){
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            //滑到最下面的时候,获取其他数据
            var page=$("#content").attr('page');
            page++;
            $.getJSON('pager',{page:page},function (data) {
                if (data){
                    var json = $.parseJSON(data);

                    //循环拼出Div
                    $(json).each(function (i,v) {
                        var html='';
                        console.log(v.create_time);
                        html=" <div class='row noticeList'><a href='/home/notice/detail/id/"+v.id+".html'><div class='col-xs-2'><img class='noticeImg' src='http://p615vqxbt.bkt.clouddn.com/"+v.img+"' /></div><div class='col-xs-10'><p>"+v.title+"</p><p>"+v.detail+"</p><p>浏览:"+v.view_times+"<span class='pull-right'>"+v.create_time+"</span></p></div></a></div>";
                        $('#content').append(html);
                    });
                    $("#content").attr('page',page);
                }

            })
        }
    });
</script>


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
    

    
    <!-- Control Sidebar -->
    <!-- control控制栏 -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">最近的活动</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Other sets of options are available
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Allow the user to show his name in blog posts
                    </p>
                </div>
                <!-- /.form-group -->

                <h3 class="control-sidebar-heading">Chat Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control控制栏 -->
    <!-- /.control-sidebar -->
    
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


<link href="__PUBLIC__/static/nestable/jquery.nestable.css" rel="stylesheet">
<script src="__PUBLIC__/static/nestable/jquery.nestable.js"></script>
<script>
    highlight_subnav('<?php echo url("index"); ?>');
    $(document).ready(function () {
        $("#nestable2").nestable({
            group: 1,
            callback: function (l, e) {
                var id = $(e).attr('data-id'),
                    pid = $(e).parent().parent('li').attr('data-id'),
                    sort = $(e).prev().attr('data-id');
                if (sort == "" || sort == undefined || sort == null) {
                    sort = 0;
                }
                $.ajax({
                    type: 'POST',
                    url: "<?php echo url('index'); ?>",
                    data: {"id": id, "pid": pid, "sort": sort},
                    success: function (data) {
                        if (data.code) {
                            layer.msg(data.msg, {'icon': 6});
                        }
                    }
                });
            }
        });
        $("#nestable-menu").on("click", function (e) {
            var action = $(this).attr("data-action");
            if (action === "expand-all") {
                $(".dd").nestable("expandAll");
                $(this).attr("data-action", "collapse-all");
                $(this).html("收起所有");
            }
            if (action === "collapse-all") {
                $(".dd").nestable("collapseAll")
                $(this).attr("data-action", "expand-all");
                $(this).html("展开所有");
            }
        });
    });

    //分页
    $(window).scroll(function(event){
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            //滑到最下面的时候,获取其他数据
            var page=$("#content").attr('page');
            page++;
            //console.log(111);
            $.getJSON('pager',{page:page},function (data) {
                if (data){
                    var json = $.parseJSON(data);

                    //循环拼出Div
                    $(json).each(function (i,v) {
                        var html='';
                        console.log(v.create_time);
                        html=" <div class='row noticeList'><a href='/admin/notice/detail/id/"+v.id+".html'><div class='col-xs-2'><img class='noticeImg' src='http://p615vqxbt.bkt.clouddn.com/"+v.img+"' /></div><div class='col-xs-10'><p>"+v.title+"</p><p>"+v.detail+"</p><p>浏览:"+v.view_times+"<span class='pull-right'>"+v.create_time+"</span></p></div></a></div>";
                        $('#content').append(html);
                    });
                    $("#content").attr('page',page);
                }

            })
        }
    });

</script>

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
