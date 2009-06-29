<?php
@include ("core/cache/links_cache.php");
$templategenderimage = array(
    0 => $config['template_href'].'images/pixel.gif',
    1 => $config['template_href'].'images/icons/male.gif',
    2 => $config['template_href'].'images/icons/female.gif'
);
/**
There are 8 menu blocks:
    1-menuNews
    2-menuAccount
    3-menuGameGuide
    4-menuInteractive
    5-menuMedia
    6-menuForums
    7-menuCommunity
    8-menuSupport
    
    adding custom link, for example:
    $mainnav_links['1-menuNews'][] = array(
        'lang_variable',
        'link',
        ''
    );
*/

function build_menu_items($links_arr){
    global $lang, $links_conf, $user;
    $r = "\n";
    foreach($links_arr as $menu_item){
    	$lvl = "lvl".$menu_item[0];
        if($menu_item[0] && $links_conf[$menu_item[0]]===true && $user['g_id'] >= $links_conf[$lvl])$r .= '                                                <div><a class="menuFiller" href="'.$menu_item[1].'">'.$lang[$menu_item[0]].'</a></div>'."\n";
    }
    return $r;
}

function build_main_menu(){

    global $mainnav_links;
    foreach($mainnav_links as $menuname=>$menuitems){
    $menunamev = explode('-',$menuname);
    if(count($menuitems)>0 && $menuitems[0][0])
    echo '
                                <div id="'.$menunamev[1].'">
                                  <div onclick="javascript:toggleNewMenu('.$menunamev[0].'-1);" class="menu-button-off" id="'.$menunamev[1].'-button">
                                    <span class="'.$menunamev[1].'-icon-off" id="'.$menunamev[1].'-icon">&nbsp;</span><a class="'.$menunamev[1].'-header-off" id="'.$menunamev[1].'-header"><em>Menu item</em></a><a id="'.$menunamev[1].'-collapse"></a><span class="menuEntry-rightBorder"></span>
                                  </div>
                                  <div id="'.$menunamev[1].'-inner">
                                    <script type="text/javascript">
                                        if (menuCookie['.$menunamev[0].'-1] == 0) {
                                            document.getElementById("'.$menunamev[1].'-inner").style.display = "none";   
                                            document.getElementById("'.$menunamev[1].'-button").className = "menu-button-off";
                                            document.getElementById("'.$menunamev[1].'-collapse").className = "leftMenu-plusLink";
                                            document.getElementById("'.$menunamev[1].'-icon").className = "'.$menunamev[1].'-icon-off";
                                            document.getElementById("'.$menunamev[1].'-header").className = "'.$menunamev[1].'-header-off";
                                        } else {
                                            document.getElementById("'.$menunamev[1].'-inner").style.display = "block";    
                                            document.getElementById("'.$menunamev[1].'-button").className = "menu-button-on";
                                            document.getElementById("'.$menunamev[1].'-collapse").className = "leftMenu-minusLink";
                                            document.getElementById("'.$menunamev[1].'-icon").className = "'.$menunamev[1].'-icon-on";
                                            document.getElementById("'.$menunamev[1].'-header").className = "'.$menunamev[1].'-header-on";
                                        }
                                    </script>
                                    <div class="leftMenu-cont-top"></div>
                                    <div class="leftMenu-cont-mid">
                                      <div class="m-left">
                                        <div class="m-right">
                                          <div class="leftMenu-cnt" id="menuContainer1">
                                            <ul class="mainNav">
                                              <div style="position:relative;" id="menuFiller1">
                                                '.build_menu_items($menuitems).'
                                              </div>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="leftMenu-cont-bot"></div>
                                  </div>
                                </div>
    ';
    }
}

