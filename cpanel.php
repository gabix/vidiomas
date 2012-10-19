<?php
// <editor-fold desc="pag init">
require 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$usu->inicio();

//defino el lenguaje de la pag
$l = new Lang;

//vars para manejo fácil de la pag
$lo = $usu->get_loged();
$cat = $usu->get_categoria();

//defino el título de la pag
$selPag = "cpanel";
$pagTit = $l->grales($selPag);
// </editor-fold>
?>
<!DOCTYPE html>
<html>
<head>
    <?php $l->crearHeadMetas($pagTit) ?>
    <link rel="stylesheet" type="text/css" href="inc/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="inc/generales.css" />
    <link rel="stylesheet" type="text/css" href="inc/cpanel.css" />
</head>
<body>
<div id="d_superContenedor">
    <?php include APP_ROOT.DS."pags".DS."header.php"; ?>
    <?php include APP_ROOT.DS."pags".DS."botonera.php"; ?>

    <div id="d_cuerpo">
        <h1><?=$pagTit?></h1>
        <p>acacacacalñ ñlaskdlñakdñlaskdñasdkañsldkaslñdkasñdlkadñlk</p>
        <p>nosotros aula</p>

        <p class="cl"></p>
    </div>

    <?php include APP_ROOT.DS.'pags'.DS.'footer.php'; ?>

    <div id="debug">
        <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
    </div>
</div>

<script type="text/javascript" src="othersLib/jquery.min.js"></script>
<script type="text/javascript" src="othersLib/sha512.js"></script>
<!-- TODO: agregar las CONST de xxPAG a window.constBla
<script type="text/javascript"></script>
-->
<script type="text/javascript" src="inc/generales.js"></script>
</body>
</html>