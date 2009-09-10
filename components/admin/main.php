<?php
$com_content['admin'] = array(
    'index' => array(
        'g_is_admin', // g_ option require for view     [0]
        'admin_panel', // loc name (key)                [1]
        'index.php?n=admin', // Link to                 [2]
        '', // main menu name/id ('' - not show)        [3]
        0 // show in context menu (1-yes,0-no)          [4]
    ),
    'members' => array(
        'g_is_supadmin', 
        'users_manage', 
        'index.php?n=admin&sub=members',
        '',
        1
    ),
    'config' => array(
        'g_is_supadmin', 
        'site_config', 
        'index.php?n=admin&sub=config',
        '',
        1
    ),
    'components' => array(
        'g_is_supadmin', 
        'components_manage', 
        'index.php?n=admin&sub=components',
        '',
        1
    ),
    'realms' => array(
        'g_is_supadmin', 
        'realms_manage', 
        'index.php?n=admin&sub=realms',
        '',
        1
    ),
    'forum' => array(
        'g_is_admin', 
        'forums_manage', 
        'index.php?n=admin&sub=forum',
        '',
        1
    ),
    'keys' => array(
        'g_is_admin', 
        'regkeys_manage', 
        'index.php?n=admin&sub=keys',
        '',
        1
    ),
    'langs' => array(
        'g_is_admin', 
        'langs_manage', 
        'index.php?n=admin&sub=langs',
        '',
        1
    ),
    'menu' => array(
        'g_is_admin', 
        'menu_manage', 
        'index.php?n=admin&sub=menu',
        '',
        1
    ),
    'banaction' => array(
        'g_is_admin', 
        'banaction', 
        'index.php?n=admin&sub=banaction',
        '',
        1
    ),
);
?>
