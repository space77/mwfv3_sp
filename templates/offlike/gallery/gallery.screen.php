<?php
/*
    $img=$_FILES["filename"]["name"];
    $comment=$message;
    $autor=$user['username'];  
    $date=date("Y-m-d");

$db = array(
	'host' => 'localhost',			// Хост
	'user' => 'root',				// Юзер
	'password' => '0m364nt5c',		// Пароль
	'db_realmd' => 'edb_realmd_10',	// Mangos db	
);
mysql_connect($db['host'], $db['user'], $db['password'])or die("cant connect to database");
@mysql_select_db($db['db_realmd'])or die("Не могу выбрать базу данных");
  if ($doadd=="") {
  } else {
     if($_FILES["filename"]["size"] > 1024*0.2*1024) {
     echo $lang['Filesizes'];
     exit; }
     if($_FILES["filename"]["type"]!="image/jpeg") {
     echo $lang['Filetype'];
     echo ("<br>"); }
     if(copy($_FILES["filename"]["tmp_name"],
     "./images/Screenshots/".$_FILES["filename"]["name"])) {
     mysql_query("INSERT INTO gallery set img='".$img."', comment='".$comment."', autor='".$autor."', date='".$date."'");
     } else {
     echo $lang['Uploaderror']; } }
mysql_close();
*/
?>

<?php if($allowview){ ?>
  <table border = 0 width=100%>
  <tr>
  <td >
    <?php if($allowadd){ ?>
    <img src="./templates/offlike/images/edit-button.gif"><a href="././index.php?n=gallery&sub=addgalscreen"><?echo $lang['Addimage'];?></a>
    <?php } ?>
  </td>
  <td align=right><?echo $lang['Totalingallery']." ".$total; ?></td></tr>
  </table>
  <style type = "text/css">
    td.serverStatus1 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
    td.serverStatus2 { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
    td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
  </style>
  
  <center>
  <table border=0>
  <tr>
  <?php foreach($query as $result){ ?>
    <TR>
    <TD ROWSPAN=3 align="center">
    
    <table style="margin: 7px;" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
    <td><img src="./templates/offlike/images/gallery/lt.png" class="png" style="width: 9px; height: 9px;" border="0" height="9" width="9"></td>
    <td background="./templates/offlike/images/gallery/_t.gif"><img src="/i/_.gif" height="1" width="1"></td>
    <td><img src="./templates/offlike/images/gallery/rt.png" class="png" style="width: 11px; height: 9px;" border="0" height="9" width="11"></td>
    </tr>
    <tr>
    <td background="./templates/offlike/images/gallery/_l.gif"><img src="/i/_.gif" height="1" width="1"></td>
    <td>
    <a style="cursor: pointer;" onclick="javascript:void(window.open('./images/Screenshots/<?php echo $result['img']; ?>'))" target="_blank"><img style="width: 235px; height: 175px;" alt="<?PHP echo $result['comment'];?>" src="./images/Screenshots/<?PHP echo $result['img'];?>" border="0"></a>
    </td>
    <td background="./templates/offlike/images/gallery/_r.gif"><img src="/i/_.gif" height="1" width="1"></td>
    </tr>
    <tr>
    <td><img src="./templates/offlike/images/gallery/lb.png" class="png" style="width: 9px; height: 12px;" border="0" height="12" width="9"></td>
    <td background="./templates/offlike/images/gallery/_b.gif"><img src="/i/_.gif" height="1" width="1"></td>
    <td><img src="./templates/offlike/images/gallery/rb.png" class="png" style="width: 11px; height: 12px;" border="0" height="12" width="11"></td>
    </tr>
    </tbody>
    </table>
    
    </TD>
    <td><?php echo  $lang['Comment']." ".$result['comment'];?></td>
    </TR><TR>
    <td><?php echo $lang['Author']." ".$result['autor'];?></td>
    </TR><TR>
    <td><?php echo $lang['Date']." ".$result['date'];?></td>
    </TR>
    <TR>
    <td colspan=2><?php echo "";?></td>
    </TR>
  <?php } ?>
  </tr>
  </table>
  </center>
<?php } ?>
