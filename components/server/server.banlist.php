<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
// ==================== //
$pathway_info[] = array('title'=>$lang['banlist'],'link'=>'');
// ==================== //


    $query = $DB->select("SELECT account_banned.*, `account`.`username` FROM 
                                	`account_banned`
                                	 , `account` 	
                                WHERE ((`account_banned`.`id` = `account`.`id`) AND (active=1))
                                ORDER BY `bandate` DESC, `username` ASC;");

    $cc=0;
    foreach ($query as $result) {
        if($res_color==1)$res_color=2;else$res_color=1;
        $cc++;     
	 	
        $res_info[$cc]["number"] = $cc;
        $res_info[$cc]["res_color"] = $res_color;
		    
        $res_info[$cc]["id"] = $result['id'];
        $res_info[$cc]["username"] = $result['username'];
		    $res_info[$cc]["bandate"] = date('Y-m-d H:i:s', $result['bandate']);
        if ($result['bandate']==$result['unbandate']){
		      $res_info[$cc]["unbandate"] = $lang['b_permanent'];
		    } else {
          $res_info[$cc]["unbandate"] = date('Y-m-d H:i:s', $result['unbandate']);
        }
        $res_info[$cc]["bannedby"] = $result['bannedby'];
		    $res_info[$cc]["banreason"] = $result['banreason'];
    }
    
    $query = $DB->select("SELECT * FROM `ip_banned`
                          ORDER BY `bandate` DESC, `ip` ASC;");

    $cc=0;
    foreach ($query as $result) {
        if($res_color==1)$res_color=2;else$res_color=1;
        $cc++;     
	 	
        $res_info_ip[$cc]["number"] = $cc;
        $res_info_ip[$cc]["res_color"] = $res_color;
		    
        $res_info_ip[$cc]["ip"] = $result['ip'];
		    $res_info_ip[$cc]["bandate"] = date('Y-m-d H:i:s', $result['bandate']);
		    if ($result['bandate']==$result['unbandate']){
		      $res_info_ip[$cc]["unbandate"] = $lang['b_permanent'];
		    } else {
          $res_info_ip[$cc]["unbandate"] = date('Y-m-d H:i:s', $result['unbandate']);
        }
        $res_info_ip[$cc]["bannedby"] = $result['bannedby'];
		    $res_info_ip[$cc]["banreason"] = $result['banreason'];
    }
?>
