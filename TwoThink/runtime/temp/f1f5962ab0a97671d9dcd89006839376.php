<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:41:"D:\www\TwoThink\addons\sitestat\info.html";i:1521685276;}*/ ?>
<div class="col-md-<?php echo 12/$addons_config['width'];  ?>">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">用户数</span>
				<span class="info-box-number"><?php echo $info['user']; ?></span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-red"><i class="fa fa-slideshare"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">用户行为</span>
				<span class="info-box-number"><?php echo $info['action']; ?></span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-green"><i class="fa fa-file-text-o"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">文档数</span>
				<span class="info-box-number"><?php echo $info['document']; ?></span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-yellow"><i class="fa fa-clipboard"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">文档模型</span>
				<span class="info-box-number"><?php echo $info['model']; ?></span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-green"><i class="fa fa-list"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">分类数</span>
				<span class="info-box-number"><?php echo $info['category']; ?></span>
			</div>
		</div>
	</div>

</div>