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
  
	  
    if($WSDB)$query = $WSDB->select("SELECT name, race, class, data, position_x, position_y, position_z, map FROM `characters` ORDER BY `name` LIMIT $limit_start,$items_per_pages");
	
    foreach ($query as $result) {
        if($res_color==1)$res_color=2;else $res_color=1;
        $cc++;     
        $res_race = $site_defines['character_race'][$result['race']];
        $res_class = $site_defines['character_class'][$result['class']];
        //      $res_pos = "<b>x:</b>$result[position_x] <b>y:</b>$result[position_y] <b>z:</b>$result[position_z]";
        $res_pos=get_zone_name($result['map'], $result['position_x'], $result['position_y']);
        $char_data = explode(' ',$result['data']);


        $res_info[$cc]["number"] = $cc;
        $res_info[$cc]["res_color"] = $res_color;
        $res_info[$cc]["name"] = $result['name'];
        $res_info[$cc]["race"] = $result['race'];
        $res_info[$cc]["class"] = $result['class'];
        $res_info[$cc]["gender"] = ((int)($char_data[$mangos_field['UNIT_FIELD_BYTES_0']]) >> 16) & hexdec('FF');
        $res_info[$cc]["level"] = $char_data[$mangos_field['UNIT_FIELD_LEVEL']];
        $res_info[$cc]["pos"] = $res_pos;
        $res_info[$cc]["current_xp"]= $char_data[$mangos_field['PLAYER_XP']];
        $res_info[$cc]["next_level_xp"]= $char_data[$mangos_field['PLAYER_NEXT_LEVEL_XP']];
        $res_info[$cc]["xp_perc"] = ceil($res_info[$cc]["current_xp"]/$res_info[$cc]["next_level_xp"] * 100);
    }

/*    
// array´s
 $query1 = array();  
 $query2 = array();  
 $cc1 = 0;
 $cc2 = 0;

## output_message('alert',$filter);



	//===db connect 1===//
        if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
        $wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
        $WSDB1 = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
        if($WSDB1)$WSDB1->setErrorHandler('databaseErrorHandler');
        if($WSDB1)$WSDB1->query("SET NAMES ".$config['db_encoding']);  

     //===== Filter ==========// 
    if($_GET['char'] && preg_match("/[a-z]/",$_GET['char'])){
        $filter = "WHERE `name` LIKE '".$_GET['char']."%'";
    }elseif($_GET['char']==1){
        $filter = "WHERE `name` REGEXP '^[^A-Za-z]'";
    }else{
        $filter = '';
      }      
	

         $query1 =  $WSDB1->select("SELECT * FROM `characters`  $filter  ORDER BY `name`  LIMIT $limit_start,$items_per_pages");
         
  

 foreach ($query1 as $result1) {
        if($res_color==1)$res_color=2;else $res_color=1;
        $cc1++;   
        $res_race = $site_defines['character_race'][$result1['race']];
        $res_class = $site_defines['character_class'][$result1['class']];
        //      $res_pos = "<b>x:</b>$result1[position_x] <b>y:</b>$result1[position_y] <b>z:</b>$result1[position_z]";
        $res_pos=get_zone_name($result1['map'], $result1['position_x'], $result1['position_y']);
        $char_data = explode(' ',$result1['data']);

        $char_gender = dechex($char_data[$mangos_field['UNIT_FIELD_BYTES_0']]);
        $char_gender = str_pad($char_gender,8, 0, STR_PAD_LEFT);
        $char_gender = $char_gender{3};
        $item_res[$cc1]["number"] = $cc1;
        $item_res[$cc1]["name"] = $result1['name'];
        $item_res[$cc1]["res_color"] = $res_color;
        $item_res[$cc1]["race"] = $result1['race'];
        $item_res[$cc1]["class"] = $result1['class'];
        $item_res[$cc1]["gender"] = $char_gender;
        $item_res[$cc1]["level"] = $char_data[$mangos_field['UNIT_FIELD_LEVEL']];
        $item_res[$cc1]["pos"] = $res_pos;
        $item_res[$cc1]["current_xp"]= $char_data[$mangos_field['PLAYER_XP']];
        $item_res[$cc1]["next_level_xp"]= $char_data[$mangos_field['PLAYER_NEXT_LEVEL_XP']];
        $item_res[$cc1]["xp_perc"] = ceil($item_res[$cc1]["current_xp"]/$item_res[$cc1]["next_level_xp"] * 100);
    }

        

	//===db conenct2===//

        if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
        $wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
        $WSDB2 = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
        if($WSDB2)$WSDB2->setErrorHandler('databaseErrorHandler');
        if($WSDB2)$WSDB2->query("SET NAMES ".$config['db_encoding']);  

         
$query2 =  $WSDB2->select("SELECT * FROM `characters`  $filter  ORDER BY `name`  ");

 foreach ($query2 as $result2) {
        $cc2++;   
        $item_res1[$cc2]["number"] = $cc2;

    }
	//===== Calc pages2 =====//
	$pnum = ceil($cc2/$items_per_pages); 
	$pages_str = default_paginate($pnum, $p, "index.php?n=server&sub=chars&realm=".$_GET['realm']."&char=".$_GET['char']);

##  output_message('alert',$pages_str);

	unset($WSDB1); 
	unset($WSDB2);
	*/
}
?>




