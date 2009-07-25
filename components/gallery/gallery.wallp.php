<?php
if(INCLUDED!==true)exit;
@include ("core/cache/links_cache.php");

$pathway_info[] = array('title'=>$lang['GallWalp'],'link'=>'');

$lvladd = $links_conf["lvladdgalwallp"];
$allowadd = ($user['g_id'] >= $lvladd)? true : false;

$lvlview = $links_conf["lvlwallp"];
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
    
    $isok = true;
    if($_FILES["filename"]["size"] > 1024*4*1024) {
      output_message('alert','<b>'.$lang['Filesizew'].'</b><meta http-equiv=refresh content="2;url=index.php?n=gallery&sub=wallp">');
      $isok = false;
    }
    if($_FILES["filename"]["type"]!="image/jpeg") {
      output_message('alert','<b>'.$lang['Filetype'].'</b><meta http-equiv=refresh content="2;url=index.php?n=gallery&sub=wallp">');
      $isok = false;
    }
    if ($isok) {
      if(copy($_FILES["filename"]["tmp_name"], $config['wallpapers_path'].$img)) {
        $DB->query("INSERT INTO `gallery_wallp` SET `img`='".$img."', `orgfname`='".$orgfname."', `autor`='".$autor."', `autorid`='".$autorid."', `date`='".$date."'");
      } else {
        output_message('alert','<b>'.$lang['Uploaderror'].'</b><meta http-equiv=refresh content="2;url=index.php?n=gallery&sub=wallp">');
        $isok = false;
      }
    } 
  }
  
  $query=$DB->select("SELECT * FROM `gallery_wallp`");
  
  function concatpath($var) {
    global $config;
    $var['img'] = $config['wallpapers_path'].$var['img'];
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
