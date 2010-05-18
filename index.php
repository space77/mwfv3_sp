<?php
/*************************************************************************/
/* Вы можете копировать, распространять данный проект, 
/* в соответствии с GNU GPL, однако любое изменение кода в целом 
/* или части кода данного проекта, 
/* желательно производить с согласования автора проекта.
/*
/* You may copy, spread the givenned project, 
/* in accordance with GNU GPL, however any change 
/* the code as a whole or a part of the code given project, 
/* advisable produce with co-ordinations of the author of the project
/*
/* (c) Sasha aka LordSc. lordsc@yandex.ru
/*************************************************************************/
error_reporting(E_ERROR | E_PARSE | E_WARNING);
// error_reporting(E_ALL);
define('INCLUDED', true);

$time_start = microtime(1);
$_SERVER['REQUEST_TIME'] = time();

// Config file ...
require_once('config.php'); 
// Site functions & classes ...
require_once('core/common.php');
require_once('core/class.auth.php');
require_once('core/dbsimple/Generic.php');

global $config;
$users_online=array();
$guests_online=0;
$messages = '';
$redirect = '';
$sidebarmessages = '';
$context_menu = array();

// Connetcts to DB
// DB layer documentation at http://en.dklab.ru/lib/DbSimple/
function databaseErrorHandler($message, $info)
{
  if (!error_reporting()) return;
    output_message('alert',"SQL Error: $message<br><pre>".print_r($info, true)."</pre>");
}

$DB = DbSimple_Generic::connect("".$config['db_type']."://".$config['db_username'].":".$config['db_password']."@".$config['db_host'].":".$config['db_port']."/".$config['db_name']."");
$DB->setErrorHandler('databaseErrorHandler');
$DB->query("SET NAMES ".$config['db_encoding']);



// Load settings from db or cache //
loadSettings();
// Build path vars //
$config['site_href'] = str_replace('//','/',str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME']).'/'));
$config['site_domain'] = $_SERVER['HTTP_HOST'];
$config['base_href'] = 'http://'.$config['site_domain'].''.$config['site_href'];
$config['template_href'] = $config['site_href'].'templates/'.$config['template'].'/';
// Check lang ======================================
if(isset($_COOKIE['Language'])) $config['lang'] = $_COOKIE['Language'];
loadLanguages();
// ================================================    

// Load auth system //
$auth = new AUTH($DB,$config);
$user = $auth->user;
// ================== //
// Load cached permissions & menu or default...
if(file_exists('core/cache/comp_cache.php'))require_once('core/cache/comp_cache.php');
else require_once('core/default_components.php');

if($user['g_is_admin']==1 || $user['g_is_supadmin']==1){
$allowed_ext[] = 'admin';
$context_menu[] = array('title'=>'[ Admin panel ]','link'=>'index.php?n=admin');
}

// for mod_rewrite query_string fix //
global $_GETVARS;
$req_vars = parse_url($_SERVER['REQUEST_URI']);
if(isset($req_vars['query'])){
    parse_str($req_vars['query'], $req_arr);
    $_GETVARS = $req_arr;
}
unset($req_arr,$req_vars);
// ======================================================= //

    if(empty($_GET['p']) OR $_GET['p'] < 1)$p = 1;else $p = $_GET['p'];
    $ext = (isset($_REQUEST['n'])?$_REQUEST['n']:$config['default_component']);
    $sub = (isset($_REQUEST['sub'])?$_REQUEST['sub']:'index');
    $req_tpl = false;
						          
    if(in_array($ext,$allowed_ext)){

        // load component
        require_once('components/'.$ext.'/'.'main.php');
        if($com_content[$ext]['index'][0] && $user[$com_content[$ext]['index'][0]]!=1)exit('<h2>Forbidden</h2><meta http-equiv=refresh content="3;url=\'./\'">');
        // ==================== //
        if(isset($_REQUEST['n']) && isset($lang[$com_content[$ext]['index'][1]]))$pathway_info[] = array('title'=>$lang[$com_content[$ext]['index'][1]],'link'=>$com_content[$ext]['index'][2]);
        // ==================== //
        foreach ($com_content[$ext] as $sub_name => $sub_conf){
            if($sub_conf[4]==1){
                if($sub_conf[0]){
                    if($user[$sub_conf[0]]==1){
                        $context_menu[] = array('title'=>$lang[$sub_conf[1]],'link'=>$sub_conf[2]);
                    }
                }else{
                    if(isset($lang[$sub_conf[1]]))$context_menu[] = array('title'=>$lang[$sub_conf[1]],'link'=>$sub_conf[2]);
                }
            }
        }
        if($sub){
            if($com_content[$ext][$sub]){
                if($com_content[$ext][$sub][0]){
                    if($user[$com_content[$ext][$sub][0]]==1){
                        @require_once('components/'.$ext.'/'.$ext.'.'.$sub.'.php');
                        $req_tpl = $ext.'.'.$sub.'.php';
                    }
                }else{
                    @require_once('components/'.$ext.'/'.$ext.'.'.$sub.'.php');
                    $req_tpl = $ext.'.'.$sub.'.php';
                }
            }
        }
    
        if(empty($_GET['nobody'])){
            require_once('templates/'.$config['template'].'/body_functions.php');
            require_once('templates/'.$config['template'].'/body_header.php');
        
            // DEBUG //
            if((bool)$config['debuginfo']){
                output_message('debug','DEBUG://'.$DB->_statistics['count']);
                output_message('debug','<pre>'.print_r($_SERVER,true).'</pre>');
            }
            // =======//
            if($req_tpl){
                if(file_exists('templates/'.$config['template'].'/'.$ext.'/'.$req_tpl))
                    require_once('templates/'.$config['template'].'/'.$ext.'/'.$req_tpl);
            }
            $time_end = microtime(1);
            $exec_time = $time_end - $time_start;            
            require_once('templates/'.$config['template'].'/body_footer.php');
        }else{
            if(file_exists('templates/'.$config['template'].'/'.$ext.'/'.$req_tpl))
                require_once('templates/'.$config['template'].'/'.$ext.'/'.$req_tpl);
        }
    }else{
        echo'<h2>Forbidden</h2><meta http-equiv=refresh content="3;url=\'./\'">';
    }
?>
