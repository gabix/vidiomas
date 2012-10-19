<?php

require_once '../config/init.php';

function redirect($entNom) {
    header("location: ".APP_URL_ROOT. "/fully.php?nom=$entNom");
    exit();
}

// validar usuario y categoría!!
//eliminar/restaurar
if (isset($_GET['nom']) && isset($_GET['accion'])) {
    if (BlogEntrada::Validar('nombre', $_GET['nom']) != 1) {
        Debuguie::AddMsg("escribite.php", "GET nom inválido", "warning");
        exit("pedido inv&aacute;lido");
    }

    if ($_GET['accion'] == "eliminarestaurar") {
        $ent = new BlogEntrada();
        if ($ent->LlenarDB_entradaXnombre($_GET['nom'])) {
            if ($ent->EliminarRestaurarDB_entrada()) {
                Debuguie::AddMsg("escribite.php", "Eliminar/Restaurar success", "success");
            } else {
                Debuguie::AddMsg("escribite.php", "falló Eliminar/Restaurar", "error");
            }
            redirect($ent->get('nombre'));
        }
    } else {
        Debuguie::AddMsg("escribite.php", "GET accion inválido", "warning");
        exit("pedido inv&aacute;lido");
    }
}

if (isset($_POST['accion']) && isset($_POST['txt_txt']) && isset($_POST['txt_nombre']) && isset($_POST['txt_titulo'])) {
    $nombre = $_POST['txt_nombre'];
    if (BlogEntrada::Validar('nombre', $nombre) != 1) {
        Debuguie::AddMsg("escribite.php", "POST nom ($nom) inválido", "warning");
        exit("pedido inv&aacute;lido");
    }

    $titulo = SuperFuncs::htmlent($_POST['txt_titulo']);
    if (BlogEntrada::Validar('titulo', $titulo) != 1) {
        Debuguie::AddMsg("escribite.php", "POST titulo ($titulo) inválido", "warning");
        exit("pedido inv&aacute;lido");
    }

    $txt = $_POST['txt_txt'];
    if (BlogEntrada::Validar('txt', $txt) != 1) {
        Debuguie::AddMsg("escribite.php", "POST txt inválido", "warning");
        exit("pedido inv&aacute;lido");
    }

    $ent = new BlogEntrada();
    if ($_POST['accion'] == "nuevo") {
        $ent->set('nombre', $nombre);
        $ent->set('titulo', $titulo);
        $ent->set('visible', 1);
        $ent->set('timeCreated', time());
        $ent->set('usuId', 1); //TODO: USUIDDDDDD!!!!!!

        if ($ent->Crear_entrada($txt)) {
            Debuguie::AddMsg("escribite.php", "Modificar entrada success", "success");
        } else {
            Debuguie::AddMsg("escribite.php", "Modificar entrada falló", "error");
        }
        
    } elseif ($_POST['accion'] == "editar") {
        if ($ent->LlenarDB_entradaXnombre($nombre)) {
           
            if ($ent->Modificar_entrada($txt, $titulo)) {
                Debuguie::AddMsg("escribite.php", "Modificar entrada success", "success");
            } else {
                Debuguie::AddMsg("escribite.php", "Modificar entrada falló", "error");
            }
        }
    }
    redirect($nombre);
} else {
    Debuguie::AddMsg("escribite.php", "".  var_dump($_POST) , "info");
}
echo ((DEBUGUEANDO) ? Debuguie::PrintMsgs() : "");
exit("pedido inv&aacute;lido");