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
		
			if ($realm_info['Version']!==''){
			require_once 'core/cache/'.$realm_info['Version'].'/UpdateFields.php';		
		} else {
			require_once 'core/cache/UpdateFields.php';	
		}
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
	    	$query = $WSDB->select("SELECT `guid`, `name`, `race`, `class`, `data`, `position_x`, `position_y`, `position_z`, `map`, `online` FROM `characters` WHERE `account`=?d ORDER BY `name`", $user['id']);
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
	        	$res_race = $site_defines['character_race'][$result['race']];
	        	$res_class = $site_defines['character_class'][$result['class']];
	        	$res_pos=get_zone_name($result['map'], $result['position_x'], $result['position_y']);
	        	$char_data = explode(' ',$result['data']);
	        	$char_gender = ((int)($char_data[$mangos_field['UNIT_FIELD_BYTES_0']]) >> 16) & hexdec('FF');
	        	$char_link = ($charinfo_link=="") ? "#" : $charinfo_link.$result['guid'];
	        	
						$char_money =$char_data[$mangos_field['PLAYER_FIELD_COINAGE']];			
						$char_money_str = money($char_money);
						
						$res_info[$cc]["guid"] = $result['guid'];
	        	$res_info[$cc]["number"] = $cc;
	        	$res_info[$cc]["res_color"] = $res_color;
	        	$res_info[$cc]["name"] = $result['name'];
	        	$res_info[$cc]["race"] = $result['race'];
	        	$res_info[$cc]["class"] = $result['class'];
	        	$res_info[$cc]["gender"] = $char_gender;
	        	$res_info[$cc]["level"] = $char_data[$mangos_field['UNIT_FIELD_LEVEL']];
	        	$res_info[$cc]["current_xp"]= $char_data[$mangos_field['PLAYER_XP']];
	        	$res_info[$cc]["next_level_xp"]= $char_data[$mangos_field['PLAYER_NEXT_LEVEL_XP']];
	        	$res_info[$cc]["xp_perc"] = ceil($res_info[$cc]["current_xp"]/$res_info[$cc]["next_level_xp"] * 100);
	        	$res_info[$cc]["online"]=$result['online'];
	        	$res_info[$cc]["online_img"]=($result['online']==0) ? "downarrow2.gif" : "uparrow2.gif";
						$res_info[$cc]["char_link"]=$char_link;
						$res_info[$cc]["money"]= $char_money_str;
						
						if ($result['online']==1) $res_info_myonline = true;
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
	
	if ($realm_info['Version']!==''){
			require_once 'core/cache/'.$realm_info['Version'].'_UpdateFields.php';		
		} else {
			require_once 'core/cache/UpdateFields.php';	
		}
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
	    	$query = $WSDB->selectrow("SELECT `guid`, `name`, `race`, `class`, `data`, `online` FROM `characters` WHERE `account`=?d and `guid`=?d ORDER BY `name`", $user['id'], $guid);
	    	if (!$query) {
	    		$strErrorMsg = 'Персонаж на вашем аккаунте не обнаружен';
					$bResult = false;
				} else {
						$char_online = $query['online'];
						if ($char_online) {
                  $strErrorMsg='Персонаж находится в игре!';
									$bResult=false;				  
            }    
				}
			}
			
			if ($bResult) {
				//print_r ($query);exit;
				$timecurr = time();
				$timecurrf=date('Y-m-d H:i:s', $timecurr);
				$timeactionf = $WSDB->selectCell("SELECT `timeaction` FROM `mwfe3_character_actions` WHERE account=?d and `guid`=?d and `action`=? ORDER BY `timeaction` DESC LIMIT 1",$user['id'],$guid,$action);
				$timeaction = strtotime($timeactionf);
				$timediffh = floor(($timecurr - $timeaction) / 3600); 
				
				$char_data = explode(' ',$query['data']);
				$char_money =$char_data[$mangos_field['PLAYER_FIELD_COINAGE']];	

				if ($action=='rename'){
				  if (!$config['chars_rename_enable']) {
				    output_message('alert','Переименование персонажей запрещено!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');  
          } else {
            if ($timediffh < $config['chars_rename_hdiff']) {
              $timenext = $timeaction + 3600 * $config['chars_rename_hdiff'];
              $timenextf=date('Y-m-d H:i:s', $timenext);
              output_message('alert','Слишком часто переименовываетесь! <br /> Следующий ренейм возможен: '.$timenextf.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');  
            } else {
              if ($char_money < $config['chars_rename_cost']) {
                output_message('alert','Недостаточно средств для переименования персонажа!</br>Есть: '.$char_money.
                ' Нужно: '.$config['chars_rename_cost'].'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
              } else {
                $RenameIsSet = $WSDB->selectCell("SELECT (`at_login` || 1) AS `Rename` FROM `characters` WHERE account=?d and `guid`=?d LIMIT 1",$user['id'],$guid);			
        				if (($RenameIsSet) and (0==1)){
        				  output_message('notice','Флаг переименования уже был установлен!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
                } else {
                  $char_money = $char_money - $config['chars_rename_cost'];
                  $char_data[$mangos_field['PLAYER_FIELD_COINAGE']] = $char_money;
                  $char_data_str = implode (' ', $char_data);
                
                  $WSDB->query("UPDATE `characters` SET `at_login`=(`at_login` || 1), `data`=? WHERE account=?d and `guid`=?d LIMIT 1", $char_data_str, $user['id'],$guid);
                  $WSDB->query("INSERT INTO `mwfe3_character_actions` 
                                (`guid`, `account`, `action`, `timeaction`, `data`) 
                                VALUES
                                (?d,?d,?,?,?);", $guid, $user['id'], $action, $timecurrf, $query['name']);
                    
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

                  $char_money = $char_money - $config['chars_changesex_cost'];
                  $char_data[$mangos_field['PLAYER_FIELD_COINAGE']] = $char_money;

									$_val = (int)($char_data[$mangos_field['UNIT_FIELD_BYTES_0']]);
									$_race  = $_val & hexdec('FF');
								  $_class = ($_val >> 8) & hexdec('FF');
								  $_gender = ($_val >> 16) & hexdec('FF');
								  $_powertype  = ($_val >> 24) & hexdec('FF');					
									$_gender = (($_gender == 0) ? 1 : 0);
								
									$_val = ($_race) | ($_class << 8) | ($_gender << 16) | ($_powertype << 24);
									$char_data[$mangos_field['UNIT_FIELD_BYTES_0']] = $_val;
									$char_data[$mangos_field['PLAYER_BYTES_3']] = $_gender;
												
									$_model=$char_models[$_race][$_gender];
									$char_data[$mangos_field['UNIT_FIELD_DISPLAYID']] = $_model;
									$char_data[$mangos_field['UNIT_FIELD_NATIVEDISPLAYID']] = $_model;
											
                  $char_data_str = implode (' ', $char_data);
                
                  $WSDB->query("UPDATE `characters` SET `data`=? WHERE account=?d and `guid`=?d LIMIT 1", $char_data_str, $user['id'], $guid);
                  $WSDB->query("INSERT INTO `mwfe3_character_actions` 
                                (`guid`, `account`, `action`, `timeaction`, `data`) 
                                VALUES
                                (?d,?d,?,?,?);", $guid, $user['id'], $action, $timecurrf, $query['data']);
  
        					output_message('notice','Операция по смене пола прошла успешно!'.'<meta http-equiv=refresh content="2;url=index.php?n=account&sub=chars">');
                }
            }
          }
				} else if ($action=='changesexfix') {
										
					$_val = (int)($char_data[$mangos_field['UNIT_FIELD_BYTES_0']]);
					$_race  = $_val & hexdec('FF');
					$_gender = ($_val >> 16) & hexdec('FF');					
					$_gender = (($_gender == 0) ? 1 : 0);
					
					$_val = (int)($char_data[$mangos_field['PLAYER_BYTES']]);
					$_skin = 1; 			//$_val & hexdec('FF');
          $_face = 1; 			//($_val >> 8) & hexdec('FF');
          $_hairStyle  = 1; //($_val >> 16) & hexdec('FF');
          $_hairColor  = 1; //($_val >> 24) & hexdec('FF');
          
					$_val = ($_skin) | ($_face << 8) | ($_hairStyle << 16) | ($_hairColor << 24);
          $char_data[$mangos_field['PLAYER_BYTES']] = $_val;
        
					$_val = (int)($char_data[$mangos_field['PLAYER_BYTES_2']]);
          $_facialHair = 1;	//$_val & hexdec('FF');
					$_field8 = (_val >> 8) & hexdec('FF');
          $_field16 = (_val >> 16) & hexdec('FF');
          $_field24 = (_val >> 24) & hexdec('FF');
					$_val = ($_facialHair) | ($_field8 << 8) | ($_field16 << 16) | ($_field24 << 24);
					$char_data[$mangos_field['PLAYER_BYTES_2']] = $_val;
					
					$char_data_str = implode (' ', $char_data);
					
					$WSDB->query("UPDATE `characters` SET `data`=? WHERE account=?d and `guid`=?d LIMIT 1", $char_data_str, $user['id'], $guid);
          $WSDB->query("INSERT INTO `mwfe3_character_actions` 
                      (`guid`, `account`, `action`, `timeaction`, `data`) 
                        VALUES
                      (?d,?d,?,?,?);", $guid, $user['id'], $action, $timecurrf, $query['data']);
  
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




