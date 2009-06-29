<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';

// ==================== //
$pathway_info[] = array('title'=>$lang['honor'],'link'=>'index.php?n=server&sub=honor');
// ==================== //
// some config //
$max_display_chars = 40; // Only top 40 in stats

if(!$_GET['realm']){
    $realm_list = realm_list();
    $count = count($realm_list);
    if ($count==1){
      $id=$DB->selectCell("SELECT `id` FROM `realmlist` ORDER BY `name`");
      $_GET['realm'] = $id;
    }
}

if($_GET['realm']){
    $pos = 0;
    $realm_list = realm_list();
    $realm = $DB->selectRow("SELECT * FROM realmlist WHERE id=?d LIMIT 1",$_GET['realm']);    
    $pathway_info[] = array('title'=>$realm['name'],'');
    
		if ($realm_info['Version']!==''){
			require_once 'core/cache/'.$realm_info['Version'].'/UpdateFields.php';		
		} else {
			require_once 'core/cache/UpdateFields.php';	
		}
		
		if(!$realm['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm['id']);
    $wsdb_info = parse_worlddb_info($realm['CharacterDatabaseInfo']);
    $WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
    if($WSDB)$WSDB->setErrorHandler('databaseErrorHandler');
    if($WSDB)$WSDB->query("SET NAMES ".$config['db_encoding']);
    
   //if($WSDB)$honor = $WSDB->select("SELECT guid, CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 1421), ' ', -1) AS UNSIGNED) AS honor FROM `character`;");
   	
   	$qstr ="SELECT `guid`
					, CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".$mangos_field['PLAYER_FIELD_LIFETIME_HONORBALE_KILLS']."+1), ' ', -1) AS UNSIGNED) AS `honor` 
					, `gmlevel` 
					FROM `characters`, `".$config['db_name']."`.`account`
					WHERE ((`characters`.`account`=`".$config['db_name']."`.`account`.`id` ) AND (`gmlevel`=0));";

   	if($WSDB)$honor = $WSDB->select($qstr);
    foreach($honor as $res_row)
    {
        if($res_row['type']==0){
            $honor_arr[$res_row['guid']] += $res_row['honor'];
        }elseif($res_row['type']==2){
            $honor_arr[$res_row['guid']] -= $res_row['honor'];
        }
    }
    unset($honor);
    if(!is_array($honor_arr))$honor_arr = array();
    $honor_arr = array_filter($honor_arr,"zehohonorfilter");
    arsort($honor_arr);
    $honor_arr = array_slice($honor_arr,0,$max_display_chars,true);
    $allhonor['alliance'] = array();
    $allhonor['horde'] = array();
    $charinfo_arr = array();
    $precharinfo_arr = array();
    if(count($honor_arr)>0)$precharinfo_arr = $WSDB->select("SELECT characters.guid AS ARRAY_KEY,characters.guid,characters.data,characters.name,characters.race,characters.class FROM `characters` WHERE guid IN(?a)",array_keys($honor_arr));
    foreach ($honor_arr as $honor_uid=>$honor_val){
        $charinfo_arr[$honor_uid] = $precharinfo_arr[$honor_uid];
    }
    unset($precharinfo_arr);
    // Prepair data ...
    foreach($charinfo_arr as $charinfo_item){
        $char_data = explode(' ',$charinfo_item['data']);


        $char_rank_id = calc_character_rank($honor_arr[$charinfo_item['guid']]);
        if($charinfo_item['race']==1 || $charinfo_item['race']==3 || $charinfo_item['race']==4 || $charinfo_item['race']==7 || $charinfo_item['race']==11)$faction = 'alliance';
				else $faction = 'horde';
        $character = array(
            'name'   => $charinfo_item['name'],
            'race'   => $site_defines['character_race'][$charinfo_item['race']],
            'class'  => $site_defines['character_class'][$charinfo_item['class']],
            'gender' => $site_defines['character_gender'][((int)($char_data[$mangos_field['UNIT_FIELD_BYTES_0']]) >> 16) & hexdec('FF')],
            'rank'   => $site_defines['character_rank'][$faction][$char_rank_id],
            'level'  => $char_data[$mangos_field['UNIT_FIELD_LEVEL']],
            'honor_points'       => $honor_arr[$charinfo_item['guid']],
           	'honorable_kills'    => $char_data[$mangos_field['PLAYER_FIELD_LIFETIME_HONORBALE_KILLS']],
            'dishonorable_kills' => $char_data[$mangos_field['PLAYER_FIELD_KILLS']],
            'race_icon'   => $config['template_href'].'images/icon/race/'.$charinfo_item['race'].'-'.$char_gender.'.gif',
            'class_icon'   => $config['template_href'].'images/icon/class/'.$charinfo_item['class'].'.gif',
            'rank_icon'   => $config['template_href'].'images/icon/pvpranks/rank'.$char_rank_id.'.gif',
        );
        $allhonor[$faction][] = $character;
    }    
    
    unset($honor_arr);
    unset($charinfo_arr);
    unset($WSDB);
    
}
function get_rank_numending($n)
{
  $n = substr("$n", -1);
  if($n==1)return 'st';
  elseif($n==2)return 'nd';
  elseif($n==3)return 'rd';
  elseif($n>=4)return 'th';
}
function calc_character_rank($honor_points){
    $rank = 0;
    if($honor_points <= 0){
        $rank = 0; 
    }else{
        if($honor_points < 2000) $rank = 1;
        else $rank = ceil($honor_points / 5000) + 1;
    }
    return $rank;
}
function zehohonorfilter($var){
    return ($var>0);
}
?>
