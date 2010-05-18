<div class="sections single_col">
<?php if($user['id']>0 && ($_GET['action']=='newtopic' || $_GET['action']=='newpost' || $_GET['action']=='edittopic' || $_GET['action']=='editpost')){ ?>
  <script type="text/javascript" src="js/compressed/behaviour.js"></script>
    <script type="text/javascript" src="js/core.js"></script>
    <script type="text/javascript" src="<?php echo$config['template_href'];?>js/template_rules.js"></script>
    <script language='JavaScript' src='core/ajax_lib/Js.js'></script>
  <script language='Javascript'>
  <!--
  var toarea;
  function mypreview(el1, el2){
    var query = document.getElementById(el2).value;
    var req = new JsHttpRequest();
      req.onreadystatechange = function() {
        if (req.readyState == 4) {
          document.getElementById(el1).innerHTML = req.responseText;
        }
      }
    req.caching = false;
    req.open('POST', '<?php echo $config['site_href'];?>index.php?n=ajax&sub=preview&nobody=1&ajaxon=1', true);
    req.send({ text: query });
  }
  // -->
  </script>

<? if (!$not_allow) { ?>
<hr class="hidden" />
<div id="write_form" class="subsections">
<h2><?php echo current(end($pathway_info));?></h2>

<form class="clearfix" method="post" action="index.php?n=forum&sub=post&action=do<?php echo $_GET['action'];?>&f=<?php echo $_GETVARS['f'];?>&t=<?php echo $_GETVARS['t'];?>&post=<?php echo $_GETVARS['post'];?>" enctype="multipart/form-data">
        
        <?php if($_GET['action']=='newtopic' || ($_GET['action']=='edittopic' && $user['g_forum_moderate']==1)){ ?>
    <p>
        <label for="title"><b><?php echo $lang['l_subject'];?> (max 80):</b><br></label>
        <input name="subject" type="text" id="title" size="40" maxlength="80" class="input_text input_large" value="<?php echo $content['subject'];?>" />
        </p>
    <?php } ?>
    <?php write_form_tool(); ?>
        <div id="input_block">
            <label for="input_comment">
            <textarea id="input_comment" name="text"><?php echo$content['text'];?></textarea>
            </label>
            <input value="<?php echo $lang['editor_preview'];?>" type="button" id="preview_do">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="reset" value="<?php echo $lang['editor_clear'];?>">
        </div>
        <div id="preview_block" style="display: none;background:none;">
            <div class="editor" id="input_preview"></div>
            <input id="preview_back" value="<?php echo $lang['editor_backtoedit'];?>" type="button">
        </div>
        <input type="submit" value="<?php echo $lang['editor_send'];?>" class="input_btn_big" />
</form>
</div>
<?php }elseif($_GET['action']=='movetopic' && $user['group']>=1){ ?>
  
<?php } ?>
</div>
<? } ?>
