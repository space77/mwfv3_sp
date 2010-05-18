<?php
if(INCLUDED!==true)exit;
require_once 'core/defines.php';
// ==================== //
$oldInactiveTime = 3600*24*7;
// ==================== //
if($_GET['id'] > 0){
    if(!$_GET['action']){
        $profile = $auth->getprofile($_GET['id']);
        $allgroups = $DB->selectCol("SELECT g_id AS ARRAY_KEY, g_title FROM account_groups");
        
        //$pathway_info[] = array('title'=>$lang['users_manage'],'link'=>$com_links['sub_members']);
        $pathway_info[] = array('title'=>$lang['users_manage'],'link'=>'index.php?n=admin&sub=members');
        $pathway_info[] = array('title'=>$profile['username'],'link'=>'');
            
        $txt['yearlist'] = "\n";
            $txt['monthlist'] = "\n";
            $txt['daylist'] = "\n";
            for($i=1;$i<=31;$i++){
                $txt['daylist'] .= "<option value='$i'".($i==$profile['bd_day']?' selected':'')."> $i </option>\n";
            }
            for($i=1;$i<=12;$i++){
                $txt['monthlist'] .= "<option value='$i'".($i==$profile['bd_month']?' selected':'')."> $i </option>\n";
            }
            for($i=1950;$i<=date('Y');$i++){
                $txt['yearlist'] .= "<option value='$i'".($i==$profile['bd_year']?' selected':'')."> $i </option>\n";
            }
            $profile['signature'] = str_replace('<br />','',$profile['signature']);
            //print_r($profile);exit;
    }elseif($_GET['action']=='changepass'){
		  $profile = $auth->getprofile($_GET['id']);
		  $newpass = strtoupper(trim($_POST['new_pass']));
		  $newI = strtoupper(sha1(strtoupper(trim($profile['username'])).":".strtoupper(trim($newpass))));
		  $currI = strtoupper($DB->selectCell("SELECT `sha_pass_hash` FROM account WHERE `id`=?d LIMIT 1",$_GET['id']));

		  if((strlen($newpass)>=4) && (strlen($newpass)<=16)){
          if($DB->query("UPDATE `account` SET `sha_pass_hash`=?, v='0', s='0' WHERE `id`=?d LIMIT 1",$newI,$_GET['id'])){
            $currI = $DB->selectCell("SELECT `sha_pass_hash` FROM `account` WHERE `id`=?d LIMIT 1",$_GET['id']);
            output_message('notice','<b>'.$lang['change_pass_succ'].'</b><meta http-equiv=refresh content="2;url=index.php?n=admin&sub=members&id='.$_GET['id'].'">');
          } else{
          	if ($newI!==$currI){
          		output_message('alert','<b>'.'Error change password.'.'</b><meta http-equiv=refresh content="2;url=index.php?n=admin&sub=members&id='.$_GET['id'].'">');
          	} else{
          		output_message('notice','<b>'.$lang['change_pass_equal'].'</b><meta http-equiv=refresh content="2;url=index.php?n=admin&sub=members&id='.$_GET['id'].'">');
          	}
          }
			}else{
           	output_message('alert','<b>'.sprintf($lang['reg_checkpass'],$regparams['MIN_PASS_L'],$regparams['MAX_PASS_L']).'</b><meta http-equiv=refresh content="2;url=index.php?n=admin&sub=members&id='.$_GET['id'].'">');
			}

    }elseif($_GET['action']=='ban'){
  		$reason = $_POST['reason'];
  		$admin_name = $cookie['username'];
      $DB->query("INSERT INTO account_banned VALUES (?d, ?, UNIX_TIMESTAMP(?), ?, ?, '1')", $_GET['id'], time(), $_POST['ban_date'], $user['username'], $reason);
  		redirect('index.php?n=admin&sub=members&id='.$_GET['id'],1);
    }elseif($_GET['action']=='unban'){
        $DB->query("UPDATE `account_banned` SET `active` = '0' WHERE `id` = ?d",$_GET['id']);
        redirect('index.php?n=admin&sub=members&id='.$_GET['id'],1);
    }elseif($_GET['action']=='change'){
        $_POST['profile']['username'] = strtoupper(trim($_POST['profile']['username']));
        $DB->query("UPDATE account SET ?a WHERE id=?d LIMIT 1",$_POST['profile'],$_GET['id']);
        redirect('index.php?n=admin&sub=members&id='.$_GET['id'],1);
    }elseif($_GET['action']=='change2'){
        if(is_uploaded_file($_FILES['avatar']['tmp_name'])){
          if($_FILES['avatar']['size'] <= $config['max_avatar_file']){
            $tmp_filenameadd = time();
            if(@move_uploaded_file($_FILES['avatar']['tmp_name'], $config['avatar_path'].$tmp_filenameadd.$_FILES['avatar']['name'])){
              list($width, $height, ,) = getimagesize($config['avatar_path'].$tmp_filenameadd.$_FILES['avatar']['name']);
              $path_parts = pathinfo($config['avatar_path'].$tmp_filenameadd.$_FILES['avatar']['name']);
              $max_avatar_size = explode('x',$config['max_avatar_size']);
              if($width <= $max_avatar_size[0] || $height <= $max_avatar_size[1]){
                if(@rename($config['avatar_path'].$tmp_filenameadd.$_FILES['avatar']['name'], $config['avatar_path'].$_GET['id'].'.'.$path_parts['extension'])){
                  $upl_avatar_name = $_GET['id'].'.'.$path_parts['extension'];
                }else{
                  $upl_avatar_name = $tmp_filenameadd.$_FILES['avatar']['name'];
                }
                if($upl_avatar_name)$DB->query("UPDATE account_extend SET avatar='".$upl_avatar_name."' WHERE account_id=?d LIMIT 1",$_GET['id']);
              }else{
                @unlink($config['avatar_path'].$tmp_filenameadd.$_FILES['avatar']['name']);
              }
            }
          }
        }elseif($_POST['deleteavatar']==1){
          $filename = $config['avatar_path'].$_POST['avatarfile'];
          if (file_exists($filename)) {
            if(@unlink($config['avatar_path'].$_POST['avatarfile'])){
              $DB->query("UPDATE account_extend SET avatar=NULL WHERE account_id=?d LIMIT 1",$_GET['id']);
            }
          } else {
            $DB->query("UPDATE account_extend SET avatar=NULL WHERE account_id=?d LIMIT 1",$_GET['id']);
          }
        }
        $_POST['profile']['signature'] = htmlspecialchars($_POST['profile']['signature']);
        $DB->query("UPDATE account_extend SET ?a WHERE account_id=?d LIMIT 1",$_POST['profile'],$_GET['id']);
        redirect('index.php?n=admin&sub=members&id='.$_GET['id'],1);
    }elseif($_GET['action']=='dodeleteacc'){
        $DB->query("DELETE FROM account WHERE id=?d LIMIT 1",$_GET['id']);
        $DB->query("DELETE FROM account_extend WHERE account_id=?d LIMIT 1",$_GET['id']);
        $DB->query("DELETE FROM pms WHERE owner_id=?d LIMIT 1",$_GET['id']);
    redirect('index.php?n=admin&sub=members',1);
    }
}else{
    if($_GET['action']=='deleteinactive'){
        $cur_timestamp = date('YmdHis',time()-$oldInactiveTime);
        $accids = $DB->selectCol("
            SELECT account_id FROM account_extend 
            JOIN account ON account.id=account_extend.account_id 
            WHERE activation_code IS NOT NULL AND joindate < ?
        ",$cur_timestamp);
       // print_r($accids);
        $DB->query("DELETE FROM account WHERE id IN(?a)",$accids);
        $DB->query("DELETE FROM account_extend WHERE account_id IN(?a)",$accids);
        redirect('index.php?n=admin&sub=members',1);
    }
    $pathway_info[] = array('title'=>$lang['users_manage'],'link'=>'');
    //===== Filter ==========//
    if($_GET['char'] && preg_match("/[a-z]/",$_GET['char'])){
        $filter = "WHERE `username` LIKE '".$_GET['char']."%'";
    }elseif($_GET['char']==1){
        $filter = "WHERE `username` REGEXP '^[^A-Za-z]'";
    }else{
        $filter = '';
    }
    //===== Calc pages =====//
    $items_per_pages = $config['users_per_page'];
    $itemnum = $DB->selectCell("SELECT count(*) FROM account $filter");
    $pnum = ceil($itemnum/$items_per_pages);
    $pages_str = default_paginate($pnum, $p, "index.php?n=admin&sub=members&char=".$_GET['char']);
    $limit_start = ($p-1)*$items_per_pages;
    
    $items = $DB->select("
        SELECT `account`.`id`,`username`,`email`,`homepage`,`icq`,`joindate`,`locked`,COALESCE(`active`,0) as `active` FROM account 
        LEFT JOIN account_extend ON account.id=account_extend.account_id 
		    LEFT JOIN account_banned ON (account_banned.id=account.id AND account_banned.active=1)
        $filter 
        ORDER BY username 
        LIMIT $limit_start,$items_per_pages");
}
?>
