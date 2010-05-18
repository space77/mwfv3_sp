<?php
if(INCLUDED!==true)exit;
@include ("core/cache/links_cache.php");

$pathway_info[] = array('title'=>$lang['UScreen'],'link'=>'');

$lvladd = $links_conf["lvladdgalscreen"];
$allowadd = ($user['g_id'] >= $lvladd)? true : false;

$lvlview = $links_conf["lvlscreen"];
$allowview = ($user['g_id'] >= $lvlview)? true : false;

if (!$allowview) {$allowadd=false;};

if (!$allowadd){
  output_message('alert','<b>'.$lang['youhavenorights'].'</b><meta http-equiv=refresh content="2;url=index.php">');
}
?>
