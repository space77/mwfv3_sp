<html>
<body>
<?php if($allowadd){ ?>
<center><font color="red"><b><?echo $lang['Filesizew'];?></b></font></center><br>
<form method="post" action="index.php?n=gallery&sub=wallp" enctype="multipart/form-data">
	<?php echo  $lang['Author'];?>&nbsp;<b><?echo $user['username']; ?></b><br>
        <?php echo  $lang['File'];?>&nbsp;<br>
       <input type="file" name="filename"><br> 
       <center><input type="submit" value="<?echo $lang['UWallp']; ?>" name="doadd"><br></center>
<form>
<?php }?>
</body>
</html>
