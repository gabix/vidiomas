<?php
require_once '../config/init.php';

function redirect() {
    $entNom = "";
    if (Session::get('entradaActiva')) {
        $entNom = Session::get('entradaActiva');
        $entNom = $entNom->get('nombre');
    }
    header("location: ".APP_URL_ROOT. "/fully.php?nom=$entNom");
    exit();
}

if (Session::get('entradaActiva')) {
    if (isset($_POST['comId'])) {
        //TODO: validar usuario logueado, y usuario con privilegios

        $entNom = Session::get('entradaActiva');
        if (BlogEntrada::Validar('nombre', $entNom->get('nombre'))) {
            $entNom = $entNom->get('nombre');
        } else {
            Debuguie::AddMsg("p_blogComentarios", "nombre inválido", "warning");
            die("Pedido invalido");
        }

        $comId = null;
        if (BlogEntrada::Validar('comId', $_POST['comId'])) {
            $comId = (int) $_POST['comId'];
        } else {
            Debuguie::AddMsg("p_blogComentarios", "comId inválido", "warning");
            die("Pedido invalido");
        }

        if (isset($_POST['eliminar'])) {
            $BCom = new BlogComentarios($entNom);

            //eliminar/restaurar
            $BCom->EliminarRestaurarComentario($comId);

            //ELIMINADO/RESTAURADO
            redirect();
        }

        if (isset($_POST['txt'])) {
            $usuId = null; //en realidad lo saco de session
            if (BlogEntrada::Validar('usuId', 1)) {
                $usuId = (int) 1; //TODO: DE SESSION['usuId'];
            } else {
                Debuguie::AddMsg("p_blogComentarios", "usuId inválido", "warning");
                die("Pedido invalido");
            }

            $txt = null;
            if (BlogEntrada::Validar('txt', $_POST['txt'])) {
                $txt = BlogEntrada::ElimiarScriptsDeStr($_POST['txt']);
            } else {
                Debuguie::AddMsg("p_blogComentarios", "txt inválido", "warning");
                die("Pedido invalido");
            }

            $BCom = new BlogComentarios($entNom);

            if ($comId == 0) {
                //agregar
                $BCom->AgregarComentario($usuId, $txt);

                //agregado
                redirect();
            }

            //modificar
            $BCom->ModificarComentario($comId, $txt);
            redirect();
        }

        Debuguie::AddMsg("p_blogComentarios", "post txt o eliminar no seteado", "error");
        die("Pedido invalido");
    } else {
        Debuguie::AddMsg("p_blogComentarios", "post comId no seteado", "error");
        die("Pedido invalido");
    }
} else {
    Debuguie::AddMsg("p_blogComentarios", "no sess-entradaActiva", "error");
    die("Pedido invalido");
}