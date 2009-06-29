<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';
require_once 'core/cache/UpdateFields.php';
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

  $res_info = array();
  $query = array();
  $realm_info = get_realm_byid($_GET['realm']);
  $pathway_info[] = array('title'=>$realm_info['name'],'');
  $cc = 0;
  
  	if ($realm_info['Version']!==''){
			require_once 'core/cache/'.$realm_info['Version'].'/UpdateFields.php';		
		} else {
			require_once 'core/cache/UpdateFields.php';	
		}
		
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
        $res_race = $site_defines['character_race'][$result['race']];
        $res_class = $site_defines['character_class'][$result['class']];
        $res_pos=get_zone_name($result['map'], $result['position_x'], $result['position_y']);
        $char_data = explode(' ',$result['data']);        
        $char_faction =get_faction($result['race']);
  
        $res_info[$cc]["number"] = $cc;
        $res_info[$cc]["res_color"] = $res_color;
        $res_info[$cc]["name"] = $result['name'];
        $res_info[$cc]["race"] = $result['race'];
        $res_info[$cc]["class"] = $result['class'];
        $res_info[$cc]["gender"] =((int)$result['gender']);   // ((int)($char_data[$mangos_field['UNIT_FIELD_BYTES_0']]) >> 16) & hexdec('FF');
        $res_info[$cc]["level"] = ((int)$result['level']);    //$char_data[$mangos_field['UNIT_FIELD_LEVEL']];
        $res_info[$cc]["pos"] = $res_pos;
        $res_info[$cc]["faction"] =$char_faction;
        $res_info[$cc]["gmlevel"] =get_gmlevelstr($result['gmlevel']);
        $res_info[$cc]["addinfo"] = "Имя персонажа {guid}: ".$result['name']." {".$result['guid']."} ;"."\\n".
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