function write_form_tool(){
    global $config;
    global $user;
?>
        <div id="form_tool" class="clearfix">
            <ul id="bbcode_tool" class="clearfix">
                <li id="bbcode_b" class="link_box"><a href="#"><strong>B</strong></a></li>
                <li id="bbcode_i" class="link_box"><a href="#"><i>i</i></a></li>
                <li id="bbcode_u" class="link_box"><a href="#"><u>u</u></a></li>
                <li id="bbcode_s" class="link_box"><a href="#"><s>strike</s></a></li>
                <li id="bbcode_url" class="link_box"><a href="#"><span>url</span></a></li>
                <li id="bbcode_img" class="link_box"><a href="#"><span>img</span></a></li>
                <?php if($user['g_use_attach']==1){ ?>
                <li id="bbcode_attach" class="link_box"><a href="#"><span>attach</span></a></li>
                <?php } ?>
                <li id="bbcode_blockquote" class="link_box"><a href="#"><span>quote</span></a></li>
                <li id="bbcode_code" class="link_box"><a href="#"><span>code</span></a></li>
            </ul>
            <ul id="text_tool" class="clearfix">
                <li id="text_size" class="link_box"><a href="#"><span>size</span></a>
                    <ul>
                        <li id="text_size-hugesize" class="hugesize"><a href="#"><span>Huge</span></a></li>
                        <li id="text_size-largesize" class="largesize"><a href="#"><span>Large</span></a></li>
                        <li id="text_size-mediumsize" class="mediumsize"><a href="#"><span>Medium</span></a></li>
                    </ul>
                </li>
                <li id="text_color" class="overtoggle link_box"><a href="#"><span>color</span></a>
                    <ul>
                        <li id="text_color-red"><a href="#"><span>Red</span></a></li>
                        <li id="text_color-green"><a href="#"><span>Green</span></a></li>
                        <li id="text_color-blue"><a href="#"><span>Blue</span></a></li>
                        <li id="text_color-custom"><a href="#"><span>Custom</span></a></li>
                    </ul>
                </li>
                <li id="text_align" class="link_box"><a href="#"><span>alignment</span></a>
                    <ul>
                        <li id="text_align-center"><a href="#"><span>Center</span></a></li>
                        <li id="text_align-justify"><a href="#"><span>Justify</span></a></li>
                        <li id="text_align-left"><a href="#"><span>Left</span></a></li>
                        <li id="text_align-right"><a href="#"><span>Right</span></a></li>
                    </ul>
                </li>
                <li id="smile" class="link_box"><a href="#"><span>smiles</span></a>
                    <ul style="height:18em;">
                    <?php $smiles = load_smiles(); foreach($smiles as $smile){ ?>
                        <li id="smile-<?php echo $config['smiles_path'].$smile;?>"><a href="#"><span><img src="<?php echo $config['smiles_path'].$smile;?>" title="<?php echo str_replace('.gif','',$smile);?>"></span></a></li>
                    <?php } ?>
                    </ul>
                </li>
            </ul>
        </div> 
<?php
}
function random_screenshot(){
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
function build_pathway(){
    global $lang;
    global $pathway_info;
    global $title_str,$pathway_str;
    $path_c = count($pathway_info);
    $pathway_info[$path_c-1]['link'] = '';
    $pathway_str = '';
    if(empty($_REQUEST['n']) || !is_array($pathway_info)){
      $pathway_str .= ' <b><u>'.$lang['mainpage'].'</u></b>';
    } elseif ($_REQUEST['n']=="frontpage") {
      $pathway_str = "";
    }
    else $pathway_str .= '<a href="./">'.$lang['mainpage'].'</a>';
    if(is_array($pathway_info)){
        foreach($pathway_info as $newpath){
            if(isset($newpath['title'])){
                $raquo = ' &raquo; ';
                if(empty($pathway_str)) $raquo='';
                if(empty($newpath['link'])) $pathway_str .= $raquo.$newpath['title'].'';
                else $pathway_str .= $raquo.'<a href="'.$newpath['link'].'">'.$newpath['title'].'</a>';
                $title_str .= ' &raquo; '.$newpath['title'];
            }
        }
    }
    $pathway_str .= '';
}
// !!!!!!!!!!!!!!!! //
build_pathway();

function load_banners($type){
    global $DB;
    $result = $DB->select("SELECT * FROM banners WHERE type=?d ORDER BY num_click DESC",$type);
    return $result;
}

function paginate($num_pages, $cur_page, $link_to){
  $pages = array();
  $link_to_all = false;
  if ($cur_page == -1)
  {
    $cur_page = 1;
    $link_to_all = true;
  }
  if ($num_pages <= 1)
    $pages = array('1');
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
        $pages[$current] = '[ '.$current.' ]';
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
  return str_replace('//','/',$pp);
}
?>
