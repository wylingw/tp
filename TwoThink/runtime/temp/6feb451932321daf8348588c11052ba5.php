<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"D:\www\TwoThink\public/../application/install\view\index\index.html";i:1521685276;s:67:"D:\www\TwoThink\public/../application/install\view\public\base.html";i:1521685276;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TwoThink <?php echo TWOTHINK_VERSION; ?> 安装</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link href="__STATIC__/bootstrap/css/bootstrap.css" rel="stylesheet">

        <script src="__STATIC__/js/jquery.js"></script>
        <script src="__STATIC__/bootstrap/js/bootstrap.js"></script>
    </head>

    <body class="jumbotron">
        <div class="container" style="margin-bottom: 50px;">
            <div class="row">
                <div class="col-xs-12">
                    <h1>TwoThink</h1>
                    <div>
                        <ul class="nav nav-pills nav-justified step step-progress" data-step="4">
                            
    <li class="active"><a href="javascript:;">安装协议</a></li>
    <li><a href="javascript:;">环境检测</a></li>
    <li><a href="javascript:;">创建数据库</a></li>
    <li><a href="javascript:;"><?php if(\think\Session::get('update') == '1'): ?>升级<?php else: ?>安装<?php endif; ?></a></li>
    <li><a href="javascript:;">完成</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-xs-12">
                    
    <h1>TwoThink <?php echo TWOTHINK_VERSION; ?> 安装协议</h1>
    <p>版权所有 (c) 2013~2017，艺品网络信息科技有限公司保留所有权利。</p>

    <p>感谢您选择<a href="http://www.twothink.cn" target="_blank" style="color: #f39c12;">TwoThink</a>，希望我们的努力能为您提供一个简单、强大的站点解决方案。</p>

    <p>用户须知：本协议是您与艺品网络之间关于您使用TwoThink产品及服务的法律协议。无论您是个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，包括免除或者限制艺品网络责任的免责条款及对您的权利限制。请您审阅并接受或不接受本服务条款。如您不同意本服务条款及/或艺品网络随时对其的修改，您应不使用或主动取消TwoThink产品。否则，您的任何对TwoThink的相关服务的注册、登陆、下载、查看等使用行为将被视为您对本服务条款全部的完全接受，包括接受艺品网络对服务条款随时所做的任何修改。</p>

    <p>本服务条款一旦发生变更, 艺品网络将在产品官网上公布修改内容。修改后的服务条款一旦在网站公布即有效代替原来的服务条款。您可随时登陆官网查阅最新版服务条款。如果您选择接受本条款，即表示您同意接受协议各项条件的约束。如果您不同意本服务条款，则不能获得使用本服务的权利。您若有违反本条款规定，艺品网络有权随时中止或终止您对TwoThink产品的使用资格并保留追究相关法律责任的权利。</p>

    <p>在理解、同意、并遵守本协议的全部条款后，方可开始使用TwoThink产品。您也可能与艺品网络直接签订另一书面协议，以补充或者取代本协议的全部或者任何部分。</p>

    <p>艺品网络拥有TwoThink的全部知识产权，包括商标和著作权。本软件只供许可协议，并非出售。艺品网络只允许您在遵守本协议各项条款的情况下复制、下载、安装、使用或者以其他方式受益于本软件的功能或者知识产权。</p>
	<p>TwoThink遵循Apache Licence2开源协议，并且免费使用（但不包括其衍生产品、插件或者服务）。Apache Licence是著名的非盈利开源组织Apache采用的协议。该协议和BSD类似，鼓励代码共享和尊重原作者的著作权，允许代码修改，再作为开源或商业软件发布。需要满足的条件：<br/>
1． 需要给用户一份Apache Licence ；<br/>
2． 如果你修改了代码，需要在被修改的文件中说明；<br/>
3． 在延伸的代码中（修改和有源代码衍生的代码中）需要带有原来代码中的协议，商标，专利声明和其他原来作者规定需要包含的说明；<br/>
4． 如果再发布的产品中包含一个Notice文件，则在Notice文件中需要带有本协议内容。你可以在Notice中增加自己的许可，但不可以表现为对Apache Licence构成更改。</p>

                </div>
            </div>
        </div>

        <footer class="footer navbar-fixed-bottom">
            <div class="container">
                <div>
                	
    <a class="btn btn-success btn-large" href="<?php echo url('Install/step1'); ?>">同意安装协议</a>
    <a class="btn btn-danger" href="http://www.twothink.cn">不同意</a>

                </div>
            </div>
        </footer>
    </body>
