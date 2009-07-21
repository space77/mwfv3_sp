<?php
if(INCLUDED!==true)exit;
// ==================== //
$pathway_info[] = array('title'=>$lang['components_manage'],'link'=>$com_links['sub_components']);
// ==================== //

if($_GET['action']=='doupdate'){
    chmod('core/cache/',0777);
    chmod('lang/',0777);
    if ($handle = opendir('components/')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") {
                $exist_comp[] = $file;
            }
        }
        closedir($handle);
    }
    $com_content = array();
    $tmp_allowed_ext = array();
    $tmp_mainnav_links = array();
    foreach($exist_comp as $tmp_comp){
        @include('components/'.$tmp_comp.'/main.php');
        // search install lang files
        foreach($languages as $lang_s=>$lang_name){
            if(file_exists('components/'.$tmp_comp.'/'.$lang_s.'.'.$lang_name.'.lang')){
                $langfile = @file_get_contents('lang/'.$lang_s.'.'.$lang_name.'.lang');
                $langfile = str_replace("\n",'',$langfile);
                $langfile = str_replace("\r",'',$langfile);
                $langfile = explode('|=|',$langfile);
                foreach($langfile as $langstr){
                    $langstra = explode(' :=: ',$langstr);
                    if(isset($langstra[1]))$thislang[$langstra[0]] = $langstra[1];
                }
                $langfile = @file_get_contents('components/'.$tmp_comp.'/'.$lang_s.'.'.$lang_name.'.lang');
                $langfile = str_replace("\n",'',$langfile);
                $langfile = str_replace("\r",'',$langfile);
                $langfile = explode('|=|',$langfile);
                foreach($langfile as $langstr){
                    $langstra = explode(' :=: ',$langstr);
                    if(isset($langstra[1]))$thislang[$langstra[0]] = $langstra[1];
                }
                $newlangfile = '';
                $thislang = array_unique($thislang);
                foreach($thislang as $key => $val){
                    $newlangfile .= '|=|'.$key.' :=: '.$val."\n";
                }
                file_put_contents('lang/'.$lang_s.'.'.$lang_name.'.lang',$newlangfile);
                unset($newlangfile);
            }
        }
    }
    foreach ($com_content as $comp_name=>$comp_array){
        foreach ($comp_array as $comp_members){
            if($comp_members[3]){
                $tmp_mainnav_links[$comp_members[3]][] = array($comp_members[1],$comp_members[2],$comp_members[0]);
            }
        }
        $tmp_allowed_ext[] = $comp_name;
    }
    ksort($tmp_mainnav_links);
    
    $cache_str  = "<?php\n";
    $cache_str .= '$mainnav_links = '.var_export($tmp_mainnav_links,true).';';
    $cache_str .= "\n\n";
    $cache_str .= '$allowed_ext = '.var_export($tmp_allowed_ext,true).';';
    $cache_str .= "?>";
    file_put_contents('core/cache/comp_cache.php',$cache_str);
    
    redirect($com_content['admin']['components'][2],1);
}

$base_dir ='./core/mangos_UpdateFields/';
if($_GET['action']=='mfupdate'){
	$bResult = true;
	    if ($handle = opendir($base_dir)) {
        while (false !== ($file = readdir($handle))) {
            if (is_file($base_dir.$file) && $file != "Thumbs.db" && $file != "index.html") {
                if (stripos($file, "_UpdateFields.h") !== false) {
                  $ver = str_ireplace("_UpdateFields.h", "", $file);
                  ParseUpdateFields ($base_dir.$file, $ver."_UpdateFields.php");
                }
            }
        }
        closedir($handle);
    }	
	redirect($com_content['admin']['components'][2],1);
}

function ParseUpdateFields ($UpdateFieldsFile, $OutFileName) {

	chmod('core/cache/',0777);
	
	$str ='';
	$rows = file($UpdateFieldsFile);
	$myFile = "./core/cache/". $OutFileName;

	$fh = fopen($myFile, 'w');
	fwrite($fh, "<?php\n\n\n\n\n");

	//fwrite($fh, "\$mangos_field = array(");
	fclose($fh);
	$fh = fopen($myFile, 'a');


	// STEP 1 - Browsing every line
	
	// First we need to surf to each rows. Lets filter some data and some not.
	foreach($rows as $row){
	
	    // Filter Data.
	
	    // We do not wany any coments at all in our files.
	    if (strstr($row, '/*') == TRUE){
	        $exclude = 1;
	    }elseif(strstr($row, '*/') == TRUE){
	        $exclude = 2;
	    }elseif($exclude == 2){
	        $exclude = 0;
	    }
	    elseif($exclude == 1){
	
	    }
	    // Also exclude comments with #
	    elseif(strstr($row, '#')){
	    }
	    // Not exclude whole lines with // but exclude after // is inizalized.
	    elseif(strstr($row, '//')){
	        $ar = explode('//',$row);
	        if ($ar['0'] != ''){
	        $str .= $ar['0'];
	
	        }
	    }elseif($row == "\n"){
	    }
	    // We could make use of enum define.. Well not now.
	    elseif(strstr($row, 'enum')){
	
	    }
	    // If we feel that everyhting is OK, lets go ahead.
	    else{
	        $o = str_replace("\r","",$row);
	        $str .= str_replace("\n","",$o);
	    }
	}


	//STEP 2 - Find the fields and filter all unused and bad data away.
	
	$array = explode('{', $str);
	foreach($array as $value){
	
	    $var = explode('};', $value);
	        $z = str_replace('\n','',$var[0]);
	        $z = str_replace('\r','',$z);
	        $out .= str_replace(' ','',$z);
	}

	// Step 3 - Find the inizalizer and the value of the define. Write to file if its a clean int
	$ar = explode(',', $out);
	
	$i = 0;
	foreach($ar as $row){
	    $regn = explode('=', $row);
	    if (is_numeric($regn[1]) == TRUE){
	        $regn[0] = str_replace("\n", "", $regn[0]);
	        $regn[0] = str_replace("'\r", "", $regn[0]);
	        $op = "\$mangos_field['".$regn[0]."'] = ".hexdec($regn[1]).";\n";
	        fwrite($fh, $op);
	    }else{
	        $neednew[$i][0] = str_replace("\n", "",$regn[0]);
	        $neednew[$i][1] = $regn[1];
	        //echo $regn[0]." = ".intval($regn[1])."<br>";
	        $i++;
	    }
	}

	// Step 4 - Write rows that is independednt of the other values above.
	foreach($neednew as $row){
	    if ($row[0] == '' || $row[1] == ''){}else{
	    $calc = explode('+', $row[1]);
	    $op = "\$mangos_field['".$row[0]."'] = \$mangos_field['".$calc[0]."']+".hexdec(trim($calc[1])).";\n";
	    fwrite($fh, $op);
	    }
	}
	//fwrite($fh, "\n\n);\n\n");
	fwrite($fh, "\n\n\n\n");
	$op = "\n\n\n?>";
	fwrite($fh, $op);
	fclose($fh);

}
?>
