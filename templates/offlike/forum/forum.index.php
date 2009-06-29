<style media="screen" title="currentStyle" type="text/css">
    
</style>
<div class="postContainerPlain">
<div class="postBody">
<center>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
    <td width="12"><img src="<?php echo $config['template_href'];?>images/metalborder-top-left.gif" width="12" height="12"/></td>
    <td background="<?php echo $config['template_href'];?>images/metalborder-top.gif"/>
    <td width="12"><img src="<?php echo $config['template_href'];?>images/metalborder-top-right.gif" width="12" height="12"/></td>
</tr>
<tr>
    <td background="<?php echo $config['template_href'];?>images/metalborder-left.gif"/>
    <td>
<?php foreach($items as $catitem){ ?>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="forum_category">
    <thead>
        <tr><td colspan="4"><h3><?php echo $catitem[0]['cat_name'];?></h3></td></tr>
    </thead>
    <tbody>
<?php foreach($catitem as $forumitem){ ?>
        <tr>
            <td class="col1"><img src="<?php echo $config['template_href'];?>images/<?php echo ($forumitem['closed']==1?'lock-icon.gif':'news-community.gif');?>"></td>
            <td>
                <a class="title" href="<?php echo $forumitem['linktothis'];?>"><?php echo $forumitem['forum_name'];?></a>
                <?php echo ($forumitem['hidden']==1?$lang['hidden']:'');?>
                <?php if($forumitem['isnew']){ ?><font color="red"><?php echo$lang['newmessages'];?></font><?php } ?>
                <span class="desc"><?php echo $forumitem['forum_desc'];?></span>
            </td>
            <td rowspan="3" class="col3"><span><?php echo $forumitem['num_topics'];?></span> <?php echo declension($forumitem['num_topics'],array($lang['l_theme1'],$lang['l_theme2'],$lang['l_theme3'])); ?></td>
            <td rowspan="3" class="col4"><span><?php echo $forumitem['num_posts'];?></span> <?php echo declension($forumitem['num_posts'],array($lang['l_post1'],$lang['l_post2'],$lang['l_post3'])); ?></td>
        </tr>
        <tr>
            <td class="col1"><img src="<?php echo $config['template_href'];?>images/icons/time.gif"></td>
            <td><?php echo$lang['lastreplyin'];?> <a href="<?php echo $forumitem['linktolastpost'];?>" title="<?php echo $forumitem['topic_name'];?>"> <?php echo $forumitem['topic_name'];?></a></td>
        </tr>
        <tr>
            <td class="col1"><img src="<?php echo $config['template_href'];?>images/icons/user_comment.gif"></td>
            <td><?php echo$lang['from'];?> <a href="<?php echo $forumitem['linktoprofile'];?>"> <?php echo $forumitem['last_poster'];?></a> <?php echo $forumitem['last_post'];?></td>
        </tr>
<?php } ?>
    </tbody>
    </table>
<?php } ?>
    </td>
    <td background="<?php echo $config['template_href'];?>images/metalborder-right.gif"/>
</tr>
<tr>
    <td><img src="<?php echo $config['template_href'];?>images/metalborder-bot-left.gif" width="12" height="11"/></td>
    <td background="<?php echo $config['template_href'];?>images/metalborder-bot.gif"/>
    <td><img src="<?php echo $config['template_href'];?>images/metalborder-bot-right.gif" width="12" height="11"/></td>
</tr>
</table>
</center>
</div>
</div>