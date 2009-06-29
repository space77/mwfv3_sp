<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['arenateams'],'link'=>'index.php?n=server&sub=arenateams');
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
  $pathway_info[] = array('title'=>$realm_info['name'],'link'=>'index.php?n=server&sub=arenateams&realm='.$_GET['realm']);
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
        if($WSDB)$query = $WSDB->select("SELECT * FROM 
	                                                 `arena_team`
	                                                 , `arena_team_stats` 	
                                        WHERE `arena_team`.`arenateamid` = `arena_team_stats`.`arenateamid`
                                        ORDER BY `type` ASC, `rating` DESC , `name` ASC;");
    foreach ($query as $result) {
        if($res_color==1)$res_color=2;else$res_color=1;
        $cc++;     
	 
		    if($WSDB)$captain = $WSDB->select("SELECT `name` FROM `characters` WHERE `guid`=?d", $result['captainguid']); 
		
        $res_info[$cc]["number"] = $cc;
        $res_info[$cc]["res_color"] = $res_color;
		    
        $res_info[$cc]["arenateamid"] = $result['arenateamid'];
        $res_info[$cc]["name"] = $result['name'];
		    $res_info[$cc]["type"] = $result['type'];
        $res_info[$cc]["captain"] = $captain[0]['name'];
        $res_info[$cc]["rating"] = $result['rating'];;
        $res_info[$cc]["games"] = $result['games'];
		    $res_info[$cc]["wins"] = $result['wins'];
		    $res_info[$cc]["played"] = $result['played'];
		    $res_info[$cc]["wins2"] = $result['wins2'];
		    $res_info[$cc]["rank"] = $result['rank'];
    }
    unset($WSDB);
}

if($_GET['arenateamid']){
	$res_info = array();
	$query = array();
	$realm_info = get_realm_byid($_GET['realm']);
	$cc = 0;
	
	if ($realm_info['Version']!==''){
			require_once 'core/cache/'.$realm_info['Version'].'/UpdateFields.php';		
		} else {
			require_once 'core/cache/UpdateFields.php';	
		}
		
    if(check_port_status($realm_info['address'], $realm_info['port'])!==true){
        output_message('alert','Realm <b>'.$realm_info['name'].'</b> is offline <img src="images/downarrow2.gif" border="0" align="top">');
    }

	if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
  $wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
  $WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
  if($WSDB)$WSDB->setErrorHandler('databaseErrorHandler');
  if($WSDB)$WSDB->query("SET NAMES ".$config['db_encoding']);
        
  if ($WSDB)$t_name=$WSDB->SelectCell("SELECT `name` FROM `arena_team` WHERE arenateamid=?d", $_GET['arenateamid']); 
  $pathway_info[] = array('title'=>$t_name,'link'=>'');
  
	if ($WSDB)$t_type=$WSDB->SelectCell("SELECT `type` FROM `arena_team` WHERE arenateamid=?d", $_GET['arenateamid']);
	$t_slot = AT_GetSlotByType($t_type);
	
	if ($WSDB)$t_rating=$WSDB->SelectCell("SELECT `rating` FROM `arena_team_stats` WHERE arenateamid=?d", $_GET['arenateamid']);
	if ($WSDB)$t_games=$WSDB->SelectCell("SELECT `games` FROM `arena_team_stats` WHERE arenateamid=?d", $_GET['arenateamid']);
	  
  if($WSDB)$query = $WSDB->select("SELECT * FROM `arena_team_member` WHERE arenateamid=?d;", $_GET['arenateamid']);
        
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
			 $res_info[$cc]["played_week"] = $result['played_week'];
			 $res_info[$cc]["wons_week"] = $result['wons_week'];
			 $res_info[$cc]["played_season"] = $result['played_season'];
			 $res_info[$cc]["wons_season"] = $result['wons_season'];
			 $res_info[$cc]["points_to_add"] = $result['points_to_add'];
			 $res_info[$cc]["MemberRaiting"] = $result['personal_rating']; // $char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PAR];
			 $res_info[$cc]["AT_GetPoints"] = AT_GetPoints($t_type, $t_rating, $res_info[$cc]["MemberRaiting"], $t_games, $res_info[$cc]["played_week"]);
			 $res_info[$cc]["AT_MiscInfo"] = 'AT_ID:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_TID].'; '.
			 																 'AT_PTYPE:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PTYPE].'; '.
																			 'AT_PTW:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PTW].'; '.
																			 'AT_PTS:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PTS].'; '.
																			 'AT_UNK:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_UNK].'; '.
																			 'AT_PAR:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PAR].'; '.
																			 'AT_GetPoints:'.$res_info[$cc]["AT_GetPoints"];
		}
	}
    unset($WSDB);
}
?>
