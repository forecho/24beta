<div class="admin-sidebar">
    <?php foreach ($menus as $menu):?>
    <h3 class="menu-item"><?php echo l($menu['title'], $menu['url'], $menu['htmlOptions']);?></h3>
    <?php if (count($menu['subs']) > 0):?>
        <ul class="sub-menu">
            <?php foreach ($menu['subs'] as $sub):?>
            <li class="sub-menu-item"><?php echo l($sub['title'], $sub['url'], $sub['htmlOptions']);?></li>
            <?php endforeach;?>
        </ul>
    <?php endif?>
    <?php endforeach;?>
</div>