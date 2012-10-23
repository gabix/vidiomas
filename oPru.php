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
$selPag = "oPru";
$pagTit = $l->grales($selPag);
// </editor-fold>
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
        <hr/>

        <?php
        if (isset($_POST['si']) && $_POST['si'] == "si") {
            $ret = Cookie::set('almacen', 'miMamaMeMima');
            ?><p class="lefteame">estoy seteando!! ret=(<?= $ret ?>)</p><?php
        }
        if (isset($_POST['kill']) && $_POST['kill'] == "kill") {
            $ret = Cookie::kill('almacen');
            ?><p class="lefteame">estoy matando!! ret=(<?= $ret ?>)</p><?php
        }

        $getIl = Cookie::get('almacen');
        ?>
        <p>Prueba de alamc&eacute;n de cookie getIl=(<?= $getIl ?>)</p>

        <form class="centrame" method="post" action="oPru.php">
            <input type="submit" name="si" value="si" />
            <input type="submit" name="kill" value="kill" />
        </form>

        <p class="cl"></p>
    </div>

    <?php require_once APP_ROOT.DS.'pags'.DS.'footer.php'; ?>

    <div id="d_debug">
        <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
        <a href="debug_sess.php">debug_sess.php</a>
        <p id="cargandoJs_generales" class="colRojo">CARGANDO generales.js</p>
        <p id="cargandoJs_enBebido" class="colRojo">CARGANDO script en bebido</p>
    </div>
</div>

<?= htmlGenericos::PrintScripts(null,true,null,true,true,null) ?>

<script type="text/javascript">
    JsCargado($('#cargandoJs_enBebido'), 'script de la pag en Bebido.js')
</script>

<?= ((DEBUGUEANDO) ? Debuguie::PrintMsgs() : "") ?>

</body>
</html>
