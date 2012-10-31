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
        <?php if (!$lo) { ?>
        <div class="d_preg">
            <h1><span class="colVerde">¡</span>registrate bolú<span class="colVerde">!</span></h1>
            <hr class="hr_punteada" />
        </div>

        <div class="d_bordes">
            <div class="d_bordes_contiene">
                <h2>Registrate salamín</h2>

                <form id="f_registro">
                    <table>
                        <tr>
                            <td class="lbl">Apodo</td>
                            <td class="inp"><input type="text" id="inp_apodo" name="inp_apodo" placeholder="apodo" value="" /></td>
                        </tr>
                        <tr>
                            <td id="err_apodo" class="err" colspan="2">ERORRRR!!</td>
                        </tr>

                        <tr>
                            <td class="lbl">E-Mail</td>
                            <td class="inp"><input type="text" id="inp_r_email" name="inp_r_email" placeholder="ej@emp.lo" value="" /</td>
                        </tr>
                        <tr>
                            <td id="err_email" class="err" colspan="2"></td>
                        </tr>

                        <tr>
                            <td class="lbl">Nombre completo</td>
                            <td class="inp"><input type="text" id="inp_nombre" name="inp_nombre" placeholder="Juan Perez" value="" /></td>
                        </tr>
                        <tr>
                            <td id="err_nombre" class="err" colspan="2"></td>
                        </tr>

                        <tr>
                            <td class="lbl">Contraseña</td>
                            <td class="inp">
                                <input type="password" id="inp_r_pass" name="inp_r_pass" class="inpCont" placeholder="Password" value="" />
                                <input type="password" id="inp_r_passR" name="inp_r_passR" class="inpCont" placeholder="Password" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td id="err_pass" class="err" colspan="2"></td>
                        </tr>

                        <tr>
                            <td class="lbl">Sexo</td>
                            <td class="inp">
                                <input type="radio" name="inp_sexo" class="inpRad" value="m" checked="checked" />masculino
                                <input type="radio" name="inp_sexo" class="inpRad" value="f" />femenino
                            </td>
                        </tr>
                        <tr>
                            <td class="err" colspan="2"></td>
                        </tr>

                        <tr>
                            <td class="lbl">Pais</td>
                            <td class="inp">
                                <select id="pais" name="pais">
                                    <?php
                                    if (is_file(APP_ROOT.DS.'inc'.DS.'countries.xml')) {
                                        $countriesXML = simplexml_load_file(APP_ROOT.DS.'inc'.DS.'countries.xml');
                                        foreach ($countriesXML->country as $pais) {
                                            echo "\t\t\t<option" . (($pais == "Argentina")? " SELECTED" : "") . ">$pais</option>\n";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="err" colspan="2"></td>
                        </tr>

                        <tr>
                            <td class="lbl">Teléfono</td>
                            <td class="inp"><input type="text" id="inp_tel" name="inp_tel" placeholder="teléfono" value="" /></td>
                        </tr>
                        <tr>
                            <td id="err_tel" class="err" colspan="2"></td>
                        </tr>

                        <tr>
                            <td class="lbl">Código postal</td>
                            <td class="inp"><input type="text" id="inp_codpostal" name="inp_codpostal" placeholder="código postal" value="" /></td>
                        </tr>
                        <tr>
                            <td id="err_codpostal" class="err" colspan="2"></td>
                        </tr>

                        <tr>
                            <td class="lbl">Enviar formulario puto</td>
                            <td class="inp"><button id="btn_submit">enviar</button></td>
                        </tr>
                        <tr>
                            <td id="err_submit" class="err" colspan="2"></td>
                        </tr>
                    </table>

                    <!--
                    <tr>
                        <td class="lbl"></td>
                        <td class="inp"><input type="text" id="inp_" name="inp_" placeholder="" value="" /></td>
                    </tr>
                    <tr>
                        <td id="err_" class="err" colspan="2"></td>
                    </tr>
                    -->
                </form>
            </div>
        </div>
        <div class="d_bordes_flecha"><img id="img_flecha" src="img/flecha.png" alt="flecha" /></div>

    <?php } else { ?>
        <h1>ya estás registrado salamín</h1>
        <h2>¿¿que carajo hacés acá??</h2>
    <?php } ?>
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
