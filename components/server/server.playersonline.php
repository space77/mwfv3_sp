<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['players_online'],'link'=>'index.php?n=server&sub=playersonline');
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
  $realm_info = get_realm_byid($_GET['realm']);
  $pathway_info[] = array('title'=>$realm_info['name'],'');
  $cc = 0;
  
  AddMangosFields ($realm_info['Version']);
	$charinfo_link = $realm_info['WowdCharInfoLink'];
  
  $faction_alliance = 0;
  $faction_horde = 0;
  $total = 0;
    
    if(check_port_status($realm_info['address'], $realm_info['port'])!==true) {
        output_message('alert','Realm <b>'.$realm_info['name'].'</b> is offline <img src="images/downarrow2.gif" border="0" align="top">');
    } else {
    
        if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
        $wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
        
        if($DB)$query = $DB->select("SELECT c.*, a.*   FROM ".$wsdb_info['db'].".`characters` as c, `account` as a 
																					WHERE ((c.`online`='1') AND (c.`account`=a.`id`)) 
																					ORDER BY c.`name`");
        
    $faction_alliance = 0;
    $faction_horde = 0;
    $total = 0;
    
    foreach ($query as $result) {
        if($res_color==1)$res_color=2;else$res_color=1;
        $cc++; 
        
        $my_char = new character($result, $mangos_field);
            
        $res_race = $site_defines['character_race'][$my_char->race];
        $res_class = $site_defines['character_class'][$my_char->class];
        $res_pos=get_zone_name($my_char->map, $my_char->position_x, $my_char->position_y);
       
        $char_faction =get_faction($result['race']);
  
        $res_info[$cc]["number"] = $cc;
        $res_info[$cc]["res_color"] = $res_color;
        $res_info[$cc]["name"]    = $my_char->name;
        $res_info[$cc]["race"]    = $my_char->race;
        $res_info[$cc]["class"]   = $my_char->class;
        $res_info[$cc]["gender"]  = $my_char->gender;
        $res_info[$cc]["level"]   = $my_char->level;
        $res_info[$cc]["pos"] = $res_pos;
        $res_info[$cc]["faction"] =$char_faction;
        $res_info[$cc]["char_link"]=($charinfo_link=="") ? "#" : $charinfo_link.$my_char->guid;
        $res_info[$cc]["gmlevel"] =get_gmlevelstr($result['gmlevel']);
        $res_info[$cc]["addinfo"] = "Имя персонажа {guid}: ".$my_char->name." {".$my_char->guid."} ;"."\\n".
        														"Имя аккаунта: {id}: ".$result['username']." {".$result['id']."} ;"."\\n".
        														"IP компьютера: ".$result['last_ip'];
        
        if ($char_faction=="Alliance"){
          $faction_alliance++;  
        } elseif ($char_faction=="Horde"){
          $faction_horde++; 
        }
        $total++;
    }
    unset($WSDB);
    }
}

?>
