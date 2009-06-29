<?php
if(INCLUDED!==true)exit;

function random_screenshot1(){
  $fa = array();
  if ($handle = opendir('images/screenshots/')) {
    while (false !== ($file = readdir($handle))) { 
        if ($file != "thumbs" && $file != "." && $file != ".." && $file != "Thumbs.db" && $file != "index.html") { 
            $fa[] = $file; 
        } 
    }
    closedir($handle); 
  }
  $fnum = count($fa);
  $fpos = rand(0, $fnum-1);
  return $fa[$fpos];
}

$items_per_page = 16; // Output items limit
$defaultOpen = 5; // First N items that are "opened" by default.
$postnum = 0;
$hl = '';
$rnd_screenshot = '<a href=./images/Screenshots/EmptyScreenShot.jpg target="_blank"><img src="./images/Screenshots/EmptyScreenShot.jpg"  height=145 width=195></a>';;

if(!$news_forum_id)output_message('alert','Please define forum id for news (in config.php)');

$alltopics = $DB->select("
    SELECT f_topics.*,f_posts.* 
    FROM f_topics,f_posts 
    WHERE f_topics.forum_id=?d AND f_topics.topic_id=f_posts.topic_id 
    GROUP BY f_topics.topic_id 
    ORDER BY sticky DESC,topic_posted DESC,f_posts.posted  
    LIMIT ?d,?d",$news_forum_id,0,$items_per_page);

// Для скриншота на главной странице
$number = $DB->selectcell("SELECT COUNT(*) FROM `gallery_scr` ORDER BY `id`;");
if ($number>0){
  $query=$DB->select("SELECT `img` FROM `gallery_scr` ORDER BY `id` LIMIT ?d, 1", rand(0,$number-1));
  echo ($number);
  foreach ($query as $result){
    $rnd_screenshot = '<a href="./images/Screenshots/'.$result["img"].'" target="_blank"><img src="./images/Screenshots/'.$result["img"].'"  height=145 width=195></a>';
  }
}
?>
