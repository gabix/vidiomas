<?php
// <editor-fold desc="pag init">
require_once 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$lo = $usu->logueado();
$cat = $usu->get('categoria');

//defino el lenguaje de la pag
$l = new Lang;

//defino el título de la pag
$selPag = "oPru";
$pagTit = $l->grales($selPag);
// </editor-fold>
?>
<!DOCTYPE html>
<html>
<head>
    <?= $l->crearHeadMetas($pagTit) ?>
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
    <?php // require_once APP_ROOT.DS."pags".DS."header.php"; ?>
    <?php // require_once APP_ROOT.DS."pags".DS."botonera.php"; ?>

    <div id="d_cuerpo">
        <h1><?=$pagTit?></h1>
        <p>oPru es un super-duper template</p>
        <p>si</p>
        <hr/>





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

</body>
</html>

<?php
/*
<?php //esto funca
        $arr = array('cen' => "loloLeLulaLila", 'nac' => "LulaLilaLoloLe?");
        $arrKeys = array('cen', 'nac');

        if (isset($_POST['si']) && $_POST['si'] == "si") {
            foreach($arr as $k => $v) {
                $cooName = 'alma_'.$k;
                $ret = Cookie::set($cooName, $v);
                ?><p class="lefteame">estoy seteando!! ret=(<?= $ret ?>)</p><?php
            }

        }

        if (isset($_POST['kill']) && $_POST['kill'] == "kill") {
            foreach ($arrKeys as $k) {
                $cooName = 'alma_'.$k;
                $ret = Cookie::kill($cooName);
                ?><p class="lefteame">estoy matando!! ret=(<?= $ret ?>)</p><?php
            }
        }

        $getIl = Cookie::get('alma');
        if (isset($getIl) && is_array($getIl)) {
            foreach ($arrKeys as $k) {
                ?><p>Prueba de alma de cookie getIl=(<?= $getIl[$k] ?>)</p><?php
            }
        } else {
            ?><p>Prueba de alma de cookie getIl no seteado</p><?php
        }
        ?>


        <form class="centrame" method="post" action="oPru.php">
            <input type="submit" name="si" value="si" />
            <input type="submit" name="kill" value="kill" />
        </form>



<?php //esto funca
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
*/
?>