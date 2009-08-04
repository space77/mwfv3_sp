<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['chars'],'link'=>'./index.php?n=server&sub=chars');
//===== Calc pages1 =====//
$items_per_pages = $config['users_per_page'];
$limit_start = ($p-1)*$items_per_pages;

if(!$_GET['realm']){
  $realm_list = realm_list();
  $count = count($realm_list);
  if ($count==1){
    $id=$DB->selectCell("SELECT `id` FROM `realmlist` ORDER BY `name`");
    $_GET['realm'] = $id;
  }
}

if($_GET['realm']){
  $realm_info = get_realm_byid($_GET['realm']);
  $pathway_info[] = array('title'=>$realm_info['name'],'');
  
  if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
  $CHDB_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
    
  $CHDB = DbSimple_Generic::connect("".$config['db_type']."://".$CHDB_info['user'].":".$CHDB_info['password']."@".$CHDB_info['host'].":".$CHDB_info['port']."/".$CHDB_info['db']."");
  if($CHDB)$CHDB->setErrorHandler('databaseErrorHandler');
  if($CHDB)$CHDB->query("SET NAMES ".$config['db_encoding']);
  
  if($_GET['char'] && preg_match("/[a-z]/",$_GET['char'])){
    $filter = "WHERE `name` LIKE '".$_GET['char']."%'";
  }elseif($_GET['char']==1){
    $filter = "WHERE `name` REGEXP '^[^A-Za-z]'";
  }else{
    $filter = '';
  }
	
  if($CHDB)$query = $CHDB->select("SELECT * FROM `characters` $filter ORDER BY `name` LIMIT $limit_start,$items_per_pages");
	AddMangosFields ($realm_info['Version']);
  foreach ($query as $result) {
    $my_char = new character($result, $mangos_field);
    $cc++;
    $item_res[$cc]["name"]    = $my_char->name;
    $item_res[$cc]["race"]    = $my_char->race;
    $item_res[$cc]["class"]   = $my_char->class;
    $item_res[$cc]["gender"]  = $my_char->gender;
    $item_res[$cc]["level"]   = $my_char->level;
    $item_res[$cc]["pos"]     = get_zone_name($my_char->map, $my_char->position_x, $my_char->position_y);
    $item_res[$cc]["current_xp"]    = $my_char->current_xp;
    $item_res[$cc]["next_level_xp"] = $my_char->next_level_xp;
    $item_res[$cc]["xp_perc"]       = $my_char->xp_perc;
  }
  
  if($CHDB)$query = $CHDB->selectcell("SELECT COUNT(*) as cnt FROM `characters` $filter ORDER BY `name`");  
  $pnum = ceil($query/$items_per_pages); 
	$pages_str = default_paginate($pnum, $p, "index.php?n=server&sub=chars&realm=".$_GET['realm']."&char=".$_GET['char']);
	
  unset ($CHDB, $query, $result, $my_char);
}
?>




