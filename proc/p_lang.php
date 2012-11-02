<?php
require_once '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'init.php';

Debuguie::AddMsg("p_lang", "", "fInit");

if (isset($_GET['lang']) && isset($_GET['arr']) && isset($_GET['msg'])) {
    $lang = htmlentities($_GET['lang']);
    $arr = htmlentities($_GET['arr']);
    $msg = htmlentities($_GET['msg']);

    Debuguie::AddMsg("p_lang", "pedido=(lang=($lang), arr=($arr), msg=($msg))", "info");

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

    Debuguie::AddMsg("p_lang", "rta=(msg=($msg))", "success");

    $rta = SuperFuncs::errYmsg(false, $msg);
} else {
    $rta = SuperFuncs::errYmsg(true, "pedidoInvalido");
}

echo $rta;

Debuguie::AddMsg("p_lang", "rta=($rta)", "fEnd");
exit;
