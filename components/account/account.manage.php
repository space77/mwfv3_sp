<?php
if(INCLUDED!==true)exit;
// ==================== //
require_once 'core/defines.php';
$pathway_info[] = array('title'=>$lang['accediting'],'link'=>'');
// ==================== //
if($user['id']<=0){
    redirect('index.php?n=account&sub=login',1);
}else{
    if(!$_GET['action']){
        $profile = $auth->getprofile($user['id']);
        $profile['signature'] = str_replace('<br />','',$profile['signature']);
    }elseif($_GET['action']=='changeemail'){
        $newemail = trim($_POST['new_email']);
        if($auth->isvalidemail($newemail)){
            if($auth->isavailableemail($newemail)){
                if($DB->query("UPDATE account SET email=? WHERE id=?d LIMIT 1",$newemail,$user['id'])===true){
                    output_message('notice','<b>'.$lang['change_mail'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
                }
            }else{
                output_message('alert','<b>'.$lang['reg_checkemailex'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
            }
        }else{
            output_message('alert','<b>'.$lang['bad_mail'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
        }
    }elseif($_GET['action']=='changepass'){

			$profile = $auth->getprofile($user['id']);
			$newpass = strtoupper(trim($_POST['new_pass']));
			$newpassconfirm = strtoupper(trim($_POST['new_pass_confirm']));
			$bOK = true;
      if ($newpass!=$newpassconfirm){
			 $bOK = false;
      }
			$newI = sha1(strtoupper(trim($profile['username'])).":".strtoupper(trim($newpass)));
			$currI = $DB->selectCell("SELECT `sha_pass_hash` FROM `account` WHERE `id`=?d LIMIT 1",$user['id']);
      if((strlen($newpass)>=4) && (strlen($newpass)<=16) && $bOK){
          if($DB->query("UPDATE `account` SET `sha_pass_hash`=? WHERE `id`=?d LIMIT 1",$newI,$user['id'])==1){
          			$auth->login(array('username'=>$profile['username'],'password'=>$newpass));
          			output_message('notice','<b>'.$lang['change_pass_succ'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
          }
          else{
          	if ($newI!==$currI){
          		output_message('alert','<b>'.'Error change password.'.'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
          	}
          	else{
          		output_message('notice','<b>'.$lang['change_pass_equal'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
          	}
          }
			}elseif ($bOK) {
           	output_message('alert','<b>'.sprintf($lang['reg_checkpass'],$regparams['MIN_PASS_L'],$regparams['MAX_PASS_L']).'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
			} else {
			       output_message('alert','<b>'.$lang['reg_checkcpass'].'</b><meta http-equiv=refresh content="2;url=index.php?n=account&sub=manage">');
      }
    }elseif($_GET['action']=='change'){
        if(is_uploaded_file($_FILES['avatar']['tmp_name'])){
            if($_FILES['avatar']['size'] <= $config['max_avatar_file']){
                $ext = strtolower(substr(strrchr($_FILES['avatar']['name'],'.'), 1));
                if(in_array($ext,array('gif','jpg','png'))){
                    if(@move_uploaded_file($_FILES['avatar']['tmp_name'], $config['avatar_path'].$user['id'].'.'.$ext)){
                        list($width, $height, ,) = getimagesize($config['avatar_path'].$user['id'].'.'.$ext);
                        $max_avatar_size = explode('x',$config['max_avatar_size']);
                        if($width <= $max_avatar_size[0] || $height <= $max_avatar_size[1]){
                            $DB->query("UPDATE account_extend SET avatar='".$user['id'].'.'.$ext."' WHERE account_id=?d LIMIT 1",$user['id']);
                        }else{
                            @unlink($config['avatar_path'].$user['id'].'.'.$ext);
                        }
                    }
                }
            }
        }elseif($_POST['deleteavatar']==1 && preg_match("/\d+\.\w+/i",$_POST['avatarfile'])){
            $filename = $config['avatar_path'].$_POST['avatarfile'];
            if (file_exists($filename)) {
              if(@unlink($config['avatar_path'].$_POST['avatarfile'])){
                $DB->query("UPDATE account_extend SET avatar=NULL WHERE account_id=?d LIMIT 1",$user['id']);
              }
            } else {
              $DB->query("UPDATE account_extend SET avatar=NULL WHERE account_id=?d LIMIT 1",$user['id']);
            }
        }
    
        if(isset($_POST['profile']['g_id']))unset($_POST['profile']['g_id']);
        $_POST['profile']['signature'] = nl2br(strip_tags($_POST['profile']['signature']));
        
        $DB->query("UPDATE account_extend SET ?a WHERE account_id=?d LIMIT 1",$_POST['profile'],$user['id']);
        
        redirect('index.php?n=account&sub=manage',1);
    }elseif($_GET['action']=='changeuserbar') {
      if($_POST['deleteuserbar']==true){
        $DB->query("UPDATE account_extend SET userbar=NULL WHERE account_id=?d LIMIT 1",$user['id']);
      }else{ 
        $newuserbar = nl2br(strip_tags(trim($_POST['userbar'])));
        $DB->query("UPDATE account_extend SET userbar=? WHERE account_id=?d LIMIT 1", $newuserbar, $user['id']);
      }
      redirect('index.php?n=account&sub=manage',1);    
    }
}
?>
