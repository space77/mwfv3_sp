<?php
if(INCLUDED!==true)exit;
@include ("core/cache/links_cache.php");

$pathway_info[] = array('title'=>$lang['UWallp'],'link'=>'');

$lvladd = $links_conf["lvladdgalwallp"];
$allowadd = ($user['g_id'] >= $lvladd)? true : false;

$lvlview = $links_conf["lvlwallp"];
$allowview = ($user['g_id'] >= $lvlview)? true : false;

if (!$allowview){$allovadd=false;};

if (!$allowadd){
    output_message('alert','<b>'.$lang['youhavenorights'].'</b><meta http-equiv=refresh content="2;url=index.php">');
}
?>
