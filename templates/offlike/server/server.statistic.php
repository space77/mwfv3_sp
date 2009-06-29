<? 
	$h_col='115,0,0';
	$a_col='0,0,115';
?>
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
                                foreach($realm_list as $id=>$name){echo "<li><a href=index.php?n=server&sub=statistic&realm=$id><b>$name</b></a></li> \n";}
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
<?php
}elseif($_GET['realm']){
?>
	<table border="0" cellpadding="0" cellspacing="0" width="90%">
		<tbody>
			<tr>
				<td width="24"><img src="<?=$config['template_href'];?>images/subheader-left-sword.gif" height="20" width="24"></td>
					<td bgcolor="#05374a" width="100%"><b class="white"><?=$lang['statistic'];?> <?=$realm_info['name']; ?></b></td>
					<td width="10"><img src="<?=$config['template_href'];?>images/subheader-right.gif" height="20" width="10"></td>
				</tr>
			</tbody>
		</table>
		<center>
			<table width="90%">
				<tr>
					<td colspan="2" align="left" style="padding-left:20px;">
						<img src="templates/<?=$config['template'];?>/images/battlegrounds-alliance.jpg" alt="Alliance">
                    </td>
                    <td colspan="2" align="right" style="padding-right:20px;">
						<img src="templates/<?=$config['template'];?>/images/battlegrounds-horde.jpg" alt="Horde">
                    </td>
				</tr>
                <tr>
					<td colspan="2" align="left" style="padding-left:20px;">
						<b><?=$lang['Alliance'];?>:</b> <?=$num_ally;?>(<?=$pc_ally;?>%)
					</td>
                    <td colspan="2" align="right" style="padding-right:20px;">
						<b><?=$lang['Horde'];?>:</b> <?=$num_horde;?>(<?=$pc_horde;?>%)
                    </td>
				</tr>
                <tr>
					<td align="left">
						<img onmouseover="ddrivetip('<?=$site_defines['character_race'][1];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/1-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][1];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/1-1.gif" align="absmiddle">
					</td>
					<td align="left" width="220">
						<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_human;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_human;?>(<?=$pc_human;?>%)</b></small>
						</div>
					</td>
					<td align="right" width="220">
						<div style="border:1px solid rgb(<?=$h_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_orc;?>%;background:rgb(<?=$h_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_orc;?>(<?=$pc_orc;?>%)</b></small>
						</div>
					</td>						  
						<td align="right">
							<img onmouseover="ddrivetip('<?=$site_defines['character_race'][2];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/2-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][2];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/2-1.gif" align="absmiddle">
                        </td>
                    </tr>
                <tr>
					<td align="left">
						<img onmouseover="ddrivetip('<?=$site_defines['character_race'][3];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/3-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][3];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/3-1.gif" align="absmiddle">
					</td>
					<td align="left" width="220">
						<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_dwarf;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_dwarf;?>(<?=$pc_dwarf;?>%)</b></small>
						</div>
					</td>
					<td align="right" width="220">
						<div style="border:1px solid rgb(<?=$h_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_undead;?>%;background:rgb(<?=$h_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_undead;?>(<?=$pc_undead;?>%)</b></small>
						</div>
					</td>						  
						<td align="right">
							<img onmouseover="ddrivetip('<?=$site_defines['character_race'][5];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/5-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][5];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/5-1.gif" align="absmiddle">
                        </td>
                    </tr>
                    <tr>
						<td align="left">
							<img onmouseover="ddrivetip('<?=$site_defines['character_race'][4];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/4-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][4];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/4-1.gif" align="absmiddle">
                        </td>
						<td align="left" width="220">
						<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_ne;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_ne;?>(<?=$pc_ne;?>%)</b></small>
						</div>
						</td>
						<td align="right" width="220">
						<div style="border:1px solid rgb(<?=$h_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_tauren;?>%;background:rgb(<?=$h_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_tauren;?>(<?=$pc_tauren;?>%)</b></small>
						</div>
						</td>	
                        <td align="right">
							<img onmouseover="ddrivetip('<?=$site_defines['character_race'][6];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/6-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][6];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/6-1.gif" align="absmiddle">
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <img onmouseover="ddrivetip('<?=$site_defines['character_race'][7];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/7-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][7];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/7-1.gif" align="absmiddle">
                        </td>
						<td align="left" width="220">
						<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_gnome;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_gnome;?>(<?=$pc_gnome;?>%)</b></small>
						</div>
						</td>
						<td align="right" width="220">
						<div style="border:1px solid rgb(<?=$h_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_troll;?>%;background:rgb(<?=$h_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_troll;?>(<?=$pc_troll;?>%)</b></small>
						</div>
						</td>	
                        <td align="right">
                            <img onmouseover="ddrivetip('<?=$site_defines['character_race'][8];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/8-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][8];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/8-1.gif" align="absmiddle">
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <img onmouseover="ddrivetip('<?=$site_defines['character_race'][11];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/11-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][11];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/11-1.gif" align="absmiddle">
                        </td>
						<td align="left" width="220">
						<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_draenei;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_draenai;?>(<?=$pc_draenei;?>%)</b></small>
						</div>
						</td>
						<td align="right" width="220">
						<div style="border:1px solid rgb(<?=$h_col;?>);position:relative;width:95%;padding:1px">
							<div style="width:<?=$pc_bloodelves;?>%;background:rgb(<?=$h_col;?>);height:14px" align="left"></div>
							<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_be;?>(<?=$pc_bloodelves;?>%)</b></small>
						</div>
						</td>	
                        <td align="right">
                            <img onmouseover="ddrivetip('<?=$site_defines['character_race'][10];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/10-0.gif" align="absmiddle"> <img onmouseover="ddrivetip('<?=$site_defines['character_race'][10];?>','#ffffff')" onmouseout="hideddrivetip()" src="templates/<?=$config['template'];?>/images/icon/race/10-1.gif" align="absmiddle">
                        </td>
                    </tr>
					
					<tr>
						<td colspan="4" align="center"><img src="/img/hr.gif" alt="" /></td>
					</tr>
					<tr>
						<td colspan="2" align="left">
						<table width="300">
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][1]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/1.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_1;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_1;?>(<?=$pc_1;?>%)</b></small>
								</div>
								</td>
							</tr>
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][2]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/2.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_2;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_2;?>(<?=$pc_2;?>%)</b></small>
								</div>
								</td>
							</tr>
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][3]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/3.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_3;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_3;?>(<?=$pc_3;?>%)</b></small>
								</div>
								</td>
							</tr>
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][4]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/4.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_4;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_4;?>(<?=$pc_4;?>%)</b></small>
								</div>
								</td>
							</tr>
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][5]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/5.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_5;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_5;?>(<?=$pc_5;?>%)</b></small>
								</div>
								</td>
							</tr>
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][7]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/7.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_7;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_7;?>(<?=$pc_7;?>%)</b></small>
								</div>
								</td>
							</tr>
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][8]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/8.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_8;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_8;?>(<?=$pc_8;?>%)</b></small>
								</div>
								</td>
							</tr>
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][9]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/9.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_9;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_9;?>(<?=$pc_9;?>%)</b></small>
								</div>
								</td>
							</tr>
							<tr>
								<td width="18"><img onmouseover="ddrivetip('<?=$site_defines['character_class'][11]; ?>','#ffffff')" onmouseout="hideddrivetip()" src="<?=$config['template_href'];?>images/icon/class/11.gif"></td>
								<td>
								<div style="border:1px solid rgb(<?=$a_col;?>);position:relative;width:100%;padding:1px">
									<div style="width:<?=$pc_11;?>%;background:rgb(<?=$a_col;?>);height:14px" align="left"></div>
									<small style="color:rgb(155,90,60);position:absolute;top:2px;left:45%"><b><?=$num_11;?>(<?=$pc_11;?>%)</b></small>
								</div>
								</td>
							</tr>
						</table>
					</td>
					<td colspan="2" style="padding:0">
						<table>
							<tr><td><img src="<?=$config['template_href'];?>images/bulletred.gif" width="17" height="17" style="margin-bottom:4px"></td><td><span><?=$lang['characters'];?>:</span></td><td align="right"><b class="smallBold"><?=$num_char;?></b></td></tr>
							<tr><td><img src="<?=$config['template_href'];?>images/bulletred.gif" width="17" height="17" style="margin-bottom:4px"></td><td><span><?=$lang['guilds'];?>:</span></td><td align="right"><b class="smallBold"><?=$num_guilds;?></b></td></tr>
							<tr><td><img src="<?=$config['template_href'];?>images/bulletred.gif" width="17" height="17" style="margin-bottom:4px"></td><td><span><?=$lang['in_guilds'];?>:</span></td><td align="right"><b class="smallBold"><?=$num_pguild;?></b></td></tr>
							<tr><td><img src="<?=$config['template_href'];?>images/bulletred.gif" width="17" height="17" style="margin-bottom:4px"></td><td><span><?=$lang['quests'];?>:</span></td><td align="right"><b class="smallBold"><?=$num_quest;?></b></td></tr>
							<tr><td><img src="<?=$config['template_href'];?>images/bulletred.gif" width="17" height="17" style="margin-bottom:4px"></td><td><span><?=$lang['npc'];?>:</span></td><td align="right"><b class="smallBold"><?=$num_npc;?></b></td></tr>
							<tr><td><img src="<?=$config['template_href'];?>images/bulletred.gif" width="17" height="17" style="margin-bottom:4px"></td><td><span><?=$lang['items'];?>:</span></td><td align="right"><b class="smallBold"><?=$num_items;?></b></td></tr>
							<tr><td><img src="<?=$config['template_href'];?>images/bulletred.gif" width="17" height="17" style="margin-bottom:4px"></td><td><span><?=$lang['objects'];?>:</span></td><td align="right"><b class="smallBold"><?=$num_obj;?></b></td></tr>
						</table>
					</td>
				</tr>

                    <tr>
                        <td colspan="2" align="left" style="padding-left:20px"></td>
                        <td colspan="2" align="right" style="padding-right:20px"></td>
                    </tr>
				</table>
			</center>
<?
}
?>