<?
if(INCLUDED!==true)exit;
// ==================== //
@include ("core/cache/links_cache.php");
function cashe_menu($post,$array_menu)
{
	global $gids;
	$cache_str = '<?php'."\n".'$links_conf = array( '."\n";
	foreach($array_menu as $menu_item){
		foreach($menu_item as $item){
				$it = str_replace(" ","_",$item[0]);
				$lvl = "lvl".$it;
				$typedvalue = $post[$it]==on?'true':'false';
				$typelvl = $gids[$post[$lvl]];
   	 			$cache_str .= '\''.$item[0].'\' => '.$typedvalue.''.", \n";
   	 			$cache_str .= '\'lvl'.$item[0].'\' => \''.$typelvl.'\''.", \n";
   	 	}
    }
    $cache_str .= ");\n?>";
    file_put_contents('core/cache/links_cache.php',$cache_str);
    echo "ok...";
    echo '<meta http-equiv=refresh content="1 ;url=index.php?n=admin&sub=menu">';
}
$gids = array(
	"Guest" => "1",
	"Members" => "2",
	"Administrators" => "3",
	"Root Admins" => "4",
);
?>
