<?php

define('APP_ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

/** @noinspection PhpIncludeInspection */
require_once(APP_ROOT.DS."cls".DS."Loader.php");

Loader::register();
Loader::addExtension('class', 'php');
Loader::addExtension('class', 'class.php');
Loader::addExtension('resources', 'php');
Loader::addLookupDirectory(APP_ROOT.DS.'config');
Loader::addLookupDirectory(APP_ROOT.DS.'cls');
Loader::addLookupDirectory(APP_ROOT.DS.'othersLib');

// <editor-fold desc="CONSTANTES">

require_once APP_ROOT.DS.'config'.DS.'localhost.php';
//require_once APP_ROOT.DS.'config'.DS.'lan.php';
//require_once APP_ROOT.DS.'config'.DS.'zymic.php';

define('INDEX_PAGE', APP_URL_ROOT.'index.php');
define('HOME_PAGE', APP_URL_ROOT.'home.php');
define('CPANEL_PAGE', APP_URL_ROOT.'cpanel.php');

// pa'los lenguajes
define('DEFLANG', 'en');

// pa debuguear
define('DEBUGUEANDO', true);
define('ONTHEFLY', false);

// pa TEA
define('ENCKEY', "tralalila");
// </editor-fold>



//    if(!Session::get('last_nonce')){
//        Session::set("last_nonce", mt_rand(0, 10240));
//    }
    
    