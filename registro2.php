<?php
// <editor-fold desc="pag init">
require_once 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$lo = $usu->logueado();
$cat = $usu->get('categoria');

//defino el lenguaje de la pag
$l = new Lang;

//defino el título de la pag
$selPag = "registro";
$pagTit = $l->grales($selPag);
// </editor-fold>
?>
<!DOCTYPE html>
<html>
<head>
    <?= $l->crearHeadMetas($pagTit) ?>
    <link rel="stylesheet" type="text/css" href="inc/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="inc/generales.css" />
    <link rel="stylesheet" type="text/css" href="inc/registro.css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="othersLib/sha512.js"></script>
</head>

<body>
<div id="d_superContenedor">
    <?php require_once APP_ROOT.DS."pags".DS."header.php"; ?>
    <?php require_once APP_ROOT.DS."pags".DS."botonera.php"; ?>

    <div id="d_cuerpo">
        <div class="d_preg">
            <h1><span class="colVerde">¡</span>registrate bolú<span class="colVerde">!</span></h1>
            <hr class="hr_punteada" />
        </div>

        <div class="d_bordes">
            <div class="d_bordes_contiene">
                <h2>Registrate salamín</h2>

                <p>la concha de la lora?</p>
                <p>la concha de la lora al cuadrado</p>
                <p>la concha de la lora?</p>
                <p>la concha de la lora al cuadrado</p>
                <p>la concha de la lora?</p>
                <p>la concha de la lora al cuadrado</p>
                <p>la concha de la lora?</p>
                <p>la concha de la lora al cuadrado</p>
                <p>la concha de la lora?</p>
                <p>la concha de la lora al cuadrado</p>
            </div>
        </div>
        <div class="d_bordes_flecha"><img id="img_flecha" src="img/flecha.png" alt="flecha" /></div>
    </div>

    <?php require_once APP_ROOT.DS.'pags'.DS.'footer.php'; ?>

    <div id="d_debug">
        <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
        <a href="debug_sess.php">debug_sess.php</a>
        <p id="cargandoJs_generales" class="colRojo">CARGANDO generales.js</p>
        <p id="cargandoJs_registro" class="colRojo">CARGANDO registro.js</p>
    </div>
</div>

<?= htmlGenericos::PrintScripts(null,true,null,true,true,"registro") ?>

</body>
</html>
