<?php
require_once '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'init.php';

Debuguie::AddMsg("p_login", "", "fInit");

if (isset($_POST["inp_email"]) && isset($_POST["inp_passEnc"])) {
    if (!preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/', $_POST["inp_email"])) {
        Debuguie::AddMsg("p_login", "mail invalido", "info");

        echo SuperFuncs::errYmsg(true, 'emailInvalido');
        exit();
    }
    $usu = new Usuario;
    
    $email = $_POST["inp_email"];
    $pass = $_POST["inp_passEnc"];
    $cookie = false;
    if (isset($_POST["chk_recordame"]) && $_POST["chk_recordame"]) {
        $cookie = true;
    }
    
    $rta = $usu->loguear($email, $pass, $cookie);

    Debuguie::AddMsg("p_login", "rta=(".json_encode($rta).")", "success");
    echo json_encode($rta);
} else {
    Debuguie::AddMsg("p_login", "pedido invalido", "info");

    // The correct POST variables were not sent to this page.
    echo SuperFuncs::errYmsg(true, 'pedidoInvalido');
}
