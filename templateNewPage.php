<?php
// <editor-fold desc="pag init">
require_once 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$usu->inicio();

//defino el lenguaje de la pag
$l = new Lang;

//vars para manejo fácil de la pag
$lo = $usu->get_loged();
$cat = $usu->get_categoria();

//defino el título de la pag
$selPag = "templateNewPage";
$pagTit = $l->grales($selPag);
// </editor-fold>
?>
<!DOCTYPE html>
<html>
<head>
    <?php $l->crearHeadMetas($pagTit) ?>
    <link rel="stylesheet" type="text/css" href="inc/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="inc/generales.css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="othersLib/sha512.js"></script>

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

    <div id="d_debug">
        <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
        <a href="debug_sess.php">debug_sess.php</a>
        <p id="cargandoJs_generales" class="colRojo">CARGANDO generales.js</p>
        <p id="cargandoJs_enBebido" class="colRojo">CARGANDO script en bebido</p>
        <?= ((DEBUGUEANDO) ? Debuguie::PrintMsgs() : "") ?>
    </div>
</div>

<script type="text/javascript" src="inc/generales.js"></script>
<script type="text/javascript">
    JsCargado($('#cargandoJs_enBebido'), 'script de la pag en Bebido.js');
</script>
</body>
</html>