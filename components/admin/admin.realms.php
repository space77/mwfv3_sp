<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['realms_manage'],'link'=>'index.php?n=admin&sub=realms');
// ==================== //

if(!$_GET['action']){

    $items = $DB->select("SELECT * FROM realmlist ORDER BY `name`");

}elseif($_GET['action']=='edit' && $_GET['id']){
    $pathway_info[] = array('title'=>$lang['editing'],'link'=>'');
    $item = $DB->selectRow("SELECT * FROM realmlist WHERE `id`=?d",$_GET['id']);
}elseif($_GET['action']=='update' && $_GET['id']){
    $DB->query("UPDATE realmlist SET ?a WHERE id=?d LIMIT 1",$_POST,$_GET['id']);
    redirect('index.php?n=admin&sub=realms',1);
}elseif($_GET['action']=='create'){
    $DB->query("INSERT INTO realmlist SET ?a",$_POST);
    redirect('index.php?n=admin&sub=realms',1);
}elseif($_GET['action']=='delete' && $_GET['id']){
    $DB->query("DELETE FROM realmlist WHERE id=?d LIMIT 1",$_GET['id']);
    redirect('index.php?n=admin&sub=realms',1);
}

?>