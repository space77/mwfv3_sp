<?php 
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';

// ==================== //
$pathway_info[] = array('title'=>$lang['banaction'],'link'=>'index.php?n=admin&sub=banaction');
// ==================== //

if ($user['gmlevel']==0) {
  output_message('alert','<b>'.'Вам запрещено данное действие.'.'</b><meta http-equiv=refresh content="2;url=index.php">');
} else {

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
 
  if(!$realm_info['raport']){
    output_message('alert','Не указан <u>RAPort</u> в таблице `realmlist` для реалма id='.$realm_info['id']);
  } elseif(!$realm_info['CharacterDatabaseInfo']){
    output_message('alert','Не заполнено поле <u>CharacterDatabaseInfo</u> в таблице `realmlist` для реалма id='.$realm_info['id']);
  } else {
  
    $CHDB_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
    $CHDB = DbSimple_Generic::connect("".$config['db_type']."://".$CHDB_info['user'].":".$CHDB_info['password']."@".$CHDB_info['host'].":".$CHDB_info['port']."/".$CHDB_info['db']."");
    if($CHDB)$CHDB->setErrorHandler('databaseErrorHandler');
    if($CHDB)$CHDB->query("SET NAMES ".$config['db_encoding']);
    
    $error = false;
    $reason ='You guilty';
    $bantime ='30d';
    $address = $realm_info['address'];
    $raport = $realm_info['raport'];
    
    if(check_port_status($realm_info['address'], $realm_info['port'])!==true) {
      // если сервер остановлен
      
    } else {
      if(check_port_status($address, $raport)!==true) {
          output_message('alert',' Реалм <b>'.$realm_info['name'].'</b> выключен либо не возможно соединится на порт RA <img src="images/downarrow2.gif" border="0" align="top">');
          $error = true;
      } else {

        $result = $_POST['result'];
        $myuser = $user['username'];
        $rurl = str_replace("&", "_and_", $_SERVER["REQUEST_URI"]);
        
        if ($result) {
          $resultmsg = $_POST['resultmsg'];
          $mypass = $_POST['mypass'];
          $action = $_POST['action'];
          $type = $_POST['type'];
          $typeval = $_POST['typeval'];
          $reason = $_POST['reason'];
          $bantime = $_POST['bantime'];
          
          //Logs
          $timecurr = time();
				  $timecurrf=date('Y-m-d H:i:s', $timecurr);
          if ($DB)$DB->query("INSERT INTO `mwfe3_ban_actions`
                              (`id`,`name`, `ip`, `timeaction`,`action`,`type`,`typeval`,`result`,`resultmsg`) 
                              values 
                              ( ?,?,?,?,?,?,?,?,?);"
                              ,$user['id'], $user['username'],$_SERVER['REMOTE_ADDR'],$timecurrf,$action,$type,$typeval,$result,$resultmsg);
          
          
        } else {
          $action = $_GET['action'];
          $type = $_GET['type'];
          $typeval = $_GET['typeval'];
        }
        
        if ($result=='OK') {
          
          if ($type=='ip') {
            if ($action=='ban'){
              if ($DB)$DB->query("UPDATE `ip_banned` SET `bannedby`=?, `banreason`=? WHERE `ip`=?",$user['username'],$reason,$typeval);
            } elseif ($action=='unban'){
              if ($DB)$DB->query("DELETE FROM `ip_banned` WHERE `ip`=?", $typeval);
            }
          } elseif ($type=='account') { 
            if ($action=='ban'){
              if ($DB)$DB->query("UPDATE `account_banned` SET `bannedby`=?, `banreason`=?
                                  WHERE `id` IN (SELECT `id` FROM `account` WHERE `username`=?) AND `active`=1",$user['username'],$reason,$typeval);
            } elseif ($action=='unban'){
              if ($DB)$DB->query("UPDATE `account_banned` SET `active`=0 
                                  WHERE `id` IN (SELECT `id` FROM `account` WHERE `username`=?)", $typeval);
            }
          } elseif ($type=='character') {
            if($CHDB)$accid=$CHDB->selectcell("SELECT `account` FROM `characters` WHERE `name`=?", $typeval);
            if($accid)
              if ($action=='ban'){
                if ($DB)$DB->query("UPDATE `account_banned` SET `bannedby`=?, `banreason`=?
                                    WHERE `id`=? AND `active`=1",$user['username'],$reason,$accid);
              } elseif ($action=='unban'){
                if ($DB)$DB->query("UPDATE `account_banned` SET `active`=0 
                                    WHERE `id`=?", $accid);
              }  
          }
          
          
          
          output_message('notice','OK! </br>'.$resultmsg); //.'</br>'.'<meta http-equiv=refresh content="2;url='.$rurl.'">');
        } elseif ($result=='Error') {
          output_message('alert','Error: <br />'.$resultmsg); //.'</br>'.'<meta http-equiv=refresh content="2;url='.$rurl.'">');
        }
      }
    }
  }
}
}
?>
