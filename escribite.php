<?php
require_once 'config' . DIRECTORY_SEPARATOR . 'init.php';

$pagTitle = "escribite";

//validar que el usu de sess y la cat de sess lo permiten... sino EXIT();

$editar = false;
$ent = null;
if (isset($_GET['editar']) && $_GET['editar'] == "true") {
    $editar = true;
    if (isset($_GET['nom'])) {
        if (BlogEntrada::Validar('nombre', $_GET['nom']) != 1) {
            Debuguie::AddMsg("escribite.php", "GET nom inválido", "warning");
            exit();
        }

        $ent = new BlogEntrada();
        if ($ent->LlenarDB_entradaXnombre($_GET['nom'])) {
            if (isset($_GET['eliminarestaurar']) && $_GET['eliminarestaurar'] == "true") {
                if ($ent->EliminarRestaurarDB_entrada()) {
                    Debuguie::AddMsg("escribite.php", "Eliminar/Restaurar success", "success");
                } else {
                    Debuguie::AddMsg("escribite.php", "falló Eliminar/Restaurar", "error");
                }
                redirect($ent->get('nombre'));
                exit();
            }
        } // else nom no esiste
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <?= "<title>$pagTitle</title>\n" ?>
        <link rel="stylesheet" type="text/css" href="othersLib/bootstrap.css" />
        <style>
            .titti {
                text-align: center;
                color: #006dcc;
            }

            .supCont {
                margin-left: auto;
                margin-right: auto;
                width: 1024px;
            }

            .d_controles {
                text-align: center;
            }

            .dispNone {
                display: none;
            }
            .dispBlock {
                display: block;
            }
        </style>
    </head>
    <body>
        <div class="supCont">
            <h1 class="titti"><?= $pagTitle ?></h1>
            <hr />
            
            <form id="f_escribite" method="post" action="proc/p_blogEntrada.php">
                <input name="accion" type="hidden" value="<?= (($editar) ? 'editar' : 'nuevo') ?>" />

                <div id="d_titulo" class="d_controles control-group input-prepend">
                    <label id="lbl_titulo_error" class="dispNone">ERROR </label>
                    <span class="add-on"><i class="icon-star"></i> T&iacute;tulo: </span>
                    <input type="text" class="span9" id="txt_titulo" name="txt_titulo" placeholder="t&iacute;tulo" 
                           <?= (($editar) ? 'value="' . $ent->get('titulo') . '"' : "") ?> />
                </div>

                <div id="d_txt" class="d_controles control-group">
                    <label id="lbl_txt_error" class="dispNone">ERROR </label>
                    <textarea name="txt_txt" style="width:100%;height:500px;">
                        <?php
                        if ($editar) {
                            $ent->PrintEntrada();
                        } else {
                            echo "Entrada nueva";
                        }
                        ?>
                    </textarea><br />
                </div>

                <div id="d_nombre" class="d_controles control-group input-append input-prepend">
                    <label id="lbl_nombre_error" class="dispNone">ERROR </label>
                    <span class="add-on"><i class="icon-file"></i></span>
                    <?php if ($editar) { ?>
                        <input type="text" class="span4" disabled value="<?= $ent->get('nombre') ?>" />
                        <input type="hidden" name="txt_nombre" value="<?= $ent->get('nombre') ?>" />
                    <?php } else { ?>
                        <input type="text" class="span4" id="txt_nombre" name="txt_nombre" placeholder="filename" />
                    <?php } ?>
                    <button id="btn_submit" name="btn_submit" class="btn"><i class="icon-ok"></i> Save</button>
                    <button type="reset" id="btn_reset" class="btn"><i class="icon-remove"></i> Reset</button>
                </div>
            </form>
        </div>
        <?= ((DEBUGUEANDO) ? Debuguie::PrintMsgs() : "") ?>

        <script type="text/javascript" src="othersLib/jquery.min.js"></script>
        <script type="text/javascript" src="othersLib/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">
            tinyMCE.init({
                mode : "textareas",
                theme : "advanced",
                plugins: "autolink,lists,style,table,inlinepopups,preview,media,contextmenu,paste,fullscreen,advlist,jbimages",
                dialog_type : "modal",
                
                theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,sub,sup,|,forecolor,backcolor,|,removeformat",
                theme_advanced_buttons2 : "undo,redo,|cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,charmap,hr,link,unlink,jbimages,image,media,cleanup,code,|,preview,fullscreen",
                theme_advanced_buttons3 : "tablecontrols",
                
                theme_advanced_toolbar_location : "top",
                theme_advanced_toolbar_align : "center",
                theme_advanced_resizing : false,
                
                relative_urls : true
            });

            function MostrarErrorEn(msg, control) {
                var lblErr = $('#lbl_'+control+'_error');
                var divC = $('#d_'+control);

                lblErr.html(msg);
                if (msg != "") {
                    divC.addClass('error');
                    lblErr.removeClass('dispNone');
                } else {
                    divC.removeClass('error');
                    lblErr.addClass('dispNone');
                }
            }

            function ValidaNombre(){
                var err = true;
                var msg = "";
                
                var filtro = /^([0-9a-zA-Z\-]{1,75})$/;
                var nom = $('#txt_nombre');
                
                if (nom.val() == '') {
                    msg = "el nombre del archivo no puede estar vacio ";
                   
                } else if(!filtro.test(nom.val())) {
                    msg = 'el nombre del archivo solo puede tener caracteres simples y "-" (ni acentos ni ñs) ';
                    
                } else {
                    err = false;
                }
                
                MostrarErrorEn(msg, 'nombre');
                return err;
            }
            
            function ValidaTitulo(){
                var err = true;
                var msg = "";
                
                var tit = $('#txt_titulo');
                
                if (tit.val() == '') {
                    msg = "el t&iacute;tulo no puede estar vacio ";
                   
                } else if(tit.val().length > 200 || tit.val().length < 2) {
                    msg = 'el t&iacute;tulo debe tener entre 2 y 200 caracteres ';
                    
                } else {
                    err = false;
                }
                
                MostrarErrorEn(msg, 'titulo');
                return err;
            }
            
            function ValidaTxt() {
                var err = true;
                var msg = "";
                
                var txt = tinyMCE.get('txt_txt').getContent();
                
                var filtros = [/(<([^>]+)>)/ig, / |&nbsp;/ig, /\r\n|\r|\n/g];
                for(var i in filtros) {
                    txt = txt.replace(filtros[i], "");
                }
                
                if (txt.length > 2) {
                    err = false;
                } else {
                    msg = 'Debe escribir al menos 2 caracteres';
                }
                
                MostrarErrorEn(msg, 'txt');
                return err;
            }
            
            $('#txt_nombre').keyup(function() {
                ValidaNombre()
            });
            $('#txt_titulo').keyup(function() {
                ValidaTitulo()
            });
            
            $('#btn_submit').on('click', function(evt){
                evt.stopImmediatePropagation();
                evt.preventDefault();
                
                if ((ValidaNombre() == false) && (ValidaTitulo() == false) && (ValidaTxt() == false)) {
                    $('#txt_nombre');
                    $('#f_escribite').submit();
                }
            });
        </script>
    </body>
</html>