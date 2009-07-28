<?php

if(INCLUDED!==true)exit;
require_once 'core/defines.php';
require_once 'core/common.php';
	// ==================== //
	$pathway_info[] = array('title'=>$lang['account_chars'],'link'=>'./index.php?n=account&sub=chars');

	//===== Calc pages1 =====//
	$items_per_pages = $config['users_per_page'];
 	$limit_start = ($p-1)*$items_per_pages;

	if($user['id']<=0){
		redirect('index.php?n=account&sub=login',1);
	} else {
	
	if(!$_GET['realm']){
    $realm_list = realm_list();
    $count = count($realm_list);
    if ($count==1){
      $id=$DB->selectCell("SELECT `id` FROM `realmlist` ORDER BY `name`");
      $_GET['realm'] = $id;
    }
	}
	
	if(($_GET['realm']) and (!$_GET['action'] or !$_GET['guid'])){
			
			$realm=$_GET['realm'];
			$bResult = true;
			$strErrorMsg = "";
			$realmid = $DB->selectCell("select `id` from `realmlist` where id=?d", $realm);
			if(!$realmid){
				$strErrorMsg = 'Not realmid';
				$bResult = false; 
			}
			
			if ($bResult){
				$realm_info = get_realm_byid($realmid);
				if(!$realm_info['CharacterDatabaseInfo']){
					$strErrorMsg = 'Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id'];
					$bResult = false;
				} else {
					$pathway_info[] = array('title'=>$realm_info['name'],'link'=>'');
				}
			}
		
	   AddMangosFields ($realm_info['Version']);
		
	   $charinfo_link = $realm_info['WowdCharInfoLink'];
	
			if ($bResult){
	    	$wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
	    	$WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
				if (!$WSDB){
					$strErrorMsg = 'Not Connect';
					$bResult = false;
				}    	
			}
			
			if ($bResult) {
				$WSDB->setErrorHandler('databaseErrorHandler');
	    	$WSDB->query("SET NAMES ".$config['db_encoding']);
	    	$query = $WSDB->select("SELECT * FROM `characters` WHERE `account`=?d ORDER BY `name`", $user['id']);
	    	if (!$query) {
	    		$strErrorMsg = 'Not query';
					$bResult = false;
				}
			}

			if ($bResult){
					$res_info_myonline = false;
					$res_info_myname = $DB->selectCell("select `username` from `account` where id=?d", $user['id']);
					foreach ($query as $result) {
	        	if($res_color==1)$res_color=2;else $res_color=1;
	        	$cc++;     
						
						$my_char = new character($result, $mangos_field);
						
						$res_info[$cc]["guid"] = $my_char->guid;
	        	$res_info[$cc]["number"] = $cc;
	        	$res_info[$cc]["res_color"] = $res_color;
	        	$res_info[$cc]["name"] = $my_char->name;
	        	$res_info[$cc]["race"] = $my_char->race;
	        	$res_info[$cc]["class"] = $my_char->class;
	        	$res_info[$cc]["gender"] = $my_char->gender;
	        	$res_info[$cc]["level"] = $my_char->level;
	        	$res_info[$cc]["current_xp"]= $my_char->current_xp;
	        	$res_info[$cc]["next_level_xp"]= $my_char->next_level_xp;
	        	$res_info[$cc]["xp_perc"] = $my_char->xp_perc;
	        	$res_info[$cc]["online"]=$my_char->online;
	        	$res_info[$cc]["online_img"]=($my_char->online==0) ? "downarrow2.gif" : "uparrow2.gif";
						$res_info[$cc]["char_link"]=($charinfo_link=="") ? "#" : $charinfo_link.$my_char->guid;
						$res_info[$cc]["money"]= money($my_char->money);
						
						if ($my_char->online==1) $res_info_myonline = true;
	    	}
	    	
				$res_info_myonline_img = $res_info_myonline ? "uparrow2.gif" : "downarrow2.gif";
			}	else {
					output_message('alert',$strErrorMsg);	
			}
			
			unset($WSDB);

		} else if(($_GET['realm']) and ($_GET['action'] and $_GET['guid'])){
			
			$bResult = true;
			$strErrorMsg = "";
			$realm = $_GET['realm'];
			$realmid = $DB->selectCell("select `id` from `realmlist` where id=?d", $realm);
			if(!$realmid){
				$strErrorMsg = 'Not realmid';
				$bResult = false; 
			}
			
			if ($bResult){
				$realm_info = get_realm_byid($realmid);
				if(!$realm_info['CharacterDatabaseInfo']){
					$strErrorMsg = 'Check field <u>CharacterDatabaseInfo</u> in table `realmlist` for realm id='.$realm_info['id'];
					$bResult = false;
				}
			}
	
    AddMangosFields ($realm_info['Version']);
		
    $charinfo_link = $realm_info['WowdCharInfoLink'];
	
			if ($bResult){
	    	$wsdb_info = parse_worlddb_info($realm_info['CharacterDatabaseInfo']);
	    	$WSDB = DbSimple_Generic::connect("".$config['db_type']."://".$wsdb_info['user'].":".$wsdb_info['password']."@".$wsdb_info['host'].":".$wsdb_info['port']."/".$wsdb_info['db']."");
				if (!$WSDB){
					$strErrorMsg = 'Not Connect';
					$bResult = false;
				}    	
			}
			
			$action = $_GET['action'];
			$guid = $_GET['guid'];
			$char_online = false;
			
			if ($bResult) {
				$WSDB->setErrorHandler('databaseErrorHandler');
	    	$WSDB->query("SET NAMES ".$config['db_encoding']);
	    	$query = $WSDB->selectrow("SELECT * FROM `characters` WHERE `account`=?d and `guid`=?d ORDER BY `name`", $user['id'], $guid);
	    	$my_char;
	    	if (!$query) {
	    		$strErrorMsg = 'Персонаж на вашем аккаунте не обнаружен';
					$bResult = false;
				} else {
				    $my_char = new character($query, $mangos_field);
						if ($my_char->online) {
                  $strErrorMsg='Персонаж находится в игре!';
									$bResult=false;				  
            }    
				}
			}
			
			if ($bResult) {
				$timecurr = time();
				$timecurrf=date('Y-m-d H:i:s', $timecurr);
				$timeactionf = $WSDB->selectCell("SELECT `timeaction` FROM `mwfe3_character_actions` WHERE account=?d and `guid`=?d and `action`=? ORDER BY `timeaction` DESC LIMIT 1",$user['id'],$guid,$action);
				$timeaction = strtotime($timeactionf);
				$timediffh = floor(($timecurr - $timeaction) / 3600); 

				if ($action=='rename'){
				  if (!$config['chars_rename_enable']) {
				    output_message('alert','Переименование персонажей запрещено!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');  
          } else {
            if ($timediffh < $config['chars_rename_hdiff']) {
              $timenext = $timeaction + 3600 * $config['chars_rename_hdiff'];
              $timenextf=date('Y-m-d H:i:s', $timenext);
              output_message('alert','Слишком часто переименовываетесь! <br /> Следующий ренейм возможен: '.$timenextf.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');  
            } else {
              if ($my_char->money < $config['chars_rename_cost']){
                output_message('alert','Недостаточно средств для переименования персонажа!</br>Есть: '.$my_char->money.
                ' Нужно: '.$config['chars_rename_cost'].'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
              } else {			
        				if ($my_char->RenameIsSet()){
        				  output_message('notice','Флаг переименования уже был установлен!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
                } else {
                  $WSDB->query("INSERT INTO `mwfe3_character_actions` 
                                (`guid`, `account`, `action`, `timeaction`, `data`) 
                                VALUES
                                (?d,?d,?,?,?);", $my_char->guid, $user['id'], $action, $timecurrf, $my_char->name);
                    
                  $my_char->RenameSet(1);
                  $my_char->MoneyAdd (-$config['chars_rename_cost'], $mangos_field);
                  $WSDB->query("UPDATE `characters` SET ?a WHERE account=?d and `guid`=?d LIMIT 1", $my_char->sqlinfo, $user['id'], $my_char->guid);
                  
        					output_message('notice','Флаг переименования установлен!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
                }
              }
            }
          }
        } else if ($action=='changesex') {
				  if (!$config['chars_changesex_enable']) {
				    output_message('alert','Смена пола персонажей запрещена!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');  
          } else {
            if ($timediffh < $config['chars_changesex_hdiff']) {
              $timenext = $timeaction + 3600 * $config['chars_changesex_hdiff'];
              $timenextf=date('Y-m-d H:i:s', $timenext);
              output_message('alert','Слишком часто меняете пол! <br /> Следующая смена возможна: '.$timenextf.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');  
            } else {
              if ($char_money < $config['chars_changesex_cost']) {
                output_message('alert','Недостаточно средств для смены пола персонажа!</br>Есть: '.$char_money.
                ' Нужно: '.$config['chars_changesex_cost'].'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
              } else {
                  $WSDB->query("INSERT INTO `mwfe3_character_actions` 
                                (`guid`, `account`, `action`, `timeaction`, `data`) 
                                VALUES
                                (?d,?d,?,?,?);", $my_char->guid, $user['id'], $action, $timecurrf, $my_char->sqlinfo['data']);
                                
                  $my_char->ChangeGender ($mangos_field, $char_models);
                  $my_char->MoneyAdd (-$config['chars_changesex_cost'], $mangos_field);

                  $WSDB->query("UPDATE `characters` SET ?a WHERE account=?d and `guid`=?d LIMIT 1", $my_char->sqlinfo, $user['id'], $my_char->guid);
                  
                  output_message('notice','Операция по смене пола прошла успешно!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
                }
            }
          }
				} else if ($action=='changesexfix') {
				            $WSDB->query("INSERT INTO `mwfe3_character_actions` 
                      (`guid`, `account`, `action`, `timeaction`, `data`) 
                        VALUES
                      (?d,?d,?,?,?);", $my_char->guid, $user['id'], $action, $timecurrf, $my_char->sqlinfo['data']);						
					$my_char->ChangeGenderFix ($mangos_field, $char_models);
					
					$WSDB->query("UPDATE `characters` SET `data`=?a WHERE account=?d and `guid`=?d LIMIT 1", $my_char->sqlinfo, $user['id'], $my_char->guid);
  
        	output_message('notice','Фикс после смены пола персонажа выполнен успешно!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
					          
        } else if ($action=='move') {
					output_message('notice','Перемещение!');
				} else if ($action=='changed') {
					output_message('notice','Обмен!');				
			  }	
			} else output_message('alert',$strErrorMsg.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');	
		}
	}

?>




