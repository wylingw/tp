<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"D:\www\TwoThink\public/../application/home/view/default/users\register.html";i:1521685276;s:72:"D:\www\TwoThink\public/../application/home/view/default/public\base.html";i:1521685276;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $meta_title; ?>|<?php echo config('web_site_title'); ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="__PUBLIC__/static/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="__PUBLIC__/static/font-awesome/css/font-awesome.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="__PUBLIC__/static/adminlte/dist/css/AdminLTE.min.css">
	<!-- css/skins -->
	<link rel="stylesheet" href="__PUBLIC__/static/adminlte/dist/css/skins/_all-skins.min.css">
	<!-- layui -->
	<link rel="stylesheet" href="__PUBLIC__/static/layui/css/layui.css">
	<link rel="stylesheet" href="__PUBLIC__/home/css/twothink.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
	<?php echo hook('pageHeader'); ?>
</head>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
	<!-- 头部 -->
	<header class="main-header">
		<nav class="navbar navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<a href="#" class="navbar-brand"><b>Two</b>Think</a>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
						<i class="fa fa-bars"></i>
					</button>
				</div>

				<!-- 导航 -->
				<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<?php $__NAV__ = \think\Db::name('Channel')->field(true)->where("status=1")->order("sort")->select();if(is_array($__NAV__) || $__NAV__ instanceof \think\Collection || $__NAV__ instanceof \think\Paginator): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;if($nav['pid'] == '0'): ?>
						<li>
							<a href="<?php echo get_nav_url($nav['url']); ?>" target="<?php if($nav['target'] == '1'): ?>_blank<?php else: ?>_self<?php endif; ?>"><?php echo $nav['title']; ?></a>
						</li>
						<?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</ul>
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
						</div>
					</form>
				</div>
				<!-- /导航 -->
				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<!-- Messages: style can be found in dropdown.less-->
						<li class="dropdown messages-menu">
							<!-- Menu toggle button -->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-envelope-o"></i>
								<span class="label label-success">4</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 4 messages</li>
								<li>
									<!-- inner menu: contains the messages -->
									<ul class="menu">
										<li><!-- start message -->
											<a href="#">
												<div class="pull-left">
													<!-- User Image -->
													<img src="__PUBLIC__/static/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
												</div>
												<!-- Message title and timestamp -->
												<h4>
													Support Team
													<small><i class="fa fa-clock-o"></i> 5 mins</small>
												</h4>
												<!-- The message -->
												<p>Why not buy a new awesome theme?</p>
											</a>
										</li>
										<!-- end message -->
									</ul>
									<!-- /.menu -->
								</li>
								<li class="footer"><a href="#">See All Messages</a></li>
							</ul>
						</li>
						<!-- /.messages-menu -->

						<!-- Notifications Menu -->
						<li class="dropdown notifications-menu">
							<!-- Menu toggle button -->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<span class="label label-warning">10</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 10 notifications</li>
								<li>
									<!-- Inner Menu: contains the notifications -->
									<ul class="menu">
										<li><!-- start notification -->
											<a href="#">
												<i class="fa fa-users text-aqua"></i> 5 new members joined today
											</a>
										</li>
										<!-- end notification -->
									</ul>
								</li>
								<li class="footer"><a href="#">View all</a></li>
							</ul>
						</li>
						<!-- Tasks Menu -->
						<li class="dropdown tasks-menu">
							<!-- Menu Toggle Button -->
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-flag-o"></i>
								<span class="label label-danger">9</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have 9 tasks</li>
								<li>
									<!-- Inner menu: contains the tasks -->
									<ul class="menu">
										<li><!-- Task item -->
											<a href="#">
												<!-- Task title and progress text -->
												<h3>
													Design some buttons
													<small class="pull-right">20%</small>
												</h3>
												<!-- The progress bar -->
												<div class="progress xs">
													<!-- Change the css width attribute to simulate progress -->
													<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
														<span class="sr-only">20% Complete</span>
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
						<?php if(is_login()): ?>
						<li class="dropdown user-info">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<img src="__PUBLIC__/static/adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo get_username(); ?></span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu ">
								<li><a href="<?php echo url('user/user/profile'); ?>">修改密码</a></li>
								<li><a class="ajax-get" href="<?php echo url('user/login/logout'); ?>">退出</a></li>
							</ul>
						</li>
						<?php else: ?>
						<li><a href="<?php echo url('user/login/index'); ?>">登录</a></li>
						<li><a href="<?php echo url('user/user/register'); ?>" style="padding-left:0;padding-right:0">注册</a></li>
						<?php endif; ?>
					</ul>
				</div>
				<!-- /.navbar-custom-menu -->
			</div>
			<!-- /.container-fluid -->
		</nav>
	</header>
	<!-- /头部 -->
	<!-- 主体 -->
	<div class="content-wrapper">
		
		<header class="jumbotron subhead" id="overview">
			<div class="container">
				<h2>源自相同起点，演绎不同精彩！</h2>
				<p class="lead"></p>
			</div>
		</header>
		

		<!-- container -->
		<div class="container">
			 
			
