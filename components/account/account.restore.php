<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['retrieve_pass'],'link'=>'');
// ==================== //
if($_POST['retr_login'] && $_POST['retr_email']){
    $retr_info = $DB->selectRow("SELECT `username`,`password`,`email` FROM `account` WHERE username=? AND email=? LIMIT 1",$_POST['retr_login'],$_POST['retr_email']);
    if($retr_info['password']){
            $email_text = sprintf($lang['email_retrieve_pass'],$retr_info['password']);
            send_email($retr_info['email'],$retr_info['username'],'== '.$config['site_title'].' password retrive ==',$email_text);
        
        output_message('notice','<b>'.$lang['retrieve_pass_succ'].'.</b>');
        redirect('index.php?n=account&sub=login',0,3);
    }else{
        output_message('alert',$lang['retrieve_pass_fail']);
        redirect('index.php?n=account&sub=restore',0,3);
    }
}

?>