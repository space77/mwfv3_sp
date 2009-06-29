<table align="center" width="100%" style="font-size:0.8em;"><tr><td align="center">
<?php
if(empty($_REQUEST['key'])){
?>
    <form action="index.php?n=account&sub=restore" method="post">
        <div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
            <b>Login:</b> <input type="text" name="retr_login" size="26" maxlength="16" style="font-size:11px;"> 
            <br />
            <b>Email:</b> <input type="text" name="retr_email" size="26" maxlength="80" style="font-size:11px;"> 
            <br />
        </div>
        <div style="background:none;margin:4px;padding:6px 9px 6px 9px;text-align:right;width:70%;">
            <input type="submit" size="16" class="button" style="font-size:12px;" value="<?php echo $lang['doretrieve_pass'] ?>">
        </div>
    </form>
<?php
} 
?>                          
</td></tr></table>