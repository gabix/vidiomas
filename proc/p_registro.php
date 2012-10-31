<?php
require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'init.php';

$err = true;
Debuguie::AddMsg("p_registro", "", "fInit");

if (isset($_POST['inp_apodo']) && isset($_POST['inp_r_email'])) {
    $apodo = SuperFuncs::EliminarTagsDeStr($_POST['inp_apodo']);
    $email = SuperFuncs::EliminarTagsDeStr($_POST['inp_r_email']);

    Debuguie::AddMsg("p_registro", "apodo=($apodo), email=($email)", "info");

    $retVal['apodo'] = SuperFuncs::Validar("Min3|Max50", $apodo);
    $retVal['email'] = SuperFuncs::Validar("Min6|Max50|email", $email);
    Debuguie::AddMsg("p_registro", "retVal=(".json_encode($retVal).")", "info");

    echo json_encode($retVal);

    //$usu = new Usuario;


    if (isset($_POST['inp_nombre']) && isset($_POST['inp_r_passEnc']) && isset($_POST['inp_sexo']) &&
        isset($_POST['inp_pais']) && isset($_POST['inp_tel']) && isset($_POST['inp_codpostal'])) {

        $nombre = $_POST['inp_nombre'];
        $passEnc = $_POST['inp_passEnc'];
        $sexo = $_POST['inp_sexo'];
        $pais = $_POST['inp_pais'];
        $tel = $_POST['inp_tel'];
        $codpostal = $_POST['inp_codpostal'];

        Debuguie::AddMsg("p_registro", "nombre=($nombre), passEnc=($passEnc), sexo=($sexo), pais=($pais), tel=($tel), codpostal=($codpostal)", "info");

        //validar!!

        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        $pass = hash('sha512', $passEnc . $random_salt);
    }
} else {
    $err = true;
    $ret['pedidoInvalido'] = $err;
}
echo json_encode($ret);