<?php
require_once 'config' . DIRECTORY_SEPARATOR . 'init.php';

//defino el lenguaje de la pag
$l = new Lang;

$pagTit = "Debug Session y Cookies";

if (isset($_GET['p'])) {
    $p = $_GET['p'];
    if ($p == "clearsess") {
        Session::kill();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php $l->crearHeadMetas($pagTit) ?>
        <link rel="stylesheet" type="text/css" href="inc/fonts/fonts.css" />
        <style>
            h1 {text-align: center; color: #0081c2;}
            .az {color: blue;}
            .ve {color: green;}
            .re {color: red;}
        </style>
    </head>
    <body>
        <h1><?= $pagTit ?></h1>
        <hr />
        <h3>ses: <?php print_r($_SESSION); ?></h3>
        <?= (Session::get('usu')) ? "<h3>hay sesi&oacute;n usu!</h3>\n" : "<h3>NO hay sesi&oacute;n usu</h3>\n" ?>
        <?= (Session::get('lang')) ? "<h3>hay sesi&oacute;n lang=" . Session::get('lang') . "</h3>\n" : "<h3>NO hay sesi&oacute;n lang</h3>\n" ?> 
        <hr />
        <h3>Cookies:</h3>
        <p><?php print_r($_COOKIE); ?></p><br />
        <hr />
        <a href="proc/p_logout.php">p_logout</a>
        <a href="debug_sess.php?p=clearsess">borrar sess</a>
    </body>
</html>