<?php
		$connection = mysql_connect($config['db_host'], $config['db_username'], $config['db_password'])
  			or die("No connection to the database!");

		mysql_select_db($config['db_name'], $connection);
   
		$cat_id = 'SELECT category_id FROM site_category WHERE category = "screenshots"';
		$result = mysql_query($cat_id, $connection);

		while($zeile = mysql_fetch_array($result))
		{
			$category = $zeile['category_id'];
		}
		
		$screenshots = "SELECT filename FROM site_upload WHERE category_ref = ".$category;

		$result = mysql_query($screenshots, $connection);

		$i = 1;
		while($zeile = mysql_fetch_array($result))
		{
			$screenshot[$i] = $zeile['filename'];
			$i++;
		}

		$image = $_GET['i'];
		if ($image == "")
			$image = 1;
		$previmg = $image - 1;
		$nextimg = $image + 1;
		$user = $user['id'];

		$vote = 'SELECT count(*) FROM screen_vote WHERE account_ref = '.$user;
		$result = mysql_query($vote, $connection);
		$count = 0;
		while($zeile = mysql_fetch_array($result))
		{
			$count = $zeile['count(*)'];
		}
	
		mysql_close($connection);

		if ($count == 0)
		{
?>
		</br>
		<form action="vote.php" method="POST">
		<input type="hidden" name="item" <?php echo "value=\"$screenshot[$image]\""; ?>>
		<input type="hidden" name="user" <?php echo "value=\"$user\""; ?>>
		<center><input type="submit" value="<?php echo $lang['vote_image'];?>" ></center>	
	</form>
<?php 
} 
else
	echo "</br>";
?>
<center>	<table cellspacing = "0" cellpadding = "0" border = "0">
	<tr>
		<td colspan = "3">
		
			<table cellspacing = "0" cellpadding = "0" border = "0" background = "./templates/offlike/images/ss-border-top-bg.gif" width = "100%">
			<tr>

				<td><img src = "./templates/offlike/images/ss-border-top-left.gif" width = "113" height = "14"></td>
				<td align = "right"><img src = "./templates/offlike/images/ss-border-top-right.gif" width = "113" height = "14"></td>
			</tr>

			</table>
		
		</td>
	</tr>
	<tr>
		<td background = "./templates/offlike/images/ss-border-left.gif"><img src = "./templates/offlike/images/pixel.gif" width = "21" height = "1"></td>

		<td width = "650" height="488" align=center valign=middle>
		<a href="./<?php echo $screenshot[$image]; ?>" target="_blank"><img src = "./<?php echo $screenshot[$image]; ?>" width = "650" height = "488">
		</td>
		<td background = "./templates/offlike/images/ss-border-right.gif"><img src = "./templates/offlike/images/pixel.gif" width = "21" height = "1"></td>
	</tr>
	<tr>
		<td colspan = "3">
		
			<table cellspacing = "0" cellpadding = "0" border = "0" background = "./templates/offlike/images/ss-border-bot-bg.gif" width = "100%">

			<tr>

				<td valign = "top">
					<table cellspacing = "0" cellpadding = "0" border = "0" background = "./templates/offlike/images/ss-border-bot-left.gif">
					<tr>
						<td rowspan = "3"><img src = "./templates/offlike/images/pixel.gif" width = "40" height = "58" border = "0"></td>
						<td height = "17"><img src = "./templates/offlike/images/pixel.gif" width = "148" height = "17" border = "0"></td>
					</tr>
					<tr>
						<?php if ($image == 1) { } else { ?>
						<td><span><a href = "index.php?n=media&sub=screenshots&i=<?php echo $previmg;?>">Previous Image</a></span></td>
						<?php }?>
					</tr>
					<tr>
						<td height = "11"><img src = "./templates/offlike/images/pixel.gif" width = "58" height = "11" border = "0"></td>
					</tr>
					</table>
				</td>
				<td align = "center"><span><b class = "white"><br><br></b><b>Image 1 of 2</b></span></td>
				<td align = "right" valign = "top">

					
	<table cellspacing = "0" cellpadding = "0" border = "0" background = "./templates/offlike/images/ss-border-bot-right.gif">
					<tr>
						<td height = 17><img src = "./templates/offlike/images/pixel.gif" width = "148" height = "17" border = "0"></td>
						<td rowspan = "3"><img src = "./templates/offlike/images/pixel.gif" width = "40" height = "58" border = "0"></td>
					</tr>
					<tr>
						<?php if ($image == $i-1) { } else { ?>
						<td align = "right"><span><a href = "index.php?n=media&sub=screenshots&i=<?php echo $nextimg;?>">Next Image</a></span></td>
						<?php }?>
					</tr>

					<tr>
						<td height = "11"><img src = "./templates/offlike/images/pixel.gif" width = "58" height = "11" border = "0"></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		
		</td>

	</tr>
	</table><br>