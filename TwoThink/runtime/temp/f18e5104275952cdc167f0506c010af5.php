<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"D:\www\TwoThink\public/../application/admin/view/default/menu\sidenodes.html";i:1521685276;s:75:"D:\www\TwoThink\public/../application/admin/view/default/category\tree.html";i:1521685276;}*/ ?>
<?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
<li class="dd-item dd-item-alt" data-id="<?php echo $list['id']; ?>">
    <div class="dd-handle"><i class="fa fa-arrows" aria-hidden="true"></i></div>
    <div class="dd-content">
        <span class="pull-right">
            <a class="ajax-get iframe btn btn-xs bg-aqua" title="新增" href="<?php echo url('add?pid='.$list['id']); ?>">新增</a>
            <a class="ajax-get iframe btn btn-xs bg-teal" title="编辑" href="<?php echo url('edit?id='.$list['id'].'&pid='.$list['pid']); ?>">编辑</a>
            <a title="<?php echo show_status_op($list['status']); ?>" href="<?php echo url('setStatus?model=category&ids='.$list['id'].'&status='.abs(1-$list['status'])); ?>" class="ajax-get btn btn-xs bg-yellow"><?php echo show_status_op($list['status']); ?></a>
            <a class="confirm ajax-get btn btn-xs bg-red" title="删除" href="<?php echo url('remove?id='.$list['id']); ?>">删除</a>
            <a class="ajax-get iframe btn btn-xs bg-teal" title="合并" href="<?php echo url('operate?type=merge&from='.$list['id']); ?>">合并</a>
        </span>
        <span class="label label-info"><i class="fa fa-cog"></i></span>
        <span><?php echo $list['title']; ?></span>
    </div>
    <?php if(!(empty($list['_']) || (($list['_'] instanceof \think\Collection || $list['_'] instanceof \think\Paginator ) && $list['_']->isEmpty()))): ?>
    <ol class="dd-list">
        <?php echo action('Category/tree', array($list['_'])); ?>
    </ol>
    <?php endif; ?>
</li>
<?php endforeach; endif; else: echo "" ;endif; ?>