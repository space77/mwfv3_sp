<?php
/*
if(INCLUDED!==true)exit;
	$pathway_info[] = array('title'=>$lang['userlist'],'link'=>'');
	//===== Filter ==========//
	if($_GET['char'] && preg_match("/[a-z]/",$_GET['char'])){
		$filter = "WHERE `username` LIKE '".$_GET['char']."%'";
	}else{
		$filter = '';
	}
	//===== Calc pages =====//
	$items_per_pages = $config['users_per_page'];
	$itemnum = $db->num_rows($db->query("SELECT NULL FROM `members` $filter"));
	$pnum = ceil($itemnum/$items_per_pages);
	$pages_str = default_paginate($pnum, $p, "index.php?n=account&sub=userlist&char=".$_GET['char']);
	$limit_start = ($p-1)*$items_per_pages;
	
	$result = $db->query("SELECT * FROM `members` $filter ORDER BY `username` LIMIT $limit_start,$items_per_pages");
	while($result_row = $db->fetch_assoc($result))
	{
		$tmp_settings = $auth->parsesettings($result_row['settings']);
		$result_row['email_setting'] = $tmp_settings['hideemail'];
		if(!eregi('http://',$result_row['homepage']))$result_row['homepage'] = 'http://'.$result_row['homepage'];
		$items[] = $result_row;
	}
*/
?>