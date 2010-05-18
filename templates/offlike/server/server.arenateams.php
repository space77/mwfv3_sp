<style type = "text/css">
  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>
<center>

<?php if(empty($_GET['realm'])){ ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td width="24"><img src="<?=$config['template_href'];?>images/subheader-left-sword.gif" height="20" width="24"></td>
            <td bgcolor="#05374a" width="100%"><b style="color:white;"><?=$lang['choose_realm'];?>:</b></td>
            <td width="10"><img src="<?=$config['template_href'];?>images/subheader-right.gif" height="20" width="10"></td>
        </tr>
    </tbody>
</table>
<!--PlainBox Top-->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td width="3"><img src="<?=$config['template_href'];?>images/plainbox-top-left.gif" border="0" height="3" width="3"></td>
            <td background="<?=$config['template_href'];?>images/plainbox-top.gif" width="100%"></td>
            <td width="3"><img src="<?=$config['template_href'];?>images/plainbox-top-right.gif" border="0" height="3" width="3"></td>
        </tr>
        <tr>
            <td background="<?=$config['template_href'];?>images/plainbox-left.gif"></td>
            <td bgcolor="#cdb68d" valign="top">
<!--PlainBox Top-->
            <center>
                <table width="80%">
                    <tbody>
                        <tr>
                            <td valign="top" width="100%">
                                <span>
                                <?php
                                foreach($realm_list as $id=>$name){echo "<li><a href=\"index.php?n=server&sub=arenateams&realm=$id\"><b>$name</b></a></li> \n";}
                                ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
<!--PlainBox Bottom-->
            </td>
            <td background="<?=$config['template_href'];?>images/plainbox-right.gif"></td>
        </tr>
        <tr>
            <td><img src="<?=$config['template_href'];?>images/plainbox-bot-left.gif" border="0" height="3" width="3"></td>
            <td background="<?=$config['template_href'];?>images/plainbox-bot.gif"></td>
            <td><img src="<?=$config['template_href'];?>images/plainbox-bot-right.gif" border="0" height="3" width="3"></td>
        </tr>
    </tbody>
</table>
<!--PlainBox Bottom-->
<?php }elseif($_GET['realm']){ ?>
<center>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tbody>
<tr>
  <td colspan='2'>
<div style='cursor: auto;' id='dataElement'>
<span>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
  <tbody>
  <tr>
    <td width='12'><img src='<?=$config['template_href'];?>images/metalborder-top-left.gif' height='12' width='12'></td>
    <td background='<?=$config['template_href'];?>images/metalborder-top.gif'></td>
    <td width='12'><img src='<?=$config['template_href'];?>images/metalborder-top-right.gif' height='12' width='12'></td>
  </tr>
  <tr>
    <td background='<?=$config['template_href'];?>images/metalborder-left.gif'></td>
    <td>
      <table cellpadding='3' cellspacing='0' width='100%'>
        <tbody>
		<?php if($_GET['arenateamid']){ ?>
        <tr>
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'>#</td>
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['name'];?>&nbsp;</td> 
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['race'];?>&nbsp;</td>
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['class'];?>&nbsp;</td>
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['level_short'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['online'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' colspan='2' nowrap='nowrap'><?=$lang['t_week'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' colspan='2' nowrap='nowrap'><?=$lang['t_season'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['t_rating'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['t_point_to_add'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?='i';?>&nbsp;</td>
        </tr>
        <tr>
          <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['t_played'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['t_wins'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['t_played'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['t_wins'];?>&nbsp;</td>
        </tr>
        <?php foreach($res_info as $res){
          $cc1++;
          if($color==1)$color=2; else $color=1; 
        ?>
        <tr>
          <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$cc1; ?></b></td>
          <td class="serverStatus<?=$color ?>"><b class='smallBold' style='color: rgb(35, 67, 3);'><?=$res['name']; ?></b></td>
          <td class="serverStatus<?=$color ?>" align='center'><small style='color: rgb(102, 13, 2);'><img onmouseover="ddrivetip('<?=$site_defines['character_race'][$res['race']]; ?>','#ffffff')" onmouseout="hideddrivetip()" src='templates/offlike/images/icon/race/<?=$res['race'];?>-<?=$res['gender'];?>.gif' height='18' width='18'></small></td>
          <td class="serverStatus<?=$color ?>" align='center'><small style='color: (35, 67, 3);'><img onmouseover="ddrivetip('<?=$site_defines['character_class'][$res['class']]; ?>','#ffffff')" onmouseout="hideddrivetip()" src='templates/offlike/images/icon/class/<?=$res['class'];?>.gif' height='18' width='18'></small></td>
          <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$res['level']; ?></b></td>
          <td class="serverStatus<?=$color ?>" align="center"><img src="images/<?=$res['online'];?>" height='18' width='18'></td>
          <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$res['played_week']; ?></b></td>
          <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(35, 67, 3);'><?=$res['wons_week']; ?></b></td>
          <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$res['played_season']; ?></b></td>
          <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(35, 67, 3);'><?=$res['wons_season']; ?></b></td>
          <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$res['MemberRaiting']; ?></b></td>
          <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$res['points_to_add']; ?></b></td>
          <td class="serverStatus<?=$color ?>" align='center'>
						<b style='color: rgb(35, 67, 3);'>
							<input type="submit" value="i" class="button" style="font-size:11px;" onclick="alert('<?=$res['AT_MiscInfo'];?>');">
						</b>
					</td>
        </tr>
        <?php }}else { ?>
        <tr>
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'>#</td>
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['t_name'];?>&nbsp;</td> 
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['t_captain'];?>&nbsp;</td>
          <td class='rankingHeader' align='center' rowspan='2' nowrap='nowrap'><?=$lang['t_rating'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' colspan='2' nowrap='nowrap'><?=$lang['t_week'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' colspan='2' nowrap='nowrap'><?=$lang['t_season'];?>&nbsp;</td>
        </tr>
        <tr>
		      <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['t_played'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['t_wins'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['t_played'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center' nowrap='nowrap'><?=$lang['t_wins'];?>&nbsp;</td>
        </tr>
        
        <?php
          $cc1=0;
          $t_type=0; 
          foreach($res_info as $res){    
          if ($t_type != $res['type']){
            $cc1=0;
            $t_type=$res['type'];
        ?>
          <tr>
            <td class='rankingHeader' align='center' colspan='8' nowrap='nowrap'><?=$lang['t_type'.$t_type];?></td>
          </tr>
        <?php
          } 
          $cc1++;
          if($color==1)$color=2; else $color=1; 
        ?>
          <tr>
            <td class="serverStatus<?=$color ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$cc1; ?></b></td>
		        <td class="serverStatus<?=$color ?>" nowrap='nowrap'><b class="smallBold"><a href="index.php?n=server&sub=arenateams&realm=<?=$_GET['realm'];?>&arenateamid=<?=$res['arenateamid'];?>" style="color:rgb(35,67,3)"><?=$res["name"]; ?></a></b></td>
            <td class="serverStatus<?=$color ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['captain']; ?></small></td>
            <td class="serverStatus<?=$color ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['rating']; ?></small></td>
            <td class="serverStatus<?=$color ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['games']; ?></small></td>
            <td class="serverStatus<?=$color ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['wins']; ?></small></td>
            <td class="serverStatus<?=$color ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['played']; ?></small></td>
            <td class="serverStatus<?=$color ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['wins2']; ?></small></td>
          </tr>
        <?php } } ?>
        </tbody>
      </table>
    </td>
    <td background='<?=$config['template_href'];?>images/metalborder-right.gif'></td>
  </tr>
  <tr>
    <td><img src='<?=$config['template_href'];?>images/metalborder-bot-left.gif' height='11' width='12'></td>
    <td background='<?=$config['template_href'];?>images/metalborder-bot.gif'></td>
    <td><img src='<?=$config['template_href'];?>images/metalborder-bot-right.gif' height='11' width='12'></td>
  </tr>
  </tbody>
</table>
</span>
</div>
</td>
</tr>
</tbody></table>
</center>
<?php } ?>
</center>
