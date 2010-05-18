<?php if($user['id']>0 && $profile){ ?>
<table align="center" width="100%" style="font-size:0.8em;"><tr><td align="center">
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <b><?php echo $lang['username'];?></b> <input type='text' size='40' value='<?php echo $profile['username'];?>' readonly>
    </div>
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
    <?php if((bool)$config['change_email']===true) { ?>
    <form method="post" action="index.php?n=account&sub=manage&action=changeemail">
        <b><?php echo $lang['newemail'];?></b> <input type='text' name='new_email' size='36' value='<?php echo $profile['email'];?>'>
        <input type="submit" value="<?php echo $lang['change_email'] ?>" class="button" style="font-size:11px;">
    </form>
    <?php }else{ ?>
        <b>Email</b> <input type="text" size="36" value="<?php echo $profile['email'];?>" readonly>
    <?php } ?>
    </div>
    <?php if((bool)$config['change_pass']===true) { ?>
    <form method="post" action="index.php?n=account&sub=manage&action=changepass">
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <b><?php echo $lang['newpass'];?></b> <input type="password" size="22" name="new_pass"></br>
        <b><?php echo $lang['cpass'];?></b> <input type="password" size="22" name="new_pass_confirm"></br></br>
        <input type="submit" value="Change password" class="button" style="font-size:11px;">
    </div>
    </form>
    <?php } ?>
    
    <?php if((bool)$config['used_userbar']===true) { ?>
    <form method="post" action="index.php?n=account&sub=manage&action=changeuserbar">
      <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
      <?php if($profile['userbar']) { ?>
        <b>Юзербар:</b><br> 
        <img src="<?php echo $profile['userbar'];?>" style="margin:1px;"> <br />
        <input type="hidden" name="userbarurl" value="<?php echo$profile['userbar'];?>">
        Удалить? <input type="checkbox" size="36" name="deleteuserbar" style="margin:1px;" value="0"> <br>
        <?php }else{ ?>
    
          <b>Адрес юзербара:</b> <input type="text" size="100" name="userbar" style="width:100%;" ><br />
          
        <?php }?>
        <input type="submit" value="Изменить" class="button" style="font-size:11px;">
    </div>
    </form>
    <?php } ?>
    
    <form method="post" action="index.php?n=account&sub=manage&action=change" enctype="multipart/form-data">
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <?php if((bool)$config['change_template']===true) { ?>
        <b><?php echo$lang['theme'];?></b>
        <select name="profile[theme]" style="margin:1px;">
            <?php foreach($templates as $template_id=>$template_s){ ?>
            <option value="<?php echo$template_id;?>"<?php if($profile['theme']==$template_id)echo' selected';?>><?php echo$template_s;?></value>
            <?php } ?>
        </select>  <br>
        <?php } ?>
        <b><?php echo $lang['hideemail'];?></b>
        <select name="profile[hideemail]" style="margin:1px;">
            <option value="0"<?php if($profile['hideemail']==0)echo' selected';?>><?php echo $lang['no'];?></value>
            <option value="1"<?php if($profile['hideemail']==1)echo' selected';?>><?php echo $lang['yes'];?></value>
        </select>  <br>
        <b><?php echo $lang['hideprofile'];?></b>
        <select name="profile[hideprofile]" style="margin:1px;">
            <option value="0"<?php if($profile['hideprofile']==0)echo' selected';?>><?php echo $lang['no'];?></value>
            <option value="1"<?php if($profile['hideprofile']==1)echo' selected';?>><?php echo $lang['yes'];?></value>
        </select>  <br>
        <b><?php echo $lang['gender'];?></b>
        <select name="profile[gender]">
            <option value="0"<?php if($profile['gender']==0)echo' selected';?>><?php echo $lang['notselected'];?></value>
            <option value="1"<?php if($profile['gender']==1)echo' selected';?>><?php echo $lang['male'];?></value>
            <option value="2"<?php if($profile['gender']==2)echo' selected';?>><?php echo $lang['female'];?></value>
        </select> <img src="<?php echo $templategenderimage[$profile['gender']];?>"> <br>
        <b><?php echo $lang['homepage'];?></b> <input name="profile[homepage]" type="text" size="36" style="margin:1px;" value="<?php echo$profile['homepage'];?>"> <br>
        <b><?php echo $lang['icq'];?></b> <input name="profile[icq]" type="text" size="36" style="margin:1px;" value="<?php echo$profile['icq'];?>"> <br>
        <b><?php echo $lang['wherefrom'];?></b> <input name="profile[location]" type="text" size="36" style="margin:1px;" value="<?php echo$profile['location'];?>"> <br>
    </div>
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <?php if($profile['avatar']) { ?>
        <b><?php echo $lang['avatar'];?></b> &nbsp;<br> <img src="<?php echo $config['avatar_path'];?><?php echo$profile['avatar'];?>" style="margin:1px;"> <br>
        <input type="hidden" name="avatarfile" value="<?php echo$profile['avatar'];?>">
        <?php echo $lang['delavatar'];?> <input type="checkbox" size="36" name="deleteavatar" style="margin:1px;" value="1"> <br>
        <?php }else{ ?>
        <?php echo $lang['maxavatarsize'];?>: <?php echo $config['max_avatar_file'];?> bytes, <?php echo $lang['maxavatarres'];?> <?php echo $config['max_avatar_size'];?> px.<br>
        <b><?php echo $lang['uploadavatar'];?></b> <input type="file" size="36" name="avatar" style="margin:1px;"> <br>
        <?php } ?>
    </div>
    <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
        <b><?php echo $lang['signature'];?></b> <br>
        <textarea name="profile[signature]" maxlength="255" rows="4" style="width:100%;"><?php echo $profile['signature'];?></textarea>
    </div>
    <div style="background:none;margin:4px;padding:6px 9px 0px 9px;text-align:right;width:70%;">
        <input type="reset" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['reset'];?>"> &nbsp;
        <input type="submit" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['dochange'];?>">
    </div>
    </form>
</td></tr></table>
<?php } ?>
