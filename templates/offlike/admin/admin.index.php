<h2> <?php echo $lang['admin_panel'];?> 0_0 </h2>
<ul style="font-weight:bold;">
    <?php foreach($context_menu as $menuitem){ ?>
    <li><a href="<?php echo $menuitem['link'];?>"><?php echo $menuitem['title'];?></a>
    <?php } ?>
</ul>