<table border="0" cellspacing="1" cellpadding="4" align="center" width="100%" class="bordercolor">
  <tbody>
    <tr>
      <td colspan="8" class="titlebg">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr>
            <td><?php echo $lang['post_pages'];?>: <?php echo $pages_str; ?> <a href="#down"><img src="templates/default/images/icons/go_down.gif" alt="<?php echo $lang['down'];?>" align="top" border="0"></a></td>
            <td align="right">
              <a href="index.php?n=account&sub=userlist"><?php echo $lang['all'];?></a> |
              <a href="index.php?n=account&sub=userlist&char=a">A</a>
              <a href="index.php?n=account&sub=userlist&char=b">B</a>
              <a href="index.php?n=account&sub=userlist&char=c">C</a>
              <a href="index.php?n=account&sub=userlist&char=d">D</a>
              <a href="index.php?n=account&sub=userlist&char=e">E</a>
              <a href="index.php?n=account&sub=userlist&char=f">F</a>
              <a href="index.php?n=account&sub=userlist&char=g">G</a>
              <a href="index.php?n=account&sub=userlist&char=h">H</a>
              <a href="index.php?n=account&sub=userlist&char=i">I</a>
              <a href="index.php?n=account&sub=userlist&char=j">J</a>
              <a href="index.php?n=account&sub=userlist&char=k">K</a>
              <a href="index.php?n=account&sub=userlist&char=l">L</a>
              <a href="index.php?n=account&sub=userlist&char=m">M</a>
              <a href="index.php?n=account&sub=userlist&char=n">N</a>
              <a href="index.php?n=account&sub=userlist&char=o">O</a>
              <a href="index.php?n=account&sub=userlist&char=p">P</a>
              <a href="index.php?n=account&sub=userlist&char=q">Q</a>
              <a href="index.php?n=account&sub=userlist&char=r">R</a>
              <a href="index.php?n=account&sub=userlist&char=s">S</a>
              <a href="index.php?n=account&sub=userlist&char=t">T</a>
              <a href="index.php?n=account&sub=userlist&char=u">U</a>
              <a href="index.php?n=account&sub=userlist&char=v">V</a>
              <a href="index.php?n=account&sub=userlist&char=w">W</a>
              <a href="index.php?n=account&sub=userlist&char=x">X</a>
              <a href="index.php?n=account&sub=userlist&char=y">Y</a>
              <a href="index.php?n=account&sub=userlist&char=z">Z</a>
            </td>
          </tr>
        </tbody></table>
      </td>
    </tr>
    <tr class="catbg3">
      <td width="20"> </td>
      <td style="width: auto;" nowrap="nowrap"><?php echo $lang['user_name'];$?></td>
      <td width="25">Email</td>
      <td width="25"><?php echo $lang['homepage'];?></td>
      <td width="25">ICQ</td>
      <td width="125"><?php echo $lang['date_reg'];?></td>
      <td width="35"><?php echo $lang['messages'];?></td>
    </tr>
    <?php foreach($items as $item){ ?>
    <tr style="text-align: center;">
      <td class="windowbg2">
        <a href="index.php?n=account&sub=pms&action=add&to=<?php echo $item['username']; ?>" title="<?php echo $lang['personal_message'];?>"><img src="templates/default/images/icons/im_on.gif" alt="<?php echo $lang['pers_mess'];?>" align="middle"></a>
      </td>
      <td class="windowbg" align="left"><a href="index.php?n=account&sub=view&action=find&name=<?php echo $item['username']; ?>" title="<?php echo $lang['view_profile'];?> <?php echo $item['username']; ?>"><?php echo $item['username']; ?></a></td>
      <td class="windowbg2"><?php if($item['email_setting']!=1){ ?><a href="mailto:<?php echo $item['email']; ?>"><img src="templates/default/images/icons/email_sm.gif" alt="[Email]" title="Email" border="0" /></a><?php } ?></td>
      <td class="windowbg"><?php if($item['homepage'] && $item['homepage']!='http://'){ ?><a href="<?php echo $item['homepage']; ?>" target="_blank"><img src="templates/default/images/icons/weblink.png" alt="WWW" border="0" /></a><?php } ?></td>
      <td class="windowbg2"><?php echo $item['icq']; ?></td>
      <td class="windowbg" align="left"><?php echo $item['registered']; ?></td>
      <td class="windowbg2" width="35"><?php echo $item['forums_posts']; ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td class="titlebg" colspan="8"><?php echo $lang['post_pages'];?>: <?php echo $pages_str; ?>  <a href="#up"><img src="templates/default/images/icons/go_up.gif" alt="<?php echo $lang['up'];?>" align="top" border="0"></a></td>
    </tr>
  </tbody>
</table>