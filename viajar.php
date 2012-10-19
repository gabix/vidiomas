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
$selPag = "viajar";
$pagTit = $l->grales($selPag);

// </editor-fold>
?>
<!DOCTYPE html>
<html>
    <head>
<?php $l->crearHeadMetas($pagTit) ?>
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

            <div id="debug">
                <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
                <p id="pru">CARGANDO JS</p>
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