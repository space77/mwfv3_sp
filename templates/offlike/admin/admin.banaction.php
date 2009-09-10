<style type = "text/css">
  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>
<center>

<?php if ($user['gmlevel']==0) {} else {
if(empty($_GET['realm'])){ ?>
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
                                if (count($realm_list)!=0)
                                  foreach($realm_list as $id=>$name){echo "<li><a href=\"index.php?n=admin&sub=banaction&realm=$id\"><b>$name</b></a></li> \n";}
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
<?php }elseif($_GET['realm']){ ?>
<center>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tbody>
<tr>
  <td colspan='2'>
<div style='cursor: auto;' id='dataElement'>
<span>
<?if (!$error){ ?>
<div class="news-expand">
  <div class="news-item">
    <blockquote>
      <dl>
        <dd>
          <ul>
            <li>
            <div class="blog-post"> 
              <form action="core/mangoscmd.pl" method="post">
              <div>
                <table>
                  <tr>
                    <td>
                      Имя вашего аккаунта:
                    </td>
                    <td>
                      <input name="myuser" type="text" value="<?=$myuser?>"/>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>
                      Пароль аккаунта:
                    </td>
                    <td>
                      <input name="mypass" type="password" value="<?=$mypass?>"/>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td>
                      Выберите комманду:
                    </td>
                    <td>
                      <select name="action">
                        <option value="ban" <?=(($action=='ban') ? 'selected="selected"':'')?> >ban</option>
                        <option value="unban"  <?=(($action=='unban') ? 'selected="selected"':'')?> >unban</option>
                      </select>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>
                      Выберите тип:
                    </td>
                    <td>
                      <select name="type">
                        <option value="character" <?=(($type=='character') ? 'selected="selected"':'')?> >character</option>
                        <option value="account" <?=(($type=='account') ? 'selected="selected"':'')?> >account</option>
                        <option value="ip" <?=(($type=='ip') ? 'selected="selected"':'')?> >ip</option>
                      </select>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>
                      Персонаж, аккаунт, адрес:
                    </td>
                    <td>
                      <input name="typeval" type="text" value="<?=$typeval?>"/>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>
                      Введите причину:
                    </td>
                    <td>
                      <input name="reason" type="text" value="<?=$reason?>"/>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>
                      Срок:
                    </td>
                    <td>
                      <input name="bantime" type="text" value="<?=$bantime?>"/>
                    </td>
                  </tr>
                  
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td colspan="2">
                      <input name="raport" type="hidden" value="<?=$raport?>" />
                      <input name="address" type="hidden" value="<?=$address?>" />
                      <input name="rurl" type="hidden" value="<?=$rurl?>" />
                      <input type="submit" name="submit" value="Выполнить" />
                  </td>
                </tr>
              </table>
            </div>
            </form>
            </div></li>
          </ul>
        </dd>
      </dl>
      </blockquote>
  </div>
</div>
<? } ?>

</span>
</div>
</td>
</tr>
</tbody></table>
</center>
<?php }} ?>
</center>
