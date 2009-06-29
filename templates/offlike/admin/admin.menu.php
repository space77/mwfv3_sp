<div class="sections clearfix">
<?php if(!$_GET['action']){ 
echo '<form method="post" action="index.php?n=admin&sub=menu&action=change" enctype="multipart/form-data">'; 
echo '<div style="border: 2px dotted #1E4378;background:none;margin:4px;padding:6px 9px 6px 9px;text-align:left;width:94%;">';
echo '<table border=0><tr><td>Menu_id</td><td>Menu_name</td><td>&nbsp;</td><td>g_id_req</td></tr>';
foreach($mainnav_links as $menu_item => $nav){
	echo '<tr><td colspan=4><b>&nbsp;</b></td></tr><tr><td><b>'.(substr($menu_item, 6)).'&nbsp;</b></td></tr>';
	foreach($nav as $item){
		if($item[0]){
			$lvl = "lvl".$item[0];
        	echo '<tr><td>&nbsp;</td><td><input type="checkbox" name="'.$item[0].'" '.($links_conf[$item[0]]===true?'CHECKED':'').' /> '.$lang[$item[0]]."\n";
        	echo ' </td><td width=10%>&nbsp;</td><td> <SELECT NAME="lvl'.$item[0].'"> <OPTION '.($links_conf[$lvl]==1?'selected':'').'>Guest</OPTION><OPTION '.($links_conf[$lvl]==2?'selected':'').'>Members</OPTION><OPTION '.($links_conf[$lvl]==3?'selected':'').'>Administrators</OPTION><OPTION '.($links_conf[$lvl]==4?'selected':'').'>Root Admins</OPTION></SELECT>'."\n";
    		echo '<div class="divhr"></div></td></tr>';
    	}
    }
}
echo '</table>';
echo '</div>';
echo '<div style="background:none;margin:4px;padding:6px 9px 0px 9px;text-align:right;width:94%;">';
echo '<input type="submit" size="16" class="button" style="font-size:12px;" value="'.$lang['dochange'].'">';
echo '</div>';
echo '</form>';
} 
echo '</div>';
if($_GET['action']){ cashe_menu($_POST,$mainnav_links); }
?>