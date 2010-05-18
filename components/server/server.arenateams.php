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

if($_GET['realm'] AND !$_GET['arenateamid']){
  $realm_info = get_realm_byid($_GET['realm']);
  $pathway_info[] = array('title'=>$realm_info['name'],'');
  
  if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
  $CHDB_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
    
  $CHDB = DbSimple_Generic::connect("".$config['db_type']."://".$CHDB_info['user'].":".$CHDB_info['password']."@".$CHDB_info['host'].":".$CHDB_info['port']."/".$CHDB_info['db']."");
  if($CHDB)$CHDB->setErrorHandler('databaseErrorHandler');
  if($CHDB)$CHDB->query("SET NAMES ".$config['db_encoding']);
    
  if($CHDB)$query = $CHDB->select("SELECT * FROM 
	                                          `arena_team`, `arena_team_stats` 	
                                    WHERE `arena_team`.`arenateamid` = `arena_team_stats`.`arenateamid`
                                    ORDER BY `type` ASC, `rating` DESC , `name` ASC;");
  foreach ($query as $result) {       
		if($CHDB)$captain = $CHDB->select("SELECT `name` FROM `characters` WHERE `guid`=?d", $result['captainguid']); 
		$cc++;    
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
  unset($CHDB, $query, $result);
}

if($_GET['realm'] AND $_GET['arenateamid']){
  $realm_info = get_realm_byid($_GET['realm']);
  $pathway_info[] = array('title'=>$realm_info['name'],'link'=>'index.php?n=server&sub=arenateams&realm='.$_GET['realm']);

  if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
  $CHDB_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
    
  $CHDB = DbSimple_Generic::connect("".$config['db_type']."://".$CHDB_info['user'].":".$CHDB_info['password']."@".$CHDB_info['host'].":".$CHDB_info['port']."/".$CHDB_info['db']."");
  if($CHDB)$CHDB->setErrorHandler('databaseErrorHandler');
  if($CHDB)$CHDB->query("SET NAMES ".$config['db_encoding']);
        
  if ($CHDB)$query=$CHDB->SelectRow("SELECT t.`name`, t.`type`, s.`rating`, s.`games` 
                                  FROM `arena_team` as t, `arena_team_stats` as s 
                                  WHERE ((t.arenateamid=s.arenateamid) AND (t.arenateamid=?d))", $_GET['arenateamid']);
  if ($query){
    $t_slot = AT_GetSlotByType($query['type']);
    $t_name = $query['name'];
    $t_rating = $query['rating'];
    $t_games = $query['games'];
    $pathway_info[] = array('title'=>$t_name, 'link'=>'');  
  }
  	  
  if($CHDB)$query = $CHDB->select("SELECT tm.* , ch.*
                                  FROM `arena_team_member` as tm, `characters` as ch
                                  WHERE ((ch.`guid`=tm.`guid`) AND (arenateamid=?d));", $_GET['arenateamid']);
  
  AddMangosFields ($realm_info['Version']);
      
	foreach ($query as $result){
    $my_char = new character($result, $mangos_field);
    $cc++;
    	 
		$res_info[$cc]["name"] = $my_char->name;
		$res_info[$cc]["race"] = $my_char->race;
		$res_info[$cc]["class"] = $my_char->class;
		$res_info[$cc]["gender"] = $my_char->gender;
		$res_info[$cc]["level"] = $my_char->level;
		$res_info[$cc]["pos"] = get_zone_name($my_char->map, $my_char->position_x, $my_char->position_y);
		$res_info[$cc]["online"] =  ($my_char->online==0) ? "downarrow2.gif" : "uparrow2.gif"; 
		$res_info[$cc]["played_week"] = $result['played_week'];
		$res_info[$cc]["wons_week"] = $result['wons_week'];
		$res_info[$cc]["played_season"] = $result['played_season'];
		$res_info[$cc]["wons_season"] = $result['wons_season'];
		$res_info[$cc]["points_to_add"] = $result['arena_pending_points'];
		$res_info[$cc]["MemberRaiting"] = $result['personal_rating'];
		$res_info[$cc]["AT_GetPoints"] = AT_GetPoints($t_type, $t_rating, $res_info[$cc]["MemberRaiting"], $t_games, $res_info[$cc]["played_week"]);
		$char_data = explode(' ',$result['data']);
    $res_info[$cc]["AT_MiscInfo"] = 'AT_ID:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_TID].'; '.
			 																 'AT_PTYPE:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PTYPE].'; '.
																			 'AT_PTW:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PTW].'; '.
																			 'AT_PTS:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PTS].'; '.
																			 'AT_UNK:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_UNK].'; '.
																			 'AT_PAR:'.$char_data[$mangos_field['PLAYER_FIELD_ARENA_TEAM_INFO_1_1']+$t_slot*6+$AT_PAR].'; '.
																			 'AT_GetPoints:'.$res_info[$cc]["AT_GetPoints"];
																			 
	}
  unset($CHDB, $query, $result, $my_char);
}
?>
