<?php
require_once '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'init.php';

if (isset($_GET['lang']) && isset($_GET['arr']) && isset($_GET['msg'])) {
    $lang = htmlentities($_GET['lang']);
    $arr = htmlentities($_GET['arr']);
    $msg = htmlentities($_GET['msg']);
    
    if (strlen($lang) <> 2) {
        echo SuperFuncs::errYmsg(true, "pedidoInvalido");
        exit;
    }
    if (!preg_match('#[0-9a-zA-Z]#', $arr)) {
        echo SuperFuncs::errYmsg(true, "pedidoInvalido");
        exit;
    }
    if (!preg_match('#[0-9a-zA-Z]#', $msg)) {
        echo SuperFuncs::errYmsg(true, "pedidoInvalido");
        exit;
    }
    
    $l = new Lang($arr, $lang);
    $msg = $l->generico($arr, $msg);

    echo SuperFuncs::errYmsg(false, $msg);
} else {
    echo SuperFuncs::errYmsg(true, "pedidoInvalido");
}
exit;
