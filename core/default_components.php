<?php
$mainnav_links = array (
  '1-menuNews' => 
  array (
    0 => 
    array (
      0 => 'mainpage',
      1 => 'index.php',
      2 => '',
    ),
  ),
  '2-menuAccount' => 
  array (
    0 => 
    array (
      0 => 'account_manage',
      1 => 'index.php?n=account&sub=manage',
      2 => 'g_view_profile',
    ),
    1 => 
    array (
      0 => 'account_create',
      1 => 'index.php?n=account&sub=register',
      2 => '',
    ),
    2 => 
    array (
      0 => 'activation',
      1 => 'index.php?n=account&sub=activate',
      2 => '',
    ),
    3 => 
    array (
      0 => 'retrieve_pass',
      1 => 'index.php?n=account&sub=restore',
      2 => '',
    ),
  ),
  '4-menuInteractive' => 
  array (
    0 => 
    array (
      0 => 'realms_status',
      1 => 'index.php?n=server&sub=realmstatus',
      2 => '',
    ),
    1 => 
    array (
      0 => 'honor',
      1 => 'index.php?n=server&sub=honor',
      2 => '',
    ),
    2 => 
    array (
      0 => 'players_online',
      1 => 'index.php?n=server&sub=playersonline',
      2 => '',
    ),
    3 => 
    array (
      0 => 'guilds',
      1 => 'index.php?n=server&sub=guilds',
      2 => '',
    ),
    4 => 
    array (
      0 => 'bugs',
      1 => 'index.php?n=server&sub=bugtracker',
      2 => '',
    ),
  ),
  '6-menuForums' => 
  array (
    0 => 
    array (
      0 => 'forums',
      1 => 'index.php?n=forum',
      2 => '',
    ),
  ),
  '8-menuSupport' => 
  array (
    0 => 
    array (
      0 => 'gmlist',
      1 => 'index.php?n=server&sub=gms',
      2 => '',
    ),
  ),
);

$allowed_ext = array (
  0 => 'account',
  1 => 'admin',
  2 => 'ajax',
  3 => 'forum',
  4 => 'frontpage',
  5 => 'html',
  6 => 'server',
);?>