<?php
$com_content['frontpage'] = array(
    'index' => array(
        '', // g_ option require for view     [0]
        'mainpage', // loc name (key)                [1]
        'index.php', // Link to                 [2]
        '1-menuNews', // main menu name/id ('' - not show)        [3]
        0 // show in context menu (1-yes,0-no)          [4]
    ),
    'rules' => array(
        '', 
        'rules', 
        'index.php?n=frontpage&sub=rules&cat=rules',
        '1-menuNews',
        0
    ),
    'faq' => array(
        '', 
        'faq', 
        'index.php?n=frontpage&sub=rules&cat=faq',
        '1-menuNews',
        0
    ),
    'patchs' => array(
        '', 
        'patchs', 
        'index.php?n=frontpage&sub=rules&cat=patchs',
        '1-menuNews',
        0
    )
);
?>
