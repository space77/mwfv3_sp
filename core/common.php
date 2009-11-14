<?php
if(!function_exists('file_put_contents')){
    function file_put_contents($file,$data)
    {
    	$handle = fopen($file, "w+");
        if(!$handle){ 
            return false; 
        }else{
            fwrite($handle, $data);
            fclose($handle);
            return true;
        }
    }
}
function output_message($type,$text,$file='',$line=''){
    global $messages;
    if($file)$text .= "\n<br>in file: $file";
    if($line)$text .= "\n<br>on line: $line";
    $messages .= "\n<div class=\"".$type."_box\">$text</div> \n";
}
function redirect($linkto,$type=0,$wait_sec=0){
    if($linkto){
        if($type==0){
            global $redirect;
            $redirect = '<meta http-equiv=refresh content="'.$wait_sec.';url='.$linkto.'">';
        }else{
            header("location:".$linkto);
            exit('redirecting to: '.$linkto);
        }
    }
}

function loadSettings(){
    global $config, $DB;
    if(file_exists('core/cache/config_cache.php')){
        require_once('core/cache/config_cache.php');
    }else{
        $rows = $DB->select("SELECT * FROM site_settings");
        foreach($rows as $r){
            settype($r['value'],$r['type']);
            $config[$r['key']] = $r['value'];
        }
    }
}
function loadLanguages(){
    global $config;
    global $languages;
    global $lang;
    $languages = array();
    $lang = array();
    if ($handle = opendir('lang/')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") {
                $tmp = explode('.',$file);
                if($tmp[2]=='lang')$languages[$tmp[0]] = $tmp[1];
            }
        }
        closedir($handle);
        $langfile = @file_get_contents('lang/'.$config['default_lang'].'.'.$languages[$config['default_lang']].'.lang');
        $langfile = str_replace("\n",'',$langfile);
        $langfile = str_replace("\r",'',$langfile);
        $langfile = explode('|=|',$langfile);
        foreach($langfile as $langstr){
            $langstra = explode(' :=: ',$langstr);
            if(isset($langstra[1]))$lang[$langstra[0]] = $langstra[1];
        }
        if ($config['lang'] != $config['default_lang']) {
            $langfile = @file_get_contents('lang/'.$config['lang'].'.'.$languages[$config['lang']].'.lang');
            $langfile = str_replace("\n",'',$langfile);
            $langfile = str_replace("\r",'',$langfile);
            $langfile = explode('|=|',$langfile);
            foreach($langfile as $langstr){
                $langstra = explode(' :=: ',$langstr);
                if(isset($langstra[1]))$lang[$langstra[0]] = $langstra[1];
            }
        }
    }
    
}
function Lang($var){
    global $lang;
    echo $lang[$var];
    return $lang[$var];
}
function update_settings($key,$val){
    global $DB;
    $DB->query("UPDATE site_settings SET `value`=? WHERE `key`=? LIMIT 1",$val,$key);
}
function load_smiles($dir='images/smiles/'){
    $res = array();
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") {
                $res[] = $file;
            }
        }
        closedir($handle);
    }
    return $res;
}
function send_email($to_email,$to_name,$theme,$text_text,$text_html=''){
    global $config;
    if(!$config['smtp_adress']){
        output_message('alert','Set SMTP settings in config !');
        return false;
    }
    if(!$to_email){
        output_message('alert','Field "to" is empty.');
        return false;
    }
    set_time_limit(300);
    require_once 'core/mail/smtp.php';
    $mail = new SMTP;
    $mail->Delivery('relay');
    $mail->Relay($config['smtp_adress'],$config['smtp_username'],$config['smtp_password']);
    $mail->From($config['site_email'], $config['base_href']);
    $mail->AddTo($to_email, $to_name);
    $mail->Text($text_text);
    if($text_html)$mail->Html($text_html);
    $sent = $mail->Send($theme);
    return $sent;
}
function quote_smart($value){
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    if (!is_numeric($value)) {
        $value = mysql_real_escape_string($value);
    }
    return $value;
}
function my_preview($text,$userlevel=0){
    if($userlevel<1){$text = htmlspecialchars($text);if (get_magic_quotes_gpc()){$text = stripslashes($text);} }
    $text = nl2br($text);
    $text = preg_replace("/\[b\](.*?)\[\/b\]/s","<b>$1</b>",$text);
    $text = preg_replace("/\[i\](.*?)\[\/i\]/s","<i>$1</i>",$text);
    $text = preg_replace("/\[u\](.*?)\[\/u\]/s","<u>$1</u>",$text);
    $text = preg_replace("/\[s\](.*?)\[\/s\]/s","<s>$1</s>",$text);
    $text = preg_replace("/\[hr\]/s","<hr>",$text);
    $text = preg_replace("/\[code\](.*?)\[\/code\]/s","<code>$1</code>",$text);
    //$text = preg_replace("/\[blockquote\](.*?)\[\/blockquote\]/s","<blockquote>$1</blockquote>",$text);
    if (strpos($text, 'blockquote') !== false)
    {
        if(substr_count($text, '[blockquote') == substr_count($text, '[/blockquote]')){
            $text = str_replace('[blockquote]', '<blockquote><div>', $text);
            $text = preg_replace('#\[blockquote=(&quot;|"|\'|)(.*)\\1\]#sU', '<blockquote><span class="bhead">Quote: $2</span><div>', $text);
            $text = preg_replace('#\[\/blockquote\]\s*#', '</div></blockquote>', $text);
        }
    }
    // Blizz quote <small><hr color="#9e9e9e" noshade="noshade" size="1"><small class="white">Q u o t e:</small><br>Text<hr color="#9e9e9e" noshade="noshade" size="1"></small>
    $text = preg_replace("/\[img\](.*?)\[\/img\]/s","<img src=\"$1\" align=\"absmiddle\">",$text);
    $text = preg_replace("/\[attach=(\d+)\]/se","check_attach('\\1')",$text);
    $text = preg_replace("/\[url=(.*?)\](.*?)\[\/url\]/s","<a href=\"$1\" target=\"_blank\">$2</a>",$text);
    $text = preg_replace("/\[size=(.*?)\](.*?)\[\/size\]/s","<font class='$1'>$2</font>",$text);
    $text = preg_replace("/\[align=(.*?)\](.*?)\[\/align\]/s","<p align='$1'>$2</p>",$text);
    $text = preg_replace("/\[color=(.*?)\](.*?)\[\/color\]/s","<font color=\"$1\">$2</font>",$text);
    $text = preg_replace("/[^\'\"\=\]\[<>\w]([\w]+:\/\/[^\n\r\t\s\[\]\>\<\'\"]+)/s"," <a href=\"$1\" target=\"_blank\">$1</a>",$text);
    return $text;
}
function my_previewreverse($text){
    $text = str_replace('<br />','',$text);
    $text = preg_replace("/<b>(.*?)<\/b>/s","[b]$1[/b]",$text);
    $text = preg_replace("/<i>(.*?)<\/i>/s","[i]$1[/i]",$text);
    $text = preg_replace("/<u>(.*?)<\/u>/s","[u]$1[/u]",$text);
    $text = preg_replace("/<s>(.*?)<\/s>/s","[s]$1[/s]",$text);
    $text = preg_replace("/<hr>/s","[hr]",$text);
    $text = preg_replace("/<code>(.*?)<\/code>/s","[code]$1[/code]",$text);
    //$text = preg_replace("/<blockquote>(.*?)<\/blockquote>/s","[blockquote]$1[/blockquote]",$text);
    if (strpos($text, 'blockquote') !== false)
    {
        if(substr_count($text, '<blockquote>') == substr_count($text, '</blockquote>')){
            $text = str_replace('<blockquote><div>', '[blockquote]', $text);
            $text = preg_replace('#\<blockquote><span class="bhead">\w+: (&quot;|"|\'|)(.*)\\1\<\/span><div>#sU', '[blockquote="$2"]', $text);
            $text = preg_replace('#<\/div><\/blockquote>\s*#', '[/blockquote]', $text);
        }
    }
    $text = preg_replace("/<img src=.([^'\"<>]+). align=.absmiddle.>/s","[img]$1[/img]",$text);
    $text = preg_replace("/(<a href=.*?<\/a>)/se","check_url_reverse('\\1')",$text);
    $text = preg_replace("/<font color=.([^'\"<>]+).>([^<>]*?)<\/font>/s","[color=$1]$2[/color]",$text);
    $text = preg_replace("/<font class=.([^'\"<>]+).>([^<>]*?)<\/font>/s","[size=$1]$2[/size]",$text);
    $text = preg_replace("/<p align=.([^'\"<>]+).>([^<>]*?)<\/p>/s","[align=$1]$2[/align]",$text);
    return $text;
}
function check_url_reverse($url){
    $url = stripslashes($url);
    if(eregi('attach',$url) && eregi('attid',$url)){
        $result = preg_replace("/<a href=\"[^\'\"]*attid=(\d+)[^\'\"]*\" target=\"_blank\">.*?<\/a>/s","[attach=$1]",$url);
    }else{
        $result = preg_replace("/<a href=\"([^'\"<>]+)\" target=\"_blank\">(.*?)<\/a>/s","[url=$1]$2[/url]",$url);
    }
    return $result;
}
function check_attach($attid){
    global $DB;
	$thisattach = $DB->selectRow("SELECT * FROM f_attachs WHERE attach_id=?d",$attid);
    $ext = strtolower(substr(strrchr($thisattach['attach_file'],'.'), 1));
    if($thisattach['attach_id']){
        $res  = '<a href="'.$config['site_href'].'index.php?n=forum&sub=attach&nobody=1&action=download&attid='.$thisattach['attach_id'].'">';
        $res .= '<img src="'.$config['site_href'].'images/mime/'.$ext.'.png" alt="" align="absmiddle">';
        $res .= ' Download: [ '.$thisattach['attach_file'].' ] '.return_good_size($thisattach['attach_filesize']).' </a>';
    }
	return $res;
}
function check_image($img_file){
  global $config;
  $maximgsize = explode('x',$config['imageautoresize']);
  $path_parts = pathinfo($img_file);
  $max_width = $maximgsize[0];
  $max_height = $maximgsize[1];
  $fil_scr_res = getimagesize(rawurldecode($img_file));
  if($fil_scr_res[0]>$max_width || $fil_scr_res[1]>$max_height){
    $n_img_file = $path_parts['dirname'].'/resized_'.$path_parts['basename'];
    if(!file_exists($n_img_file)){
      require_once('includes/class.image.php');
      $img = new IMAGE;
      ob_start();
      $res = $img->send_thumbnail($img_file,$max_width,$max_height,true);
      $imgcontent = ob_get_contents();
      @ob_end_clean();
      if ($res && (@$fp = fopen($n_img_file,'w+'))) 
      {
        fwrite($fp,$imgcontent);
        fclose($fp);
      }else{
        output_message('alert','Could not create preview!');
      }
    }
    $image = $n_img_file;
  }else{
    $image = $img_file;
  }
  return $image;
}
function return_good_size($n){
	$kb_divide = 1024;
	$mb_divide = 1024*1024;
	$gb_divide = 1024*1024*1024;

	if($n < $mb_divide){$res = round(($n/$kb_divide),2).' Kb';}
	elseif($n < $gb_divide){$res = round(($n/$mb_divide),2).' Mb';}
	elseif($n >= $gb_divide){$res = round(($n/$gb_divide),2).' Gb';}
	
	return $res;
}
function default_paginate($num_pages, $cur_page, $link_to){
  $pages = array();
  $link_to_all = false;
  if ($cur_page == -1)
  {
    $cur_page = 1;
    $link_to_all = true;
  }
  if ($num_pages <= 1)
    $pages = array('<b>[ 1 ]</b>');
  else
  {   
    $tens = floor($num_pages/10);
    for ($i=1;$i<=$tens;$i++)
    {
      $tp = $i*10;
      $pages[$tp] = "<a href='$link_to&p=$tp'>$tp</a>";
    }
    if ($cur_page > 3)
    {
      $pages[1] = "<a href='$link_to&p=1'>1</a>";
      if ($cur_page != 4){
      }
    }
    for ($current = $cur_page - 2, $stop = $cur_page + 3; $current < $stop; ++$current)
    {
      if ($current < 1 || $current > $num_pages)
        continue;
      else if ($current != $cur_page || $link_to_all)
        $pages[$current] = "<a href='$link_to&p=$current'>$current</a>";
      else
        $pages[$current] = '<b>[ '.$current.' ]</b>';
    }
    if ($cur_page <= ($num_pages-3))
    {
      if ($cur_page != ($num_pages-3)){
      }
      $pages[$num_pages] = "<a href='$link_to&p=$num_pages'>$num_pages</a>";
    }
  }
  $pages = array_unique($pages);
  ksort($pages);
  $pp = implode(' ', $pages);
  return $pp;
}

