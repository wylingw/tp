<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\www\TwoThink\public/../application/admin/view/default/menu\sidenodes.html";i:1521685276;}*/ ?>

<?php if(is_array($tree) || $tree instanceof \think\Collection || $tree instanceof \think\Paginator): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;if(!(empty($menu['operater']) || (($menu['operater'] instanceof \think\Collection || $menu['operater'] instanceof \think\Paginator ) && $menu['operater']->isEmpty()))): ?>
        <li class="treeview <?php if(!(empty($menu['current']) || (($menu['current'] instanceof \think\Collection || $menu['current'] instanceof \think\Paginator ) && $menu['current']->isEmpty()))): ?>active<?php endif; ?>">
            <a href="<?php echo $menu['url']; ?>">
                <i class="<?php if(empty($menu['icon']) || (($menu['icon'] instanceof \think\Collection || $menu['icon'] instanceof \think\Paginator ) && $menu['icon']->isEmpty())): ?>fa fa-circle-o <?php else: ?><?php echo $menu['icon']; endif; ?>"></i> <span><?php echo $menu['title']; ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu" style="display: <?php if(!(empty($menu['current']) || (($menu['current'] instanceof \think\Collection || $menu['current'] instanceof \think\Paginator ) && $menu['current']->isEmpty()))): ?>block<?php else: ?>none<?php endif; ?>">
                <?php echo action('Menu/sidetree', array($menu['operater'],'menu/sidenodes')); ?>
            </ul>
        </li>
    <?php else: ?>
        <li class="<?php if(!(empty($menu['current']) || (($menu['current'] instanceof \think\Collection || $menu['current'] instanceof \think\Paginator ) && $menu['current']->isEmpty()))): ?>active<?php endif; ?>"><a href="<?php echo $menu['url']; ?>"><i class="<?php if(empty($menu['icon']) || (($menu['icon'] instanceof \think\Collection || $menu['icon'] instanceof \think\Paginator ) && $menu['icon']->isEmpty())): ?>fa fa-circle-o <?php else: ?><?php echo $menu['icon']; endif; ?>"></i><?php echo $menu['title']; ?></a></li>
    <?php endif; endforeach; endif; else: echo "" ;endif; ?>