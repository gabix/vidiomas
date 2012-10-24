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
$selPag = "registro";
$pagTit = $l->grales($selPag);
// </editor-fold>
?>
<!DOCTYPE html>
<html>
<head>
    <?php $l->crearHeadMetas($pagTit) ?>
    <link rel="stylesheet" type="text/css" href="inc/fonts/fonts.css" />
    <link rel="stylesheet" type="text/css" href="inc/generales.css" />
    <link rel="stylesheet" type="text/css" href="inc/registro.css" />
</head>
<body>
<div id="d_superContenedor">
    <?php include APP_ROOT.DS."pags".DS."header.php"; ?>
    <?php include APP_ROOT.DS."pags".DS."botonera.php"; ?>

    <div id="d_cuerpo">
        <div class="d_preg">
            <h1><span class="colVerde">¿</span>te querés registrar bolu<span class="colVerde">?</span></h1>
            <hr class="hr_punteada" />
        </div>

        <div class="d_bordes">
            <div class="d_bordes_contiene">
                <h2>Registrate salamín</h2>
                <form id="form_register" method="post">
                    <p>Los campos que tienen * son obligatorios</p>
                    <p>* Apodo
                        <input id="apodo" name="apodo" type="text" placeholder="apodo" value="" />
                    </p>
                    <p>* email
                        <input id="email" name="email" type="text" placeholder="ej@emp.lo" value="" />
                    </p>
                    <p>* Nombre completo
                        <input id="nombre" name="nombre" type="text" placeholder="Juan Perez" value="" />
                    </p>
                    <p>* contraseña
                        <input type="password" id="pass" name="pass" placeholder="Password" value="" />
                    </p>
                    <p>* repita su contraseña
                        <input type="password" id="rpass" name="rpass" placeholder="repeat password" value="" />
                    </p>
                    <p>* pais
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
                    </p>
                    <p>* sexo
                        masculino<input type="radio" name="sexo" value="masculino" checked="checked" />
                        femenino<input type="radio" name="sexo" value="femenino" />
                    </p>
                    <p>teléfono
                        <input name="tel" type="text" placeholder="telefono" value="" />
                    </p>
                    <p>código postal
                        <input name="codPostal" type="text" placeholder="5411" value="" />
                    </p>
                    <p><input name="submit" value="enviar" type="submit" /></p>

                </form>
            </div>
        </div>
        <div class="d_bordes_flecha"><img id="img_flecha" src="img/flecha.png" alt="flecha" /></div>

    </div>

    <?php include APP_ROOT.DS.'pags'.DS.'footer.php'; ?>

    <div id="d_debug">
        <p>-testeate-> Username: champEOn | Email: champi@eo.nn | Password: 6ZaxN2Vzm9NUJT2y</p>
        <a href="debug_sess.php">debug_sess.php</a>
        <p id="cargandoJs_generales" class="colRojo">CARGANDO generales.js</p>
        <p id="cargandoJs_enBebido" class="colRojo">CARGANDO script en bebido</p>
    </div>
</div>

<?= htmlGenericos::PrintScripts(null,true,true,true,true,null) ?>

<script type="text/javascript">
    // -- Funcs -- \\

    // -- Validator extended -- \\
    $.validator.addMethod("buga", function(value) {
        return value == "buga";
    }, 'Please enter "buga"!');

    // -- Init -- \\
    $(function(){
        $('#form_register').validate({
            rules: {
                'apodo': {required: true, minlength: 5, maxlenght: 30},
                'email': {required: true, email: true},
                'nombre': {required: true, minlength: 3, maxlenght: 50},
                'pass': {required: true, minlength: 5, maxlenght: 25},
                'rpass': {required: true, minlength: 5, maxlenght: 25, equalTo: "#pass"},
                'tel': {minlength: 5, maxlenght: 50},
                'codPostal': {minlength: 2, maxlenght: 50},
            },
            messages: {
                apodo: {
                    required: "<?= $l->errMsg('apodoRequerido') ?>",
                    minlenght: "<?= $l->errMsg('apodoMin') ?>",
                    maxlenght: "<?= $l->errMsg('apodoMax') ?>"
                },
                email: "<?= $l->errMsg('mailInvalido') ?>",
                nombre: {
                    required: "<?= $l->errMsg('nombreRequerido') ?>",
                    minlenght: "<?= $l->errMsg('nombreMin') ?>",
                    maxlenght: "<?= $l->errMsg('nombreMax') ?>"
                },
                pass: {
                    required: "<?= $l->errMsg('passVacia') ?>",
                    minlength: "<?= $l->errMsg('passMin') ?>",
                    maxlenght: "<?= $l->errMsg('passMax') ?>"
                },
                rpass: {
                    required: "<?= $l->errMsg('passVacia') ?>",
                    minlength: "<?= $l->errMsg('passMin') ?>",
                    maxlenght: "<?= $l->errMsg('passMax') ?>",
                    equalTo: "<?= $l->errMsg('passDesigual') ?>"
                },
                tel: {
                    minlength: "<?= $l->errMsg('telMin') ?>",
                    maxlenght: "<?= $l->errMsg('telMax') ?>"
                },
                codPostal: {
                    minlength: "<?= $l->errMsg('codpostalMin') ?>",
                    maxlenght: "<?= $l->errMsg('codpostalMax') ?>"
                }
            },
            submitHandler: function(form){
                alert('El formulario ha sido validado correctamente!');
            }
        });

        JsCargado($('#cargandoJs_enBebido'), 'script de la pag en Bebido.js')
    });
</script>

<?= ((DEBUGUEANDO) ? Debuguie::PrintMsgs() : "") ?>

</body>
</html>