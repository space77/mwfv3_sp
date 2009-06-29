<style type = "text/css">
  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>
<center>

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
        <tr>
          <td class='rankingHeader' align='center'  nowrap='nowrap'>#</td>
          <td class='rankingHeader' align='center'  nowrap='nowrap'><?=$lang['b_usernameorip'];?>&nbsp;</td> 
          <td class='rankingHeader' align='center'  nowrap='nowrap'><?=$lang['b_bandate'];?>&nbsp;</td>
          <td class='rankingHeader' align='center'  nowrap='nowrap'><?=$lang['b_unbandate'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center'  nowrap='nowrap'><?=$lang['b_bannedby'];?>&nbsp;</td>
		      <td class='rankingHeader' align='center'  nowrap='nowrap'><?=$lang['b_banreason'];?>&nbsp;</td>
        </tr> 
        <tr>
            <td class='rankingHeader' align='center' colspan='6' nowrap='nowrap'><?=$lang['b_foraccounts'];?></td>
        </tr>     
        
        <?php
          if (count($res_info) > 0) {
            foreach($res_info as $res){     
        ?>
          <tr>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$res['number']; ?></b></td>
		        <td class="serverStatus<?=$res['res_color'] ?>" nowrap='nowrap'><b class="smallBold"><?=$res["username"]; ?></b></td>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['bandate']; ?></small></td>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['unbandate']; ?></small></td>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['bannedby']; ?></small></td>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center'><small style="color:rgb(35,67,3)"><?=$res['banreason']; ?></small></td>
          </tr>
        <?php }} else { ?>
           <tr>
            <td class="serverStatus<?=$res['res_color'] ?>" colspan='6' align='center'><b style='color: rgb(102, 13, 2);'><?=$lang['b_isempty'];?></b></td>
          </tr>
        <?php } ?>
        
        <tr>
            <td class='rankingHeader' align='center' colspan='6' nowrap='nowrap'><?=$lang['b_forips'];?></td>
        </tr>
        
        <?php
          if (count($res_info_ip) > 0) {
            foreach($res_info_ip as $res){     
        ?>
          <tr>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center'><b style='color: rgb(102, 13, 2);'><?=$res['number']; ?></b></td>
		        <td class="serverStatus<?=$res['res_color'] ?>" nowrap='nowrap'><b class="smallBold"><?=$res["ip"]; ?></b></td>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['bandate']; ?></small></td>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['unbandate']; ?></small></td>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center' nowrap='nowrap'><small style="color:rgb(35,67,3)"><?=$res['bannedby']; ?></small></td>
            <td class="serverStatus<?=$res['res_color'] ?>" align='center'><small style="color:rgb(35,67,3)"><?=$res['banreason']; ?></small></td>
          </tr>
        <?php }} else { ?>
          <tr>
            <td class="serverStatus<?=$res['res_color'] ?>" colspan='6' align='center'><b style='color: rgb(102, 13, 2);'><?=$lang['b_isempty'];?></b></td>
          </tr>
        <?php } ?>
                
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
</center>
