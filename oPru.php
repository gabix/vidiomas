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
$selPag = "oPru";
$pagTit = $l->grales($selPag);
// </editor-fold>

$pagTitle = "php page template";
?>
<!DOCTYPE html>
<html>
<head>
    <?php $l->crearHeadMetas($pagTit) ?>
    <link rel="stylesheet" type="text/css" href="inc/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="inc/generales.css" />
    <style type="text/css">
        #d_cuerpo {
            width: 100%;
            height: 400px;
            float: left;
            border-left: 3px solid red;
        }
    </style>
</head>

<body>

<div id="d_superContenedor">
    <?php require_once APP_ROOT.DS."pags".DS."header.php"; ?>
    <?php require_once APP_ROOT.DS."pags".DS."botonera.php"; ?>

    <div id="d_cuerpo">
        <h1><?=$pagTit?></h1>
        <p>oPru es un super-duper template</p>
        <p>si</p>

        <p class="cl"></p>
    </div>

    <?php require_once APP_ROOT.DS.'pags'.DS.'footer.php'; ?>

</div>

<div id="d_debug">
    <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
    <a href="debug_sess.php">debug_sess.php</a>
    <p id="pru">CARGANDO generales.js</p>
    <p id="pru2">CARGANDO script en bebido</p>
    <?= ((DEBUGUEANDO) ? Debuguie::PrintMsgs() : "") ?>
</div>

<script type="text/javascript" src="inc/generales.js"></script>
<script type="text/javascript">
    $('#pru2').html("CARGADO script en bebido");
</script>
</body>
</html>
