<div class="admin-sidebar">
    <?php foreach ($menus as $menu):?>
        <ul class="nav nav-list sidebar-menus">
            <?php if ($menu['url']):?>
            <li><?php echo l($menu['title'], $menu['url'], $menu['htmlOptions']);?></li>
            <?php else:?>
            <li><?php echo $menu['title'];?></li>
            <?php endif;?>
            <?php foreach ((array)$menu['subs'] as $sub):?>
            <li class="sub-item"><?php echo l($sub['title'], $sub['url'], $sub['htmlOptions']);?></li>
            <?php endforeach;?>
        </ul>
    <?php endforeach;?>
</div>

