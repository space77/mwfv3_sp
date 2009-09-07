<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['banaction'],'link'=>'index.php?n=server&sub=banaction');
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
  }
  if(!$realm_info['CharacterDatabaseInfo']){
    output_message('alert','Не заполнено поле <u>CharacterDatabaseInfo</u> в таблице `realmlist` для реалма id='.$realm_info['id']);
  }
  $address = $realm_info['address'];
  $raport = $realm_info['raport'];
  $error = false;
  
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
      $reason ='You guilty';
      $bantime ='30d';
      
      if ($result) {
        $resultmsg = $_POST['resultmsg'];
        $mypass = $_POST['mypass'];
        $action = $_POST['action'];
        $type = $_POST['type'];
        $typeval = $_POST['typeval'];
        $reason = $_POST['reason'];
        $bantime = $_POST['bantime'];
      } else {
        $action = $_GET['action'];
        $type = $_GET['type'];
        $typeval = $_GET['typeval'];
      }
      
      if ($result=='OK') {
        
        
        output_message('notice','OK! </br>'.$resultmsg); //.'</br>'.'<meta http-equiv=refresh content="2;url='.$rurl.'">');
      } elseif ($result=='Error') {
        output_message('alert','Error: <br />'.$resultmsg); //.'</br>'.'<meta http-equiv=refresh content="2;url='.$rurl.'">');
      }
    }
  }
}
}
?>