<style>
.jumbotron {
    color: #fff;
    background: #008d4c ;
}
.container h1{
    text-align: center;
}
.table caption{
    color: #ffffff;
}
a:hover, a:focus {
    color: #ffffff !important;
}
.text-left{
    text-align: left !important;
}
.step {
    counter-reset: flag;
}
.step li {
    position: relative;
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
}
.step li a {
    cursor: pointer;
    padding: 10px 15px;
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
}
.step li a:before {
    content: counter(flag);
    counter-increment: flag;
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
}
.step li a:after {
    content: "";
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
}
.step-arrow {
    margin: 20px 0;
}
.step-arrow.unhover li a:hover,
.step-arrow.unhover li a:focus {
    background-color: #f6f6f6;
    color: #444444;
}
.step-arrow.unhover li a:hover:before,
.step-arrow.unhover li a:focus:before {
    background-color: #d2d2d2;
    color: #ffffff;
}
.step-arrow.unhover li:not(:last-child) a:hover:after,
.step-arrow.unhover li:not(:last-child) a:focus:after {
    background-color: #f6f6f6;
}
.step-arrow li {
    padding-right: 20px;
}
.step-arrow li:last-child {
    padding-right: 0;
}
.step-arrow li:nth-child(n+2) a {
    margin-left: -20px;
    border-radius: 0;
}
.step-arrow li:not(:last-child) a:after {
    position: absolute;
    top: -1px;
    right: -20px;
    width: 40px;
    height: 40px;
    transform: scale(0.707) rotate(45deg);
    z-index: 1;
    background-color: #f6f6f6;
    border-radius: 0 5px 0 50px;
    border-top: 1px solid #ffffff;
    border-right: 1px solid #ffffff;
    box-sizing: content-box;
}
.step-arrow li:not(:last-child) a:hover:after {
    background-color: #00b8f5;
}
.step-arrow li a {
    border-radius: 0;
    color: #444444;
    background-color: #f6f6f6;
}
.step-arrow li a:hover {
    background-color: #00b8f5;
    color: #ffffff;
}
.step-arrow li a:hover:before {
    background: #ffffff;
    color: #00b8f5;
}
.step-arrow li a:before {
    position: absolute;
    z-index: 2;
    width: 20px;
    height: 20px;
    line-height: 20px;
    border-radius: 20px;
    left: 3rem;
    font-weight: bold;
    font-size: 1rem;
    overflow: hidden;
    top: 10px;
    background: #d2d2d2;
    color: #ffffff;
}
.step-arrow li.active a:before {
    background: #ffffff;
    color: #00b8f5;
}
.step-arrow li.active a:after {
    background-color: #00b8f5;
}
.step-arrow li.active a,
.step-arrow li.active a:hover {
    background-color: #00b8f5;
    color: #ffffff;
}
.step-arrow li.active a:before,
.step-arrow li.active a:hover:before {
    background-color: #ffffff;
    color: #00b8f5;
}
.step-arrow li.active a:after,
.step-arrow li.active a:hover:after {
    background-color: #00b8f5 !important;
}
.step-square {
    margin-top: 40px;
}
.step-square > li:hover a:before,
.step-square > li:active a:before,
.step-square > li.active a:before {
    background-color: #00b8f5;
    color: #ffffff;
    border-color: #00b8f5;
}
.step-square > li:hover a:after,
.step-square > li:active a:after,
.step-square > li.active a:after {
    background-color: #00b8f5;
}
.step-square > li:first-child a:after {
    left: 50%;
    border-right: 1px solid #ffffff;
}
.step-square > li:last-child a:after {
    right: 50%;
    border-left: 1px solid #ffffff;
}
.step-square > li > a {
    color: #ebebeb;
}
.step-square > li > a:hover {
    background-color: #ffffff;
    color: #00b8f5;
}
.step-square > li > a:before {
    position: absolute;
    z-index: 2;
    top: -2rem;
    left: 0;
    right: 0;
    margin: 0 auto;
    width: 2rem;
    height: 2rem;
    background-color: #ffffff;
    line-height: 20px;
    border: 1px solid #ebebeb;
}
.step-square > li > a:after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    top: -35%;
    background-color: #ebebeb;
    z-index: 1;
    height: 2px;
    border: solid #ffffff;
    border-width: 0 1px;
}
.step-square > li.active > a,
.step-square > li.active > a:focus,
.step-square > li.active > a:hover {
    color: #00b8f5;
    background: transparent;
}
.step-round {
    margin-top: 40px;
}
.step-round > li:first-child > a:after {
    left: 30%;
    border-radius: 5px 0 0 5px;
}
.step-round > li:last-child > a:after {
    right: 30%;
    border-radius: 0 5px 5px 0;
}
.step-round > li.active > a,
.step-round > li.active > a:hover,
.step-round > li.active > a:focus {
    background: transparent;
    color: #00b8f5;
}
.step-round > li.active > a:before,
.step-round > li.active > a:hover:before,
.step-round > li.active > a:focus:before {
    background-color: #00b8f5;
    color: #ffffff;
}
.step-round > li.active > a:after,
.step-round > li.active > a:hover:after,
.step-round > li.active > a:focus:after {
    background-color: #00b8f5;
}
.step-round > li > a {
    color: #ebebeb;
}
.step-round > li > a:before {
    position: absolute;
    z-index: 2;
    top: -2rem;
    left: 0;
    right: 0;
    margin: 0 auto;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background-color: #ffffff;
    line-height: 2rem;
    box-shadow: 0 0 0 5px #ebebeb;
}
.step-round > li > a:after {
    position: absolute;
    left: 0;
    right: 0;
    top: -38%;
    background-color: #ebebeb;
    z-index: 1;
    height: 8px;
}
.step-round > li > a:after:after {
    background-color: #00b8f5;
}
.step-round > li > a:hover {
    background: transparent;
    color: #00b8f5;
}
.step-round > li > a:hover:before {
    background-color: #00b8f5;
    color: #ffffff;
}
.step-round > li > a:hover:after {
    background-color: #00b8f5;
}
.step-progress {
    margin-top: 60px;
}
.step-progress > li > a {
    color: #ebebeb;
    padding-top: 1.8rem;
}
.step-progress > li > a:before {
    position: absolute;
    z-index: 2;
    top: -35px;
    left: 0;
    right: 0;
    margin: 0 auto;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    line-height: 2rem;
    box-shadow: 0 0 0 5px #ebebeb;
}
.step-progress > li > a:after {
    content: "";
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, rgba(0, 0, 0, 0) 75%, rgba(0, 0, 0, 0));
    background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, rgba(0, 0, 0, 0) 25%, rgba(0, 0, 0, 0) 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, rgba(0, 0, 0, 0) 75%, rgba(0, 0, 0, 0));
    -webkit-background-size: 40px 40px;
    background-size: 40px 40px;
    background-color: #ebebeb;
    float: left;
    width: 100%;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 10px;
    transition: all 0.5s ease-in-out;
    -webkit-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
}
.step-progress > li > a span.caret {
    position: absolute;
    left: 0;
    right: 0;
    margin: 0 auto;
    transform: rotate(180deg);
    top: -4px;
}
.step-progress > li > a:hover {
    background: transparent;
    color: #00b8f5;
}
.step-progress > li > a:hover:before {
    color: #ffffff;
    background-color: #00b8f5;
}
.step-progress > li > a:hover:after {
    background-color: #00b8f5;
}
.step-progress > li.active > a,
.step-progress > li.active > a:hover,
.step-progress > li.active > a:focus {
    color: #00b8f5;
    background: transparent;
}
.step-progress > li.active > a:before,
.step-progress > li.active > a:hover:before,
.step-progress > li.active > a:focus:before {
    background-color: #00b8f5;
    color: #ffffff;
}
.step-progress > li.active > a:after,
.step-progress > li.active > a:hover:after,
.step-progress > li.active > a:focus:after {
    background-color: #00b8f5;
}
.step-progress > li.active > a:after {
    -webkit-animation: progress-bar-stripes 2s linear infinite;
    -o-animation: progress-bar-stripes 2s linear infinite;
    animation: progress-bar-stripes 2s linear infinite;
}
.step-progress > li:first-child a:after {
    border-radius: 5px 0 0 5px;
}
.step-progress > li:last-child a:after {
    border-radius: 0 5px 5px 0;
}
</style>
</html>
