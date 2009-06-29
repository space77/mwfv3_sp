<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
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

if($_GET['realm']){
  $res_info = array();
  $query = array();
  $realm_info = get_realm_byid($_GET['realm']);
  $pathway_info[] = array('title'=>$realm_info['name'],'link'=>'index.php?n=server&sub=guilds&realm='.$_GET['realm']);
  $cc = 0;
  
	if ($realm_info['Version']!==''){
			require_once 'core/cache/'.$realm_info['Version'].'/UpdateFields.php';		
		} else {
			require_once 'core/cache/UpdateFields.php';	
		}
		  
		if(check_port_status($realm_info['address'], $realm_info['port'])!==true) {
        output_message('alert','Realm <b>'.$realm_info['name'].'</b> is offline <img src="images/downarrow2.gif" border="0" align="top">');
    }
        
				if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
        $wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
        $WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
        if($WSDB)$WSDB->setErrorHandler('databaseErrorHandler');
        if($WSDB)$WSDB->query("SET NAMES ".$config['db_encoding']);
        if($WSDB)$query = $WSDB->select("SELECT * FROM `guild`");
        
    foreach ($query as $result) {
        if($res_color==1)$res_color=2;else$res_color=1;
        $cc++;     
		
		if($WSDB)$g_players = $WSDB->selectCell("SELECT count(*) FROM `guild_member` WHERE `guildid`=?d", $result['guildid']); 
		if($WSDB)$g_leader = $WSDB->select("SELECT `name` FROM `characters` WHERE `guid`=?d", $result['leaderguid']); 
		
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
    unset($WSDB);
}

if($_GET['guildid']){
	$res_info = array();
	$query = array();
	$realm_info = get_realm_byid($_GET['realm']);
	$cc = 0;
	
	if ($realm_info['Version']!==''){
			require_once 'core/cache/'.$realm_info['Version'].'/UpdateFields.php';		
		} else {
			require_once 'core/cache/UpdateFields.php';	
		}
		
    if(check_port_status($realm_info['address'], $realm_info['port'])!==true) {
        output_message('alert','Realm <b>'.$realm_info['name'].'</b> is offline <img src="images/downarrow2.gif" border="0" align="top">');
    }
    
        if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
        $wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
        $WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
        if($WSDB)$WSDB->setErrorHandler('databaseErrorHandler');
        if($WSDB)$WSDB->query("SET NAMES ".$config['db_encoding']);
        
				$g_name = $WSDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=?d", $_GET['guildid']);
				$pathway_info[] = array('title'=>$g_name,'');
				if($WSDB)$query = $WSDB->select("SELECT * FROM `guild_member` WHERE `guildid`=?d", $_GET['guildid']);




	foreach ($query as $result) 
	{
		if($res_color==1)$res_color=2;else$res_color=1;
		if($WSDB)$g_player = $WSDB->select("SELECT * FROM `characters` WHERE `guid`=?d", $result['guid']);
		foreach ($g_player as $player) 
		{
			$cc++;
			$online = ($player['online']==0) ? "downarrow2.gif" : "uparrow2.gif"; 
			$res_race = $site_defines['character_race'][$player['race']];
			$res_class = $site_defines['character_class'][$player['class']];
			$res_pos=get_zone_name($player['map'], $player['position_x'], $player['position_y']);
			$char_data = explode(' ',$player['data']);

			$res_info[$cc]["res_color"] = $res_color;
			$res_info[$cc]["number"] = $cc;
			$res_info[$cc]["name"] = $player['name'];
			$res_info[$cc]["race"] = $player['race'];
			$res_info[$cc]["class"] = $player['class'];
			$res_info[$cc]["gender"] = ((int)($char_data[$mangos_field['UNIT_FIELD_BYTES_0']]) >> 16) & hexdec('FF');
			$res_info[$cc]["level"] = $char_data[$mangos_field['UNIT_FIELD_LEVEL']];
			$res_info[$cc]["pos"] = $res_pos;
			$res_info[$cc]["online"] = $online;
		}
	}
    unset($WSDB);
}
?>
