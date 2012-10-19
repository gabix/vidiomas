<?php
require_once 'config/init.php';

$pagTitle = "fully";

$ents = new BlogEntradas();

$selEnt = new BlogEntrada();
if (isset($_GET['nom'])) {
    if ($ents->ValidarEntradaXnombre($_GET['nom'])) {
        $selEnt = $ents->entradaActiva;
    }
}
$selEnt = $ents->entradaActiva;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= $pagTitle ?></title>
        <link rel="stylesheet" type="text/css" href="othersLib/bootstrap.css" />

        <style type="text/css">
            .d_comentario {
                padding: 5px;
            }
            .comEliminado {
                color: #8b0000;
                font-weight: bold;
                font-style: italic;
            }
            .d_sobreComentario {
                text-align: right;
                margin: 0;
                padding: 5px;
                border-bottom: 1px dashed grey;
            }
            .d_superEnt {
                text-align: right;
                margin: 0;
                padding: 5px;
            }
            .d_entrada {
                text-align: left;
            }
            .errorLook {
                color: #800000;
                font-style: italic;
            }
            #controles {
                margin-top: 5px;
                padding-top: 5px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div id="barra" class="span3 well well-small">
                    <ul class="nav nav-list">
                        <li class="nav-header">Entradas del Blog</li>
                        <?php foreach ($ents->entradas as $ent) { ?>
                            <li <?= (($ent == $ents->entradaActiva) ? 'class="active"' : "") ?>>
                                <a href="fully.php?nom=<?= $ent->get('nombre') ?>"><?= (($ent->get('visible') != 1)? '<span class="errorLook">'.$ent->get('titulo').'</span>' : $ent->get('titulo')) ?></a>
                            </li>
                        <?php } ?>
                        <li class="divider"></li>
                        <li><a href="escribite.php"><i class="icon-plus-sign"></i> nueva entrada</a></li>
                    </ul>
                </div>

                <div id="conte" class="span9">
                    <h1 style="text-align: center;"><?= $pagTitle ?> - El super blog!</h1>
                    <hr />

<div class="d_superEnt">
    <h2><?= (($selEnt->get('visible') != 1)? '<span class="errorLook">ENTRADA NO VISIBLE </span>'.$selEnt->get('titulo') : $selEnt->get('titulo')) ?></h2>
    <small>por (usuId) <?= $selEnt->get('usuId') ?></small> <em class="muted"><?= date('l jS \- F Y h:i:s A', $selEnt->get('usuId')) ?></em>
    <a href="escribite.php?nom=<?= $selEnt->get('nombre') ?>&editar=true" class="btn"><i class="icon-pencil"></i> editar</a>
    <a href="proc/p_blogEntrada.php?nom=<?= $selEnt->get('nombre') ?>&accion=eliminarestaurar" class="btn">
        <?= (($selEnt->get('visible') != 1)? '<i class="icon-repeat"></i> restaurar' : '<i class="icon-remove"></i> eliminar') ?>
    </a>

    <p style="clear: both"></p>
    <div class="d_entrada well">
        <?php $selEnt->PrintEntrada(); ?>
    </div>
</div>
<?php
$selEnt->LlenarComentarios();
foreach ($selEnt->get('comentarios') as $c) { 
    if ($c['visible'] == 1) { ?>
<div class="d_comentarios well">
    <div class="d_sobreComentario">
        <p><i>dijo</i> <?= $c['usuId'] ?> <i>el</i> <?= date("l jS \- F Y h:i:s A", $c['time']) . "\n" ?>
            <button id="comId<?= $c['comId'] ?>" class="btn btn-small btn_comentario"><i class="icon-pencil"></i> edit</button>
            <button id="eliminar<?= $c['comId'] ?>" class="btn btn-small btn_eliminar"><i class="icon-remove"></i> elimiar</button></p>
    </div>
    <div id="d_comId<?= $c['comId'] ?>" class="d_comentario">
        <?= $c['txt'] . "\n" ?>
    </div>
</div>
<?php } else { //si uno es admin puede restaurar comentarios ?>
<div class="d_comentarios well">
    <div class="d_sobreComentario">
        <p><b>COMENTARIO ELIMINADO</b> <i>dijo</i> <?= $c['usuId'] ?> <i>el</i> <?= date("l jS \- F Y h:i:s A", $c['time']) . "\n" ?>
            <button id="comId<?= $c['comId'] ?>" class="btn btn-small btn_comentario"><i class="icon-pencil"></i> edit</button>
            <button id="eliminar<?= $c['comId'] ?>" class="btn btn-small btn_eliminar"><i class="icon-repeat"></i> restaurar</button></p>
    </div>
    <div id="d_comId<?= $c['comId'] ?>" class="d_comentario">
        <p class="comEliminado">COMENTARIO ELIMINADO</p>
        <?= $c['txt'] . "\n" ?>
    </div>
</div>
<?php } } ?>
<div class="d_comentarios well">
    <div class="d_sobreComentario">
        <p><i>comentate esta cacho</i>
            <button id="comId0" class="btn btn-small btn_comentario"><i class="icon-pencil"></i> comentar</button></p>
    </div>
    <div id="d_comId0" class="d_comentario">
    </div>