function parse_uptime($str='')
{
	$time=time(now);
	$uptime=$time-$str;
	$day = floor(($uptime / 86400)*1.0) ;
    $calc1 = $day * 86400 ;
    $calc2 = $uptime - $calc1 ;
    $hour = floor(($calc2 / 3600)*1.0) ;
    if ($hour < 10) {
    $hour = "0".$hour ;
	}
    $calc3 = $hour * 3600 ;
    $calc4 = $calc2 - $calc3 ;
    $min = floor(($calc4 / 60)*1.0) ;
    if ($min < 10) {
    $min = "0".$min ;
	}
    $calc5 = $min * 60 ;
    $sec = floor(($calc4 - $calc5)*1.0) ;
    if ($min < 10) {
	}
	$uptime = array($day,$hour,$min,$sec);
	return $uptime;
}

function population_view($n)
{
    $low=30; $medium=70; $high=100;
    if($n < $low){return '<font color="green">Low</font>';}
    elseif($n >= $low && $n <= $medium){return '<font color="orange">Medium</font>';}
    elseif($n > $medium){return '<font color="red">High</font>';}
}
function parse_worlddb_info($str)
{
    $arr = explode(';',$str);
    $wsdb_info['host'] = $arr[0];
    $wsdb_info['port'] = $arr[1];
    $wsdb_info['user'] = $arr[2];
    $wsdb_info['password'] = $arr[3];
    $wsdb_info['db'] = $arr[4];
    return $wsdb_info;
}
function check_port_status($ip, $port)
{
    if($fp1=fsockopen($ip, $port, $ERROR_NO, $ERROR_STR,(float)1.0)){
        return true;fclose($fp1); 
    }else{
        return false;
    } 
}

