<?php
// <editor-fold desc="pag init">
require_once 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$usu->inicio();

//defino el lenguaje de la pag
$l = new Lang;

//vars para manejo fácil de la pag
$lo = $usu->get('loged');
$cat = $usu->get('categoria');

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
    <?php require_once APP_ROOT.DS."pags".DS."header.php"; ?>
    <?php require_once APP_ROOT.DS."pags".DS."botonera.php"; ?>

    <div id="d_cuerpo">
        <h1><?=$pagTit?></h1>
        <p>acacacacalñ ñlaskdlñakdñlaskdñasdkañsldkaslñdkasñdlkadñlk</p>
        <p>nosotros aula</p>

        <p class="cl"></p>
    </div>

    <?php require_once APP_ROOT.DS.'pags'.DS.'footer.php'; ?>

    <div id="d_debug">
        <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
        <a href="debug_sess.php">debug_sess.php</a>
        <p id="cargandoJs_generales" class="colRojo">CARGANDO generales.js</p>
    </div>
</div>

<?= htmlGenericos::PrintScripts(null,true,null,true,true,null) ?>

<!-- TODO: agregar las CONST de xxPAG a window.constBla
<script type="text/javascript"></script>
-->

<?= ((DEBUGUEANDO) ? Debuguie::PrintMsgs() : "") ?>

</body>
</html>