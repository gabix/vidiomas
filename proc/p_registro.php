<?php
require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'init.php';

$err = true;
Debuguie::AddMsg("p_registro", "", "fInit");

if (isset($_POST['inp_apodo']) && isset($_POST['inp_email'])) {
    $apodo = $_POST['inp_apodo'];
    $email = $_POST['inp_apodo'];

    Debuguie::AddMsg("p_registro", "apodo=($apodo), email=($email)", "info");

    $usu = new Usuario;


    if (isset($_POST['inp_nombre']) && isset($_POST['inp_passEnc']) && isset($_POST['inp_sexo']) &&
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