<div class="row">
  <div class="col-md-4 col-sm-12 col-xs-12 col-md-offset-4">
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
      <ul class="layui-tab-title">
        <li><a href="<?php echo url('user/login/index'); ?>">登入</a></li>
        <li class="layui-this">注册</li>
      </ul>
      <div class="layui-tab-content" style="height: 100px;">
        <div class="layui-tab-item layui-show">

          <form class="layui-form layui-form-pane" action="<?php echo request()->url(); ?>" method="post">
            <div class="layui-form-item">
              <label class="layui-form-label">用户名</label>
              <div class="layui-input-block">
                <input name="username" autocomplete="off" placeholder="请输入用户名" class="layui-input" type="text" lay-verify="required">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">密码</label>
              <div class="layui-input-block">
                <input name="password" autocomplete="off" placeholder="请输入密码" class="layui-input" type="password" lay-verify="required">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">确认密码</label>
              <div class="layui-input-block">
                <input name="repassword" autocomplete="off" placeholder="请输入确认密码" class="layui-input" type="password" lay-verify="required">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">邮箱</label>
              <div class="layui-input-block">
                <input name="email" autocomplete="off" placeholder="请输入邮箱" class="layui-input" type="text" lay-verify="required|email">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">验证码</label>
              <div class="layui-input-block">
                <input name="verify" autocomplete="off" placeholder="请输入验证码" class="layui-input" type="text">
              </div>
            </div>
            <div class="layui-form-item">
              <div class="controls verifyimg">
                <?php echo captcha_img(); ?>
              </div>
            </div>
            <div class="layui-form-item">
              <button class="btn btn-success col-md-12 col-sm-12 col-xs-12" lay-submit="" lay-filter="formLogin">登入</button>
            </div>
          </form>

        </div>
        <div class="layui-tab-item"></div>
      </div>
    </div>
  </div>
</div>


		</div>
		<!-- /.container -->
	</div>
	<!-- /主体 -->
	<footer class="main-footer">
		<div class="container">
			<div class="pull-right hidden-xs">
				<b>TwoThink</b> <?php echo TWOTHINK_VERSION; ?>
			</div>
			<strong>Copyright &copy; 2014-2017 <a href="http://www.twothink.cn" target="_blank">YiPinWangLuo Studio</a>.</strong> All rights
			reserved.
		</div>
		<!-- /.container -->
	</footer>
</div>
<!-- ./wrapper -->
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>


<!-- jQuery 3 -->
<script src="__PUBLIC__/static/js/jquery.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="__PUBLIC__/static/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="__PUBLIC__/static/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="__PUBLIC__/static/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="__PUBLIC__/static/adminlte/dist/js/demo.js"></script>

<!-- layui -->
<script src="__PUBLIC__/static/layui/layui.js"></script>
<script src="__PUBLIC__/home/js/twothink.js"></script>


<style>
  .verifyimg img{
    width: 100%;
  }
</style>
	<script type="text/javascript">
    	$(document)
	    	.ajaxStart(function(){
	    		$("button:submit").addClass("log-in").attr("disabled", true);
	    	})
	    	.ajaxStop(function(){
	    		$("button:submit").removeClass("log-in").attr("disabled", false);
	    	});


    	$("form").submit(function(){
    		var self = $(this);
    		$.post(self.attr("action"), self.serialize(), success, "json");
    		return false;

    		function success(data){
    			if(data.code){
                    layer_success(data.msg);
                    setTimeout(function(){
                        window.location.href = data.url;
                    },1500);
    			} else {
    				layer_error(data.msg);
    				//刷新验证码
    				$(".verifyimg img").click();
    			}
    		}
    	});

		$(function(){
      //刷新验证码
        var verifyimg = $(".verifyimg img").attr("src");
        $(".verifyimg img").click(function(){
            if( verifyimg.indexOf('?')>0){
                $(".verifyimg img").attr("src", verifyimg+'&random='+Math.random());
            }else{
                $(".verifyimg img").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
            }
        }); 
    });
	</script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget'); ?>


</body>
</html>
