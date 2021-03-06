<?php
// <editor-fold desc="pag init">
require_once 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$lo = $usu->logueado();
$cat = $usu->get('categoria');

//defino el lenguaje de la pag
$l = new Lang;

//defino el título de la pag
$selPag = "viajar";
$pagTit = $l->grales($selPag);

// </editor-fold>
?>
<!DOCTYPE html>
<html>
<head>
    <?= $l->crearHeadMetas($pagTit) ?>
    <link rel="stylesheet" type="text/css" href="inc/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="inc/generales.css" />
    <link rel="stylesheet" type="text/css" href="inc/viajar.css" />
</head>
<body>
<div id="d_superContenedor">
    <?php include APP_ROOT.DS."pags".DS."header.php"; ?>
    <?php include APP_ROOT.DS."pags".DS."botonera.php"; ?>

    <div id="d_cuerpo">
        <div id="d_preg">
            <h1><span class="colVerde">¿</span>VAS A VIAJAR<span class="colVerde">?</span></h1>
            <hr class="hr_punteada" />
            <ul class="ul_paises">
                <li>ESPAÑA</li>
                <li>ARGENTINA</li>
                <li>URUGUAY</li>
                <li>CHILE</li>
            </ul>
        </div>
        <div class="d_bordeado">
            <div id="d_contEspaña" class="d_innBordeado">
                <h2>¡ESPAÑA Y OLÉ!<img class="img_pajaroViajar" src="img/noimg.png" alt="pajaro" /></h2>

                <p>España, también denominado Reino de España, es un país soberano, miembro de la Unión Europea, constituido en Estado social y democrático de derecho y cuya forma de gobierno es la monarquía parlamentaria. Su territorio está organizado en 17 comunidades autónomas y dos ciudades autónomas con capital en Madrid.</p>
                <p class="cl"></p>
                <img class="img_valijaMarron" src="img/noimg.png" alt="valija" />
                <h3>PREPARANDO EL VIAJE</h3>
                <ul>
                    <li>Punteo de recomendaciones</li>
                    <li>Punteo de recomendaciones</li>
                </ul>
                <h3>¡RECORRIENDO LA CIUDAD!</h3>
            </div>
        </div>
    </div>

    <?php include APP_ROOT.DS.'pags'.DS.'footer.php'; ?>

    <div id="d_debug">
        <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
        <a href="debug_sess.php">debug_sess.php</a>
        <p id="cargandoJs_generales" class="colRojo">CARGANDO generales.js</p>
        <p id="cargandoJs_enBebido" class="colRojo">CARGANDO script en bebido</p>
    </div>
</div>

<?= htmlGenericos::PrintScripts(null,true,null,true,true,null) ?>


</body>
</html>