function realm_list()
{
	global $DB;
	$res = $DB->selectCol("SELECT id AS ARRAY_KEY,name FROM realmlist ORDER BY name");
	return $res;
}
function get_realm_byid($id)
{
	global $DB;
	$search_q = $DB->selectRow("SELECT * FROM `realmlist` WHERE `id`=?d",$id);
	return $search_q;
}

function get_zone_name($mapid, $x, $y)
{
	global $maps_a, $zone, $lang, $config, $user;
	
	if (($config['show_location']	== null) And ($user['gmlevel']==0)) {
		 return 'Not available.';
	}
	if (!empty($maps_a[$mapid]))
	{
		$zmap=$maps_a[$mapid];
		if (($mapid==0) or ($mapid==1) or ($mapid==150) or ($mapid==530))
		{
			$i=0; $c=count($zone[$mapid]);
			while ($i<$c)
			{
				if ($zone[$mapid][$i][2] < $x  AND $zone[$mapid][$i][3] > $x 
					AND $zone[$mapid][$i][1] < $y  AND $zone[$mapid][$i][0] > $y)
					$zmap=$zone[$mapid][$i][4];
				$i++;
			}
			$zmap=$maps_a[$mapid]." - ".$zmap;
		}
	} else $zmap=$lang['Unknown zone'];
	return $zmap;
}

