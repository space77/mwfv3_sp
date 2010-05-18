<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['realms_status'],'link'=>'');
// ==================== //
//error_reporting(E_ERROR);

$ids = $DB->select("SELECT id FROM `realmlist` ORDER BY `name`");
foreach($ids as $i => $result)
{
  $realm_info = get_realm_byid($result['id']);
  $rid = (($realm_info['cloneid']== -1) ? $realm_info['id'] : $realm_info['cloneid']);
  $rrealm_info = get_realm_byid($rid); 
  if(check_port_status($rrealm_info['address'], $rrealm_info['port'])===true) {
//    $rid = (($realm_info['cloneid']== -1) ? $realm_info['id'] : $realm_info['cloneid']);  
  
    if($DB)$uptimerow = $DB->selectRow("SELECT * FROM `uptime` WHERE `realmid`=".$rid." ORDER BY `starttime` DESC   LIMIT 0,1");   
    if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
    $CHDB_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
    $CHDB = DbSimple_Generic::connect("".$config['db_type']."://".$CHDB_info['user'].":".$CHDB_info['password']."@".$CHDB_info['host'].":".$CHDB_info['port']."/".$CHDB_info['db']."");
    if($CHDB)$CHDB->setErrorHandler('databaseErrorHandler');
    if($CHDB)$CHDB->query("SET NAMES ".$config['db_encoding']);    
    if($CHDB)$population = $CHDB->selectCell("SELECT count(*) FROM `characters` WHERE online=1");
      
    $res_img = 'images/uparrow2.gif';
    $uptime=$uptimerow['starttime'];
		$maxplayers=$uptimerow['maxplayers'];
    $maxplayers_str = population_view($maxplayers);
    $population_str = population_view($population);
  } else {
    $res_img = 'images/downarrow2.gif';
    $uptime=time(now);
    $maxplayers = 0;
    $maxplayers_str = 'n/a';
    $population = 0;
    $population_str = 'n/a';
  }
		
  $uptime = parse_uptime($uptime);
	$uptime_str = $uptime[0]." ".$lang['day'].", ".$uptime[1]." ".$lang['hour']." ".$uptime[2]." ".$lang['min']." ".$uptime[3]."".$lang['sec']."" ;
	
  $cc++;	
  $items[$cc]['img'] = $res_img;
  $items[$cc]['name'] = $realm_info['name'];
  $items[$cc]['type'] = $realm_type_def[$realm_info['icon']];
  $items[$cc]['pop'][1] = $population_str;
  $items[$cc]['pop'][2] = $population;
  $items[$cc]['max'][1] = $maxplayers_str;
  $items[$cc]['max'][2] = $maxplayers;
	$items[$cc]['uptime'] = $uptime_str;
	$items[$cc]['link'] = "index.php?n=server&sub=playersonline&realm=".$result['id'];
 
}
unset($ids, $CHDB);
 ?>
