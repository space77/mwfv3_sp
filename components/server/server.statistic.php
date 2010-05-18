<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['statistic'],'link'=>'index.php?n=server&sub=statistic');
// ==================== //

if(!$_GET['realm']){
    $realm_list = realm_list();
    $count = count($realm_list);
    if ($count==1){
      $id=$DB->selectCell("SELECT `id` FROM `realmlist` ORDER BY `name`");
      $_GET['realm'] = $id;
    }
}

if($_GET['realm']){
	$res_info = array();
	$realm_info = get_realm_byid($_GET['realm']);
	$pathway_info[] = array('title'=>$realm_info['name'],'');
	$cc = 0;
    //if(check_port_status($realm_info['address'], $realm_info['port'])===true)
    //{
   	if(!$realm_info['WorldDatabaseInfo'])output_message('alert','Check field <u>WorldDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
		$wsdb_info = parse_worlddb_info($realm_info['WorldDatabaseInfo']);
		$WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
		if($WSDB)$WSDB->setErrorHandler('databaseErrorHandler');
		if($WSDB)$WSDB->query("SET NAMES ".$config['db_encoding']);
		
    $num_quest = $WSDB->selectCell("SELECT count(*) FROM `quest_template`"); 
		$num_npc = $WSDB->selectCell("SELECT count(*) FROM `creature_template`"); 
		$num_items = $WSDB->selectCell("SELECT count(*) FROM `item_template`"); 
		$num_obj = $WSDB->selectCell("SELECT count(*) FROM `gameobject_template`"); 
		
		if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
		$wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
		$WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
		if($WSDB)$WSDB->setErrorHandler('databaseErrorHandler');
		if($WSDB)$WSDB->query("SET NAMES ".$config['db_encoding']);

		$num_human = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 1"); 
		$num_orc = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 2"); 
		$num_dwarf = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 3"); 
		$num_ne = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 4"); 
		$num_undead = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 5"); 
		$num_tauren = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 6"); 
		$num_gnome = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 7"); 
		$num_troll = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 8"); 
		$num_be = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 10"); 
		$num_draenai = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `race` = 11");
		$num_ally = $num_human + $num_dwarf + $num_ne + $num_gnome + $num_draenai; 
		$num_horde = $num_orc + $num_undead + $num_tauren + $num_troll + $num_be;
		$num_chars = $num_ally + $num_horde;

		$num_1 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 1"); 
		$num_2 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 2"); 
		$num_3 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 3"); 
		$num_4 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 4"); 
		$num_5 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 5");
		$num_7 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 7"); 
		$num_8 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 8");
		$num_9 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 9"); 
		$num_11 = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE `class` = 11");

		$num_char = $WSDB->selectCell("SELECT count(*) FROM `characters`"); 
		$num_guilds = $WSDB->selectCell("SELECT count(*) FROM `guild`"); 
		$num_pguild = $WSDB->selectCell("SELECT count(*) FROM `guild_member`");

		$pc_1 =  round($num_1/$num_char*100,2);
		$pc_2 =  round($num_2/$num_char*100,2);
		$pc_3 = round($num_3/$num_char*100,2);
		$pc_4 = round($num_4/$num_char*100,2);
		$pc_5 = round($num_5/$num_char*100,2);
		$pc_7 = round($num_7/$num_char*100,2);
		$pc_8 = round($num_8/$num_char*100,2);
		$pc_9 = round($num_9/$num_char*100,2);
		$pc_11 = round($num_11/$num_char*100,2);

		$pc_ally =  round($num_ally/$num_chars*100,2);
		$pc_horde =  round($num_horde/$num_chars*100,2);
		$pc_human = round($num_human/$num_chars*100,2);
		$pc_orc = round($num_orc/$num_chars*100,2);
		$pc_dwarf = round($num_dwarf/$num_chars*100,2);
		$pc_ne = round($num_ne/$num_chars*100,2);
		$pc_undead = round($num_undead/$num_chars*100,2);
		$pc_tauren = round($num_tauren/$num_chars*100,2);
		$pc_gnome = round($num_gnome/$num_chars*100,2);
		$pc_troll = round($num_troll/$num_chars*100,2);
		$pc_draenei = round($num_draenai/$num_chars*100,2);
		$pc_bloodelves = round($num_be/$num_chars*100,2);

		if($WSDB)$acc=$DB->selectCell("SELECT count(*) FROM `account`");
		if($WSDB)$guild=$WSDB->selectCell("SELECT count(*) FROM `guild`;");
		if($WSDB)$pets=$WSDB->selectCell("SELECT count(*) FROM `character_pet`;");
	//}else{
	if(check_port_status($realm_info['address'], $realm_info['port'])!==true){
		output_message('alert','Realm <b>'.$realm_info['name'].'</b> is offline <img src="images/downarrow2.gif" border="0" align="top">');
	}
	unset($WSDB);
}

?>
