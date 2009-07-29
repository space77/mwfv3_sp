<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';
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
    $realm_info = get_realm_byid($_GET['realm']);
    $pathway_info[] = array('title'=>$realm_info['name'],'');
    
    if(!$realm_info['CharacterDatabaseInfo'])output_message('alert','Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id']);
    $CHDB_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
    
    $CHDB = DbSimple_Generic::connect("".$config['db_type']."://".$CHDB_info['user'].":".$CHDB_info['password']."@".$CHDB_info['host'].":".$CHDB_info['port']."/".$CHDB_info['db']."");
    if($CHDB)$CHDB->setErrorHandler('databaseErrorHandler');
    if($CHDB)$CHDB->query("SET NAMES ".$config['db_encoding']);
    
    AddMangosFields ($realm_info['Version']);
      	
   	$qstr= "SELECT guid FROM
              (SELECT c.guid
   	                  , CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(c.`data`, ' ', ".($mangos_field['PLAYER_FIELD_HONOR_CURRENCY']+1)."), ' ', -1) AS UNSIGNED) AS honor
					     FROM `characters` AS c, `".$config['db_name']."`.`account` as a
					     WHERE ((c.`account`= a.`id`) AND (a.`gmlevel`=0) AND (c.`race` IN (?a)))) AS tbl
            WHERE honor > 0 ORDER BY honor DESC LIMIT ".$max_display_chars.";";
    
    $allhonor['alliance'] = array();
    $allhonor['horde'] = array();
    for ($i = 1; $i <= 2; $i++)
    {
      if ($i==1) {
        $faction='alliance';
        if ($CHDB)$guids=$CHDB->select($qstr, $site_defines['characrer_race_alliance']);
      } else {
        $faction='horde';
        if ($CHDB)$guids=$CHDB->select($qstr, $site_defines['characrer_race_horde']);
      }
      if (count($guids) > 0)$chars=$CHDB->select("SELECT * FROM `characters` WHERE `guid` IN (?a)", array_map("getguid", $guids));

      foreach($chars as $char){
        $my_char = new character($char, $mangos_field);
        $character = array(
            'name'   => $my_char->name,
            'race'   => $site_defines['character_race'][$my_char->race],
            'class'  => $site_defines['character_class'][$my_char->class],
            'gender' => $site_defines['character_gender'][$my_char->gender],
            'level'  => $my_char->level,
            'honor_points'       => $my_char->honor_points,
           	'honorable_kills'    => $my_char->honorable_kills,
            'race_icon'   =>  $config['template_href'].'images/icon/race/'.$my_char->race.'-'.$my_char->gender.'.gif',
            'class_icon'   => $config['template_href'].'images/icon/class/'.$my_char->class.'.gif',
        );
        $allhonor[$faction][] = $character;
        unset ($my_char);
      }
      unset($guids);
    }
    unset ($CHDB);
}

function getguid($val){
  return $val['guid'];
}
?>