</div>

<div class="pagination">
    <ul>
        <li><a href="#">Prev</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">Next</a></li>
    </ul>
</div>


                </div>
            </div>
        </div>
        <hr />
        <p>FINito</p>
<?= ((DEBUGUEANDO) ? Debuguie::PrintMsgs() : "") ?>
        <script type="text/javascript" src="othersLib/jquery.min.js"></script>
        <script type="text/javascript" src="othersLib/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">
            var activeTxt = "";
            
            $('.btn_eliminar').on('click', function(evt){
                evt.stopImmediatePropagation();
                evt.preventDefault();
                
                if ($(this).hasClass('disabled')) {
                    return false;
                }
                
                var comId = ($(this).attr('id')).replace('eliminar','');
                
                var f_eliminar = "";
                f_eliminar += '<form id="f_eliminar" method="post" action="proc/p_blogComentarios.php">';
                f_eliminar += '    <input name="comId" type="hidden" value="'+comId+'" />';
                f_eliminar += '    <input name="eliminar" type="hidden" value="eliminar" />';
                f_eliminar += '</form>';
                
                $('#d_comId'+comId).append(f_eliminar);
                
                $('#f_eliminar').submit();
            });
            
            $('.btn_comentario').on('click', function(evt){
                evt.stopImmediatePropagation();
                evt.preventDefault();
                
                if ($(this).hasClass('disabled')) {
                    return false;
                }

                var comId = ($(this).attr('id')).replace('comId','');
                CambiameLosBotonesCacho(comId);
            });
            
            function CambiameLosBotonesCacho(comId) {
                var btn = $('#comId'+comId);

                $('.btn_eliminar').toggleClass('disabled');
                $('.btn_comentario').toggleClass('disabled');

                if (btn.html() == '<i class="icon-remove"></i> cancel') {
                    //caso cancel
                    if (comId == 0) {
                        btn.html('<i class="icon-pencil"></i> comentar');
                    } else {
                        btn.html('<i class="icon-pencil"></i> editar');
                    }
                    btn.toggleClass('disabled');

                    DeshabilitameElEditCacho(comId);

                } else {
                    //caso edit || comentar
                    btn.html('<i class="icon-remove"></i> cancel');
                    btn.toggleClass('disabled');
                    
                    HabilitameElEditCacho(comId);
                    tinyMCEinit();
                }
            }
            
            function HabilitameElEditCacho(comId) {
                var div = $('#d_comId'+comId);
                
                activeTxt = div.html();
                div.html("");
                
                var ret = "";
                ret += '<form id="f_comentario" method="post" action="proc/p_blogComentarios.php">';
                ret += ' <textarea id="txt" name="txt" style="width:100%; height:200px;">';
                ret += '  '+activeTxt;
                ret += ' </textarea>';
                ret += ' <input name="comId" type="hidden" value="'+comId+'" />';
                ret += ' <div id="controles" class="control-group input-append">';
                ret += '  <label id="lbl_error" class="errorLook"></label>';
                ret += '  <button id="btn_submit" type="submit" class="btn"><i class="icon-ok"></i> Save</button>';
                ret += '  <button id="btn_reset" type="reset" class="btn"><i class="icon-remove"></i> Reset</button>';
                ret += ' </div>';
                ret += '</form>';
                
                div.append(ret);
                
                $('#btn_submit').on('click', function(evt){
                    evt.stopImmediatePropagation();
                    evt.preventDefault();
                    
                    var txt = tinyMCE.get('txt').getContent();
                    
                    var filtros = [/(<([^>]+)>)/ig, / |&nbsp;/ig, /\r\n|\r|\n/g];
                    for(var i in filtros) {
                        txt = txt.replace(filtros[i], "");
                    }
                    
                    if (txt.length > 2) {
                        $('#f_comentario').submit();
                    } else {
                        $('#lbl_error').html('Debe escribir al menos 2 caracteres para comentar');
                    }
                });
            }
            
            function DeshabilitameElEditCacho(comId) {
                var div = $('#d_comId'+comId);
                div.html('');
                div.html(activeTxt);
            }

            function tinyMCEinit(){
                tinyMCE.init({
                    mode : "textareas",
                    theme : "advanced",
                    plugins: "autolink,lists,style,table,inlinepopups,preview,contextmenu,paste,fullscreen,advlist",
                    dialog_type : "modal",
                
                    theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,sub,sup,|,forecolor,backcolor,|,removeformat",
                    theme_advanced_buttons2 : "undo,redo,|cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,charmap,hr,link,unlink,cleanup,code,|,preview,fullscreen",
                    theme_advanced_buttons3 : "tablecontrols",
                
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "center",
                    theme_advanced_resizing : false
                });
            }
            
        </script>
    </body>
</html>