<style type = "text/css">
  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
  .mydiv {color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold;  border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>

<script type="text/javascript">
	function CharAction(realm, guid, action, charname, info) {
		var bConfirmed, msg;
		if (!isFinite(guid)) {window.event.returnValue = false; return false;}
		if (charname==undefined) {window.event.returnValue = false; return false;} 
		if (action=='rename') {
			msg='Вы действительно желаете переименовать персонажа: '+charname+'?';
		} else if (action=='changesex') {
			if (!isFinite(info)) {window.event.returnValue = false; return false;}
			msg='Вы действительно желаете поменять пол персонажа: '+charname+' на '+((info==0) ? 'женский' : 'мужской');
		} else if (action=='changesexfix') {
			msg='Вы действительно желаете применить фикс после смены пола персонажа: '+charname;
		} else if (action=='move') {
			if (info==undefined) {window.event.returnValue = false; return false;}
			msg='Вы действительно желаете переместить персонажа: '+charname+' на аккаунт: '+info;
		} else if (action=='change') {
			if (info==undefined) {window.event.returnValue = false; return false;}
			msg='Вы действительно желаете обменять персонажа: '+charname+' с аккаунтом: '+info;
		} else {
			window.event.returnValue = false; return false;
		}
		
		bConfirmed = window.confirm(msg);
		if (bConfirmed) {
			window.location.href = 'index.php?n=account&sub=chars&realm='+realm+'&action='+action+'&guid='+guid;
		}
		
		window.event.returnValue = false;
	}
</script>

<center>

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tbody>
<tr>
  <td colspan='2'>
  
<?php if (!$_GET['realm']) { ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td width="24"><img src="<?php echo $config['template_href'];?>images/subheader-left-sword.gif" height="20" width="24"></td>
            <td bgcolor="#05374a" width="100%"><b style="color:white;"><?php echo $lang['choose_realm'];?>:</b></td>
            <td width="10"><img src="<?php echo $config['template_href'];?>images/subheader-right.gif" height="20" width="10"></td>
        </tr>
    </tbody>
</table>
<!--PlainBox Top-->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td width="3"><img src="<?php echo $config['template_href'];?>images/plainbox-top-left.gif" border="0" height="3" width="3"></td>
            <td background="<?php echo $config['template_href'];?>images/plainbox-top.gif" width="100%"></td>
            <td width="3"><img src="<?php echo $config['template_href'];?>images/plainbox-top-right.gif" border="0" height="3" width="3"></td>
        </tr>
        <tr>
            <td background="<?php echo $config['template_href'];?>images/plainbox-left.gif"></td>
            <td bgcolor="#cdb68d" valign="top">
<!--PlainBox Top-->
            <center>
                <table width="80%">
                    <tbody>
                        <tr>
                            <td valign="top" width="100%">
                                <span>
                                <?php
                                foreach($realm_list as $id=>$name){echo "<li><a href='./index.php?n=account&sub=chars&realm=$id'><b>$name</b></a></li> \n";}
                                ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
<!--PlainBox Bottom-->
            </td>
            <td background="<?php echo $config['template_href'];?>images/plainbox-right.gif"></td>
        </tr>
        <tr>
            <td><img src="<?php echo $config['template_href'];?>images/plainbox-bot-left.gif" border="0" height="3" width="3"></td>
            <td background="<?php echo $config['template_href'];?>images/plainbox-bot.gif"></td>
            <td><img src="<?php echo $config['template_href'];?>images/plainbox-bot-right.gif" border="0" height="3" width="3"></td>
        </tr>
    </tbody>
</table>
<!--PlainBox Bottom-->



<?php } elseif ($_GET['realm']) { ?>  
  
<div class="news-expand">
  <div class="news-item">
    <blockquote>
      <dl>
        <dd>
          <ul>
            <li>
            <div class="blog-post"> Доступные действия:&nbsp; 
                <?
                if (!($config['chars_rename_enable']) and 
                    !($config['chars_move_enable']) and
                    !($config['chars_change_enable']) and
                    !($config['chars_changesex_enable'])) {
                    echo ("Все запрещено!");
                    } else {
                ?>
              <table  width=100% style="color: black; border-top: solid 1px black; border-bottom: solid 1px black; font-size: 10pt; font-family: arial,helvetica,sans-serif;" cellpadding='0' cellspacing='0'>
                <tr>
                  <td style="border-bottom: solid 1px black; font-weight: bold">Действие</td>
                  <td style="text-align: center; border-bottom: solid 1px black; font-weight: bold">Цена</td>
                  <td style="text-align: center; border-bottom: solid 1px black; font-weight: bold">Частота (раз в nnn часов)</td>
                </tr>
                <? if ($config['chars_rename_enable']){?>
                 <tr>
                    <td><?=$lang['account_chars_actions_rename'];?></td>
  								  <td style="text-align: center"><?=money($config['chars_rename_cost']);?></td>
  								  <td style="text-align: center"><?=$config['chars_rename_hdiff'];?></td>
                  </tr> 
                <?} 
                if ($config['chars_move_enable']){ ?>
		          	<tr>
                  <td><?=$lang['account_chars_actions_move'];?></td>
								  <td style="text-align: center"><?=money($config['chars_move_cost']);?></td>
  								<td style="text-align: center"><?=$config['chars_move_hdiff'];?></td>
                </tr>
                <?}
                if ($config['chars_change_enable']){ ?>
		          	<tr>
                  <td><?=$lang['account_chars_actions_change'];?></td>
  								<td style="text-align: center"><?=money($config['chars_change_cost']);?></td>
  								<td style="text-align: center"><?=$config['chars_change_hdiff'];?></td>
                </tr>
                <?}
                if ($config['chars_changesex_enable']){?>
								<tr>
                  <td><?=$lang['account_chars_actions_changesex'];?></td>
									<td style="text-align: center"><?=money($config['chars_changesex_cost']);?></td> 
								  <td style="text-align: center"><?=$config['chars_changesex_hdiff'];?></td>
                </tr>
                <? } ?>
              </table>
              <? } ?> 
            </div></li>
          </ul>
        </dd>
      </dl>
      </blockquote>
  </div>
</div>

<div style='cursor: auto;' id='dataElement'>
<span>
<?php if(!$_GET['action'] or !$_GET['guid']){ ?>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
  <tbody>
  <tr>
    <td width='12'><img src='templates/offlike/images/metalborder-top-left.gif' height='12' width='12'></td>
    <td background='templates/offlike/images/metalborder-top.gif'></td>
    <td width='12'><img src='templates/offlike/images/metalborder-top-right.gif' height='12' width='12'></td>
  </tr>
  <tr>
    <td background='templates/offlike/images/metalborder-left.gif'></td>
    <td>
      <table cellpadding='3' cellspacing='0' width='100%'>
        <tbody>  
				<tr>
					<td class='rankingHeader' align='center' nowrap='nowrap' colspan='8'>
							<b><?=$res_info_myname;?>:&nbsp;</b> <img src="images/<?=$res_info_myonline_img;?>" height='18' width='18'>						
					</td>
				</tr> 
        <tr>
          <td class='rankingHeader' align='center' nowrap='nowrap'>#</td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['name'];?>&nbsp;</td> 
          <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['race'];?>&nbsp;</td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['class'];?>&nbsp;</td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['level_short'];?>&nbsp;</td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['online'];?>&nbsp;</td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['money'];?>&nbsp;</td>
          <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['account_chars_actions'];?>&nbsp;</td>
        </tr>
        <?php foreach($res_info as $item){ ?>

		        <tr>
		          <td class="serverStatus<?php echo $item['res_color'] ?>" align='center'><b style='color: rgb(102, 13, 2);'><?php echo $item['number']; ?></b></td>
		          
							<td class="serverStatus<?php echo $item['res_color'] ?>">
								<a href="<?php echo $item['char_link']; ?>">
									<b class='smallBold' style='color: rgb(35, 67, 3);'>
										<?php echo $item['name']; ?>
									</b>
								</a>
							</td>
		          
							<td class="serverStatus<?php echo $item['res_color'] ?>" align='center'><small style='color: rgb(102, 13, 2);'><img onmouseover="ddrivetip('<?php echo $site_defines['character_race'][$item['race']]; ?>','#ffffff')" onmouseout="hideddrivetip()" src='templates/offlike/images/icon/race/<?php echo $item['race'];?>-<?php echo $item['gender'];?>.gif' height='18' width='18'></small></td>
		          <td class="serverStatus<?php echo $item['res_color'] ?>" align='center'><small style='color: (35, 67, 3);'><img onmouseover="ddrivetip('<?php echo $site_defines['character_class'][$item['class']]; ?>','#ffffff')" onmouseout="hideddrivetip()" src='templates/offlike/images/icon/class/<?php echo $item['class'];?>.gif' height='18' width='18'></small></td>
		
		          <td  width="40" class="serverStatus<?php echo $item['res_color'] ?>"><b style='color: rgb(102, 13, 2);'>
		            <div style="border:1px solid #b26d2e;position:relative;width:100px;padding:1px" onmouseover="ddrivetip('<?php echo $item['current_xp'];?> <?php echo $lang['of'];?> <?php echo $item['next_level_xp'];?>','#ffffff')" onmouseout="hideddrivetip()">
		            	<div style="width:<?=$item['xp_perc']?>px;background:#b26d2e;height:14px" align="left"></div>
		              <small style="color:#660c03;position:absolute;top:2px;left:45%"><?=$item['level'];?></small>
		            </div>
			  			</b></td>
		
		          <td class="serverStatus<?=$res['res_color'] ?>" align="center"><img src="images/<?=$item['online_img'];?>" height='18' width='18'></td>
		          <td class="serverStatus<?php echo $item['res_color'] ?>" align='center'><small style='color: rgb(102, 13, 2);'><?php echo $item['money']; ?></small></td>
		          <td class="serverStatus<?=$res['res_color'] ?>" align="left">
		          	<? if ($config['chars_rename_enable']){?>
                <li>
                	<input type="button" style="width:125px" onclick="CharAction(<?=$_GET['realm']?>,<?=$item['guid'];?>, 'rename', '<?=$item['name'];?>', 0);" 
										value="<?=$lang['account_chars_actions_rename'];?>">
                </li>
                <?} 
                if ($config['chars_move_enable']){ ?>
		          	<li>
								  <input type="button" style="width:125px" onclick="CharAction(<?=$_GET['realm']?>,<?=$item['guid'];?>, 'move', '<?=$item['name'];?>', 0);" 
										value="<?=$lang['account_chars_actions_move'];?>">
                </li>
                <?}
                if ($config['chars_change_enable']){ ?>
		          	<li>
								  <input type="button" style="width:125px" onclick="CharAction(<?=$_GET['realm']?>,<?=$item['guid'];?>, 'change', '<?=$item['name'];?>', 0);" 
										value="<?=$lang['account_chars_actions_change'];?>">
                </li>
                <?}
                if ($config['chars_changesex_enable']){?>
								<li>
								  <input type="button" style="width:125px" onclick="CharAction(<?=$_GET['realm']?>,<?=$item['guid'];?>, 'changesex', '<?=$item['name'];?>', <?=$item['gender'];?>);" 
										value="<?=$lang['account_chars_actions_changesex'];?>">
										<input type="button" style="width:30px" onclick="CharAction(<?=$_GET['realm']?>,<?=$item['guid'];?>, 'changesexfix', '<?=$item['name'];?>', <?=$item['gender'];?>);" 
										value="<? echo('Fix');?>">
                </li>
                <?}
                if (!($config['chars_rename_enable']) and 
                    !($config['chars_move_enable']) and
                    !($config['chars_change_enable']) and
                    !($config['chars_changesex_enable'])) {
                    echo ("Все запрещено!");
                    }
                ?>
							</td> 
		        </tr>

        <?php }?>
        </tbody>
      </table>
    </td>
    <td background='templates/offlike/images/metalborder-right.gif'></td>
  </tr>
  <tr>
    <td><img src='templates/offlike/images/metalborder-bot-left.gif' height='11' width='12'></td>
    <td background='templates/offlike/images/metalborder-bot.gif'></td>
    <td><img src='templates/offlike/images/metalborder-bot-right.gif' height='11' width='12'></td>
  </tr>
  </tbody>
</table>
<?php } else if ($_GET['action'] and $_GET['guid']){ 
  if ($_GET['action']=='move'){ ?>
  <br /><br />
<div class="news-expand">
    <div class="news-item">

              <table  width=100% style="color: black; border-top: solid 1px black; border-bottom: solid 1px black; font-size: 10pt; font-family: arial,helvetica,sans-serif;" cellpadding='0' cellspacing='0'>
                <tr>
                  <td collspan='3'>
                    Перемещение персонажа:
                  </td>
                </tr>
                <tr>
                  <td style="border-bottom: solid 1px black; font-weight: bold">Персонаж:</td>
                  <td style="text-align: center; border-bottom: solid 1px black; font-weight: bold">Я</td>
                  <td style="text-align: center; border-bottom: solid 1px black; font-weight: bold">Онлайн</td>
                </tr>
              </table> 
            
  </div>
</div>
  <?}?>	 
<?php } ?> 
		 
</span>
</div>
<?php } ?>



</td>
</tr>
</tbody></table>
</center>
</center>
