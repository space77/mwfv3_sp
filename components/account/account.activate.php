<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['activation'],'link'=>'');
// ==================== //
$key = $_REQUEST['key'];
if($key){
  if($act_accid = $auth->isvalidactkey($key)){
    $DB->query("UPDATE account SET locked=0 WHERE id=?d LIMIT 1",$act_accid);
        $DB->query("UPDATE account_extend SET activation_code=NULL WHERE account_id=?d LIMIT 1",$act_accid);
        if($config['req_reg_invite'] > 0 && $config['req_reg_invite'] < 10){
            $keys_arr = $auth->generate_keys($config['req_reg_invite']);
            $email_text  = '';
            foreach ($keys_arr as $invkey){
                $DB->query('INSERT INTO site_regkeys (`key`,`used`) VALUES(?,1)', $invkey);
                $email_text .= ' - '.$invkey."\n";
            }
            $email_text = sprintf($lang['emailtext_inv_keys'],$email_text);
            $accinfo = $auth->getprofile($act_accid);
            send_email($accinfo['email'],$accinfo['username'],'== '.$config['site_title'].' invitation keys ==',$email_text);
            output_message('notice',sprintf($lang['email_sent_keys'],$config['req_reg_invite']));
        }
    output_message('notice','<b>'.$lang['act_succ'].'.</b>');
  }else{
    output_message('alert',$lang['bad_act_key']);
    redirect('index.php?n=account&sub=activate',0,2);
  }
}

?>