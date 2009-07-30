<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['guilds'],'link'=>'index.php?n=server&sub=guilds');
// ==================== //

if(!$_GET['realm']){
    $realm_list = realm_list();
    $count = count($realm_list);
    if ($count==1){
      $id=$DB->selectCell("SELECT `id` FROM `realmlist` ORDER BY `name`");
      $_GET['realm'] = $id;
    }
}

if($_GET['realm'] AND !$_GET['guildid']){
    $realm_info = get_realm_byid($_GET['realm']);
    $pathway_info[] = array('title'=>$realm_info['name'],'');
    
    if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
    $CHDB_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
    
    $CHDB = DbSimple_Generic::connect("".$config['db_type']."://".$CHDB_info['user'].":".$CHDB_info['password']."@".$CHDB_info['host'].":".$CHDB_info['port']."/".$CHDB_info['db']."");
    if($CHDB)$CHDB->setErrorHandler('databaseErrorHandler');
    if($CHDB)$CHDB->query("SET NAMES ".$config['db_encoding']);
    
    if($CHDB)$query = $CHDB->select("SELECT * FROM `guild`");  
        
    foreach ($query as $result) {
      if($res_color==1)$res_color=2;else$res_color=1;
      $cc++;     
		
		  if($CHDB)$g_players = $CHDB->selectCell("SELECT count(*) FROM `guild_member` WHERE `guildid`=?d", $result['guildid']); 
		  if($CHDB)$g_leader = $CHDB->select("SELECT `name` FROM `characters` WHERE `guid`=?d", $result['leaderguid']); 
		
      $res_info[$cc]["number"] = $cc;
      $res_info[$cc]["res_color"] = $res_color;
		  $res_info[$cc]["guildid"] = $result['guildid'];
      $res_info[$cc]["name"] = $result['name'];
		  $res_info[$cc]["info"] = $result['info'];
      $res_info[$cc]["leader"] = $g_leader[0]['name'];
      $res_info[$cc]["players"] = $g_players;
      $res_info[$cc]["online"] = $result['online'];
		  $res_info[$cc]["createdate"] = $result['createdate'];
    }
    unset($CHDB, $query);
}

if($_GET['realm'] AND $_GET['guildid']){
	$realm_info = get_realm_byid($_GET['realm']);
  $pathway_info[] = array('title'=>$realm_info['name'],'link'=>'index.php?n=server&sub=guilds&realm='.$_GET['realm']);
	
  if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
  $CHDB_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
    
  $CHDB = DbSimple_Generic::connect("".$config['db_type']."://".$CHDB_info['user'].":".$CHDB_info['password']."@".$CHDB_info['host'].":".$CHDB_info['port']."/".$CHDB_info['db']."");
  if($CHDB)$CHDB->setErrorHandler('databaseErrorHandler');
  if($CHDB)$CHDB->query("SET NAMES ".$config['db_encoding']);
        
	$g_name = $CHDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=?d", $_GET['guildid']);
	$pathway_info[] = array('title'=>$g_name,'');
	if($CHDB)$guids = $CHDB->select("SELECT guid FROM `guild_member` WHERE `guildid`=?d", $_GET['guildid']);

	AddMangosFields ($realm_info['Version']);
		
	if($CHDB)$g_player = $CHDB->select("SELECT * FROM `characters` WHERE `guid` IN (?a)", array_map("getguid", $guids));
	foreach ($g_player as $player) 
	{
	    
			$my_char = new character($player, $mangos_field);
			$cc++;
			//$res_info[$cc]["res_color"] = $res_color;
			$res_info[$cc]["name"] = $my_char->name;
			$res_info[$cc]["race"] = $my_char->race;
			$res_info[$cc]["class"] = $my_char->class;
			$res_info[$cc]["gender"] = $my_char->gender;
			$res_info[$cc]["level"] = $my_char->level;
			$res_info[$cc]["pos"] = get_zone_name($my_char->map, $my_char->position_x, $my_char->position_y);
			$res_info[$cc]["online"] = (($my_char->online==0) ? "downarrow2.gif" : "uparrow2.gif"); 
			unset($my_char);
	}
  unset($CHDB, $guids, $g_player);
}

function getguid($val){
  return $val['guid'];
}
?>
