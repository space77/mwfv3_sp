<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['realms_status'],'link'=>'');
// ==================== //
//error_reporting(E_ERROR);

$items = array();
$items = $DB->select("SELECT * FROM `realmlist` ORDER BY `name`");
$i = 0;
foreach($items as $i => $result)
{
    $population=0;
    if($res_color==1)$res_color=2;else$res_color=1;
    $realm_type = $realm_type_def[$result['icon']];
    if(check_port_status($result['address'], $result['port'])===true)
    {
        if(!$result['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$result['id']);
        $wsdb_info = parse_worlddb_info($result['CharacterDatabaseInfo']);
        $WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
        if($WSDB)$WSDB->setErrorHandler('databaseErrorHandler');
        if($WSDB)$WSDB->query("SET NAMES ".$config['db_encoding']);
        $res_img = 'images/uparrow2.gif';
        if($WSDB)$population = $WSDB->selectCell("SELECT count(*) FROM `characters` WHERE online=1");
        $population_str = population_view($population);
		
				if(!$result['WorldDatabaseInfo'])output_message('alert','Check field <u>WorldDatabaseInfo</u> in table `realmlist` for realm id='.$result['id']);
		    $wsdb_info = parse_worlddb_info($result['WorldDatabaseInfo']);
        $WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
        if($WSDB)$WSDB->setErrorHandler('databaseErrorHandler');
        if($WSDB)$WSDB->query("SET NAMES ".$config['db_encoding']);
		    if($DB)$uptimerow = $DB->selectRow("SELECT `starttime`, `startstring`, `maxplayers`, `uptime` FROM `uptime` WHERE `realmid`=".$result['id']." ORDER BY `starttime` DESC   LIMIT 0,1");
		    
        $uptime=$uptimerow['starttime'];
		    $maxplayers=$uptimerow['maxplayers'];
		    if($maxplayers < $population)$maxplayers=$population;
        $maxplayers_str = population_view($maxplayers);
    }
    else
    {
        $res_img = 'images/downarrow2.gif';
        $population_str = 'n/a';
        $uptime=time(now);
        $maxplayers = 0;
        $maxplayers_str = 'n/a'; 
    }
		
		
    $uptime = parse_uptime($uptime);
	  $uptime2 = $uptime[0]." ".$lang['day'].", ".$uptime[1]." ".$lang['hour']." ".$uptime[2]." ".$lang['min']." ".$uptime[3]."".$lang['sec']."" ;
		
    $items[$i]['res_color'] = $res_color;
    $items[$i]['img'] = $res_img;
    $items[$i]['name'] = $result['name'];
    $items[$i]['type'] = $realm_type;
    $items[$i]['pop'][1] = $population_str;
    $items[$i]['pop'][2] = $population;
    $items[$i]['max'][1] = $maxplayers_str;
    $items[$i]['max'][2] = $maxplayers;
		$items[$i]['uptime'] = $uptime2;
		$items[$i]['link'] = "index.php?n=server&sub=playersonline&realm=".$result['id'];

    unset($WSDB);
}
?>
