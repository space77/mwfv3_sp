<?php
if(INCLUDED!==true)exit;

$items_per_page = 16; // Output items limit
$defaultOpen = 5; // First N items that are "opened" by default.
$postnum = 0;
$hl = '';


if ($_GET['cat']=='faq') {
  $pathway_info[] = array('title'=>$lang['faq'],'link'=>'');
  if(!$rules_forum_id)output_message('alert','Please define forum id for faq (in config.php)');

  $alltopics = $DB->select("
    SELECT f_topics.*,f_posts.* 
    FROM f_topics,f_posts 
    WHERE f_topics.forum_id=?d AND f_topics.topic_id=f_posts.topic_id 
    GROUP BY f_topics.topic_id 
    ORDER BY sticky DESC,topic_posted DESC,f_posts.posted  
    LIMIT ?d,?d",$faq_forum_id,0,$items_per_page);
} elseif ($_GET['cat']=='patchs') { 
  $pathway_info[] = array('title'=>$lang['patchs'],'link'=>'');
  if(!$rules_forum_id)output_message('alert','Please define forum id for paths (in config.php)');

  $alltopics = $DB->select("
    SELECT f_topics.*,f_posts.* 
    FROM f_topics,f_posts 
    WHERE f_topics.forum_id=?d AND f_topics.topic_id=f_posts.topic_id 
    GROUP BY f_topics.topic_id 
    ORDER BY sticky DESC,topic_posted DESC,f_posts.posted  
    LIMIT ?d,?d",$patchs_forum_id,0,$items_per_page);
} else {
  $pathway_info[] = array('title'=>$lang['rules'],'link'=>'');
  if(!$rules_forum_id)output_message('alert','Please define forum id for rules (in config.php)');

  $alltopics = $DB->select("
    SELECT f_topics.*,f_posts.* 
    FROM f_topics,f_posts 
    WHERE f_topics.forum_id=?d AND f_topics.topic_id=f_posts.topic_id 
    GROUP BY f_topics.topic_id 
    ORDER BY sticky DESC,topic_posted DESC,f_posts.posted  
    LIMIT ?d,?d",$rules_forum_id,0,$items_per_page);
}
?>