function get_faction($race)
{
  $faction = "";
  if($race==1 || $race==3 || $race==4 || $race==7 || $race==11){
    $faction = 'Alliance';
	}else{
    $faction = 'Horde';
  }
  return $faction;
}

function get_gmlevelstr($gmlevel)
{
  $gmlevelstr= "";
  if($gmlevel==0){
    $gmlevelstr="User";
  } elseif ($gmlevel==1) {
    $gmlevelstr="Moder";
  } elseif ($gmlevel==2) {
    $gmlevelstr="GM";
  } elseif ($gmlevel==3) {
    $gmlevelstr="Admin";
  } 
  return $gmlevelstr;
}

function money ($many)
{
 if ($many>0)
 {
  $many = str_pad($many, 12, 0, STR_PAD_LEFT);
  $str  = "";
 }
 else
 {
  $many = str_pad(-$many, 12, 0, STR_PAD_LEFT);
  $str  = "-";
 }
 $copper = intval(substr($many, -2));
 $silver = intval(substr($many, -4, -2));
 $gold   = intval(substr($many, -11, -4));

 if ($gold  ) { $str.= "$gold <img src=images/gold.gif> "; }
 if ($silver) { $str.= "$silver <img src=images/silver.gif> "; }
 if ($copper) { $str.= "$copper <img src=images/copper.gif>"; }
 return $str;
}

function AT_GetSlotByType($type){
	$at_slot=0;
  if($type==2){
   	$at_slot=0;
  } elseif ($type==3) {
    $at_slot=1;
  } elseif ($type==5) {
    $at_slot=2;
  }
  return $at_slot;
}

function AT_GetPoints($TeamType, $TeamRating, $MemberRating, $TeamGames, $MemberGames){
	//echo $TeamType.'; '.$TeamRating.'; '.$MemberRating.'; '.$TeamGames.'; '.$MemberGames; exit;
	if ($TeamGames < 10) return 0; 
	
	$min_plays = ceil($TeamGames * 0.3);
	
	if ($MemberGames < $min_plays) return 0;
	
	$points = 0;
	$rating = (($MemberRating+150) < $TeamRating) ? $MemberRating : $TeamRating;
	
	if ($rating <= 1500)
		$points = $rating*0.22+14.0;
	else
		$points = 1511.26 / (1.0 + 1639.28 * exp(-0.00412*$rating));
	
	if ($TeamType==2)
		$points = $points * 0.76;
	elseif ($TeamType==3) 
		$points = $points * 0.88;
		
	return floor ($points);   
}

function AddMangosFields ($ver) {
		if ($ver !==''){
			 require_once ('core/cache/'.$ver.'_UpdateFields.php');
			 if ($ver>=313){
          require_once ('core/'.$ver.'_mangos_fn.php');
       } else {
          require_once ('core/def_mangos_fn.php');
       }
		}
}
?>
