<html>
<body>
<?php if($allowadd){ ?>	
<center><font color="red"><b><?echo $lang['Filesizes'];?></b></font></center><br>
<form method="post" action="index.php?n=gallery&sub=screen" enctype="multipart/form-data">
	<?php echo  $lang['Author'];?>&nbsp;<b><?echo $user['username']; ?></b><br>
        <?php echo  $lang['Comment'];?>&nbsp;<br>
	<textarea name="message" cols="5" rows="5" id="textarea" style="width: 95%; height: 70px;"></textarea><br>
	<?php echo  $lang['File'];?>&nbsp;<br>
       <input type="file" name="filename"><br> 
       <center><input type="submit" value="<?echo $lang['UScreen']; ?>" name="doadd"><br></center>
<form>
<?php } ?>
</body>
</html>
