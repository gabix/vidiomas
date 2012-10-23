<?php
require_once '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'init.php';

if (isset($_POST["inp_email"]) && isset($_POST["inp_passEnc"])) {
    if (!preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/', $_POST["inp_email"])) {
        SuperFuncs::errYmsg(true, 'mailInvalido');
        exit();
    }
    $usu = new Usuario;
    
    $email = $_POST["inp_email"];
    $pass = $_POST["inp_passEnc"];
    $cookie = false;
    if (isset($_POST["chk_recordame"]) && $_POST["chk_recordame"]) {
        $cookie = true;
    }
    
    //SuperFuncs::debuguie("p_loguin", '$usu->loguear(' . "mail: $email, pass: $pass, coo: $cookie)");
    $rta = $usu->loguear($email, $pass, $cookie);
    
    echo json_encode($rta);
} else {
    // The correct POST variables were not sent to this page.
    SuperFuncs::errYmsg(true, 'pedidoInvalido');
}
