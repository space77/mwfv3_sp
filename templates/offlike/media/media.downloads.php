<?Php


error_reporting(0);
if (!isset($p))  
{
$d='1';  
}
else
{
$d = $p;
}
$papka = './uploads';


if ($handle = opendir("$papka")) {

while (false !== ($f = readdir($handle))) {
if ($f != "." && $f != ".." && $f != ".htaccess" && $f != "index.php"  && $f != "Thumbs.db"){
if(!ereg("(\.)(jpg$)", $f) && !ereg("(\.)(gif$)", $f) && !ereg("(\.)(png$)", $f) && !ereg("(\.)(bmp$)", $f) && !ereg("(\.)(JPG$)", $f) && !ereg("(\.)(GIF$)", $f) && !ereg("(\.)(BMP$)", $f) && !ereg("(\.)(PNG$)", $f)){
   $file[] = $f;}
  
}

}
closedir($handle);
}


$count = count($file);

############
 foreach($file as $filename)
  {
    
    $arr = file($filename);
    $total = count($arr);
    unset($arr);
    $filecount[$filename] = $total;
    
  }
  arsort($filecount);
//////////
 

######
$f = '10';
$obsum = $d * $f;
$nasum = $obsum - $f;


?>
<style type = "text/css">
  a.server { border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; font-weight: bold; }
  td.serverStatus1 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; }
  td.serverStatus2 { font-size: 0.8em; border-style: solid; border-width: 0px 1px 1px 0px; border-color: #D8BF95; background-color: #C3AD89; }
  td.rankingHeader { color: #C7C7C7; font-size: 10pt; font-family: arial,helvetica,sans-serif; font-weight: bold; background-color: #2E2D2B; border-style: solid; border-width: 1px; border-color: #5D5D5D #5D5D5D #1E1D1C #1E1D1C; padding: 3px;}
</style>

<center>

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
  <tbody>
  <tr>
    <td width='12'><img src='templates/offlike/images/metalborder-top-left.gif' height='12' width='12'></td>
    <td background='templates/offlike/images/metalborder-top.gif'></td>
    <td width='12'><img src='templates/offlike/images/metalborder-top-right.gif' height='12' width='12'></td>
  </tr>
  <tr>
    <td background='templates/offlike/images/metalborder-left.gif'></td>
    <td>
      <table cellpadding='3' cellspacing='0' width='100%'>
        <tbody>
<tr> 
           
          <td class='rankingHeader' align='center' colspan='3' nowrap='nowrap'>Файлы (всего-<? echo $count; ?>)</td>
                   
        </tr>   

         <tr>
          <td class='rankingHeader' align='center' nowrap='nowrap'>№</td>
          <td class='rankingHeader' align='center' nowrap='nowrap'>Файл</td>
          <td class='rankingHeader' align='center' nowrap='nowrap'>Размер</td>
        </tr>
<?php

/////////// 
  foreach($filecount as $name => $total)
  {
     $i++;
     if($i <= $nasum) continue;
     if($i > $obsum) break;


   $filesize = filesize($papka . "/" . $name);

    if ($filesize < 1024) $filesize = $file_size." байт";
    if ($filesize >= 1024) $filesize = round (($filesize/1024), 1)." Кб";
    if ($filesize >= 1024) $filesize = round (($filesize/1024), 1)." Мб";


if($i%2==0){

echo "<tr><td class=\"serverStatus2\" align='center'>";
     echo "<b style='color: rgb(102, 13, 2);'>$i</b></td><td class=\"serverStatus2\"><a href=\"$papka/$name\"><b class='smallBold' style='color: rgb(35, 67, 3);'>$name</b></a></td><td class=\"serverStatus2\" align='center'><b style='color: rgb(102, 13, 2);'>$filesize</b><br>";
echo "</td></tr>";
}else{

echo "<tr><td class=\"serverStatus1\" align='center'>";
     echo "<b style='color: rgb(102, 13, 2);'>$i</b></td><td class=\"serverStatus1\"><a href=\"$papka/$name\"><b class='smallBold' style='color: rgb(35, 67, 3);'>$name</b></a></td><td class=\"serverStatus1\" align='center'><b style='color: rgb(102, 13, 2);'>$filesize</b><br>";
echo "</td></tr>";

}



  }

print "</tbody>
      </table>
    </td>
    <td background='templates/offlike/images/metalborder-right.gif'></td>
  </tr>
  <tr>
    <td><img src='templates/offlike/images/metalborder-bot-left.gif' height='11' width='12'></td>
    <td background='templates/offlike/images/metalborder-bot.gif'></td>
    <td><img src='templates/offlike/images/metalborder-bot-right.gif' height='11' width='12'></td>
  </tr>
  </tbody>
</table>";
print'<table><tr>';
if($d == '1') 
{

}
else
{
$z = $d-1;
print'<td height="26" width="137" background="./images/previous.jpg" align="center"><a href="index.php?n=media&sub=downloads&p='.$z.'">Назад</a></td>'; 

}
if($i < $obsum)
{

}
else
{
$d = $d+1;
print'<td height="26" width="137" background="./images/next.jpg" align="center"><a 
href="index.php?n=media&sub=downloads&p='.$d.'">Далее</a></td>';
}
print '</tr></table></center>';
?>