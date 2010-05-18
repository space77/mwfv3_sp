<center>
<?php
		$connection = mysql_connect($config['db_host'], $config['db_username'], $config['db_password'])
  			or die("No connection to the database!");

		mysql_select_db($config['db_name'], $connection);

	$sql = "SELECT count(*) FROM site_category WHERE min_g_id <= ".$user['g_id'];
	$result = mysql_query($sql, $connection);

	while($zeile = mysql_fetch_array($result))
	{
		$z = $zeile['count(*)'];
	}
	if ($z == 0)
	{
		echo '<div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:center;width:70%;">';
		echo $lang['up_notallowed'];
		echo '</div>';
	}
	else
	{
?>
<div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:center;width:70%;">

<?php
	if ( $user['g_id'] != '5'){
?>
<form enctype="multipart/form-data" action="./components/Media/uploader.php" method="POST">
Choose the category: </br>
<select name="category" size="1">
<?php
	$sql = "SELECT category_id FROM site_category WHERE min_g_id <= ".$user['g_id'];
	$result = mysql_query($sql, $connection);
	
	while($zeile = mysql_fetch_array($result))
	{
		$cat = $zeile['category_id'];

		$sql2 = "SELECT category FROM site_category WHERE category_id = ".$cat;

		$result2 = mysql_query($sql2, $connection);

		while($zeile2 = mysql_fetch_array($result2))
		{
			echo "<option>".$zeile2['category']."</option>";
		}
	}

      mysql_close($connection);
?>
</select> </br></br>

Choose a file to upload: </br>
<input name="uploadedfile" type="file" /></br></br>
<center><input type="submit" value="Upload File" /></center>
</form>

<?php
	}
	else
	{
		echo $lang['up_notallowed']." ".$lang['up_banned'];
	}
?>

</div>
<?php }?>
</center>
