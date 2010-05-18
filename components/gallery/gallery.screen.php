<?php
if(INCLUDED!==true)exit;
@include ("core/cache/links_cache.php");

$pathway_info[] = array('title'=>$lang['GallScreen'],'link'=>'');

$lvladd = $links_conf["lvladdgalscreen"];
$allowadd = ($user['g_id'] >= $lvladd)? true : false;

$lvlview = $links_conf["lvlscreen"];
$allowview = ($user['g_id'] >= $lvlview)? true : false;

if (!$allowview) {$allowadd=false;};

if (!$allowview){
  output_message('alert','<b>'.$lang['youhavenorights'].'</b><meta http-equiv=refresh content="2;url=index.php">');
}else{
  $doadd=$_POST["doadd"];
  if ($allowadd && ($doadd!="")){
    $orgfname=$_FILES["filename"]["name"];
    $autor=$user['username'];
    $autorid=$user['id'];  
    $date=date("Y-m-d");
    $path_parts=pathinfo($orgfname);
    $img = date(YmdHis).sprintf("%04d",$user['id']).".".$path_parts['extension'];
    $comment=$_POST["message"];
    
    $isok = true;
    if($_FILES["filename"]["size"] > 1024*1*1024) {
      output_message('alert','<b>'.$lang['Filesizes'].'</b><meta http-equiv=refresh content="2;url=index.php?n=gallery&sub=screen">');
      $isok = false;
    }
    if($_FILES["filename"]["type"]!="image/jpeg") {
      output_message('alert','<b>'.$lang['Filetype'].'</b><meta http-equiv=refresh content="2;url=index.php?n=gallery&sub=screen">');
      $isok = false;
    }
    if ($isok) {
      if(copy($_FILES["filename"]["tmp_name"], $config['screenshots_path'].$img)) {
        $DB->query("INSERT INTO `gallery_scr` SET `img`='".$img."', `orgfname`='".$orgfname."', comment='".$comment."', `autor`='".$autor."', `autorid`='".$autorid."', `date`='".$date."'");
      } else {
        output_message('alert','<b>'.$lang['Uploaderror'].'</b><meta http-equiv=refresh content="2;url=index.php?n=gallery&sub=screen">');
        $isok = false;
      }
    } 
  }
  
  $query=$DB->select("SELECT * FROM `gallery_scr`");
  
  function concatpath($var) {
    global $config;
    $var['img'] = $config['screenshots_path'].$var['img'];
    return $var;
  }
  
  function checkfile($var) {
    return (file_exists($var['img']));
  }
  
  $query = array_map("concatpath", $query);
  $query = array_filter ($query, "checkfile");
  $total=count($query);
}
?>
