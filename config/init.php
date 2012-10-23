<?php

define('APP_ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

/** @noinspection PhpIncludeInspection */
require_once(APP_ROOT.DS."cls".DS."Loader.php");

Loader::register();
Loader::addExtension('class', 'php');
Loader::addExtension('class', 'class.php');
Loader::addExtension('resources', 'php');
Loader::addLookupDirectory(APP_ROOT.DS.'cls');
Loader::addLookupDirectory(APP_ROOT.DS.'config');
Loader::addLookupDirectory(APP_ROOT.DS.'lang');
Loader::addLookupDirectory(APP_ROOT.DS.'pags');
Loader::addLookupDirectory(APP_ROOT.DS.'othersLib');

// <editor-fold desc="CONSTANTES">
require_once APP_ROOT.DS.'config'.DS.'localhost.php';
//require_once APP_ROOT.DS.'config'.DS.'lan.php';
//require_once APP_ROOT.DS.'config'.DS.'zymic.php';

require_once APP_ROOT.DS.'config'.DS.'const.php';
// </editor-fold>
