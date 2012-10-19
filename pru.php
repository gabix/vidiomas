<?php
// <editor-fold desc="init">
require 'config' . DIRECTORY_SEPARATOR . 'init.php';

$usu = new Usuario;
if (Session::get('usu')) {
    //cargo las props en $usu
    $usu->inicio();
} else {
    //hay cookie?
    if (isset($_COOKIE["usu"])) {
        //cookie correcta?
        $rtaLog = $usu->deCookieAsess();
        if ($usu->get_loged()) {
            //redirijo al c_panel
            //weeeeeeeee
        }
    } else {
        // NO LOGED!
    }
}

//defino el lenguaje de la pag
$l = new Lang();


//vars para manejo fácil de la pag
//$lo = $usu->loged();
//$cat = $usu->get_categoria();
//defino el título de la pag
$pagTit = "Pruebas locas";


// </editor-fold>
?>
<!DOCTYPE html>
<html>
    <head>
        <?php $l->crearHeadMetas($pagTit) ?>
        <link rel="stylesheet" type="text/css" href="inc/fonts/fonts.css" />
        <style>
            h1 {text-align: center; color: #0081c2;}
            h2 {color: #57a957;}
        </style>
    </head>
    <body>
        <h1><?= $pagTit ?></h1>
        <hr />

        <h2>pruebas usu</h2>
<?php
$usu = new Usuario();
$ret = "no ret";
if (isset($_GET["log"]) && $_GET["log"] == "log") {
    $ret = $usu->loguear("champi@eo.nn", hash("sha512", "6ZaxN2Vzm9NUJT2y"), true);
}
$lo = $usu->get_loged();
$cat = $usu->get_categoria();
?>
        <form method="get">
            <input type="text" name="log" value="log" />
            <input type="submit" />
        </form>
        <p>ret de logueo: <?php if ($lo) print_r($ret); ?></p>
        <p>Usu apodo: <?= (($lo)? $usu->get_apodo() : ("no log")) ?></p>
        <p>Usu categoria: <?= (($lo)? $usu->get_categoria() : ("no cat")) ?></p>
        <p></p>

        <hr />
        <h2>pruebas ses y cook</h2>
        <p>Hay sess?</p>
        <p>Ses:<br /><?php if (isset($_SESSION)) { print_r($_SESSION); } else { echo "NO sess"; } ?></p>
        <p>Cook:<br /><?php if (isset($_COOKIE)) { print_r($_COOKIE); } else { echo "NO cook"; } ?></p>

        <hr />
        <h2>Pruebas de time y hash(sha512)</h2>
        <form>
            <input type="text" id="ii" name="ii" placeholder="cagate" />
            <p id="pp"></p>
            <input type="submit" id="bb" value="bb"/>
        </form>
        <hr />
        <p>cat admin hasshed: <?php echo hash('sha512', "admin"); ?></p>
        <p>cat admin0 hasshed: <?php echo hash('sha512', " admin"); ?></p>
        <p>cat -01 hasshed: <?php echo hash('sha512', -01); ?></p>

<?php
$t = time();
$tf = date("y-m-d H:i:s", $t);
?>
        <p>fecha $t = time(): <?php printf((int) $t); ?></p>
        <p>fecha de $tf = date("y-m-d H:i:s",$t) <?php printf($tf); ?></p>
        <p>fecha a int: <?php printf(time()); ?></p>
        <?php
        $t = new TEA;
        $enc = $t->encrypt("cacota", "reputa");
        echo "cacota enc: $enc<br>\n";
        $enc = $t->encrypt("1", "reputa");
        echo "1 enc: $enc<br>\n";
        ?>

        <hr />
        <h2>pruebas de Lang Class</h2>

        <p>pru errMsg(usuarioBloqueado): <?= $l->errMsg('usuarioBloqueado') ?></p>
        <p>pru grales(caca): <?= $l->grales('caca') ?></p>
        <p>pru grales(holaUsu): <?= $l->grales('holaUsu') ?></p>
        <p>errMsg('usuarioBloqueado-mailInvalido')--> <?= $l->errMsg('usuarioBloqueado-mailInvalido') ?></p>
        <p>errMsg('usuarioBloqueado-Me cago en dios y la virgen-por dios lo digo-mailInvalido'): <?= $l->errMsg('usuarioBloqueado-Me cago en dios y la virgen-por dios lo digo-mailInvalido') ?></p>
        
        <hr />
        <h2>pruebas de xml</h2>
<?php
$xml = null;
if (file_exists('lang/countries.xml')) {
    echo "<p>countries</p>\n";
    $countriesXML = simplexml_load_file(APP_ROOT.DS.'lang'.DS.'countries.xml');
    //print_r($countriesXML);
    foreach ($countriesXML->country as $pais) {
        echo "\t\t\t\t\t\t<p>$pais</p>\n";
    }
} else {
    exit('Error al abrir el countries.xml');
}
?>

        <p>aca vienen los escripts</p>
        <script type="text/javascript" src="inc/jquery.min.js"></script>
        <script type="text/javascript" src="inc/jquery.validate.min.js"></script>
        <script type="text/javascript" src="inc/sha512.js"></script>
        <script type="text/javascript">

        </script>
    </body>
</html>