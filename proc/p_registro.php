<?php
require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'init.php';

Debuguie::AddMsg("p_registro", "", "fInit");

$err = true;

if (isset($_POST['inp_apodo']) && isset($_POST['inp_r_email'])) {
    $apodo = strip_tags($_POST['inp_apodo']);
    $email = strip_tags($_POST['inp_r_email']);

    Debuguie::AddMsg("p_registro", "apodo=($apodo), email=($email)", "info");

    $retVal['apodo'] = SuperFuncs::Validar("Min3|Max50", $apodo);
    $retVal['r_email'] = SuperFuncs::Validar("Min6|Max50|email", $email);
    Debuguie::AddMsg("p_registro", "retVal=(".json_encode($retVal).")", "info");


    $sigo = true;
    foreach($retVal as $valItem) {
        if ($valItem['err'] == true) {
            $sigo = false;
        }
    }
    Debuguie::AddMsg("p_registro", "sigo=($sigo)", "info");

    if ($sigo) {
        $usu = new Usuario;
        $retVal['apodo'] = $usu->checkApodoEnUso($apodo);
        $retVal['r_email'] = $usu->checkEmailEnUso($email);


    }

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
    $retVal['general'] = SuperFuncs::errYmsg(true, 'pedidoInvalido');
}
//echo json_encode($ret);

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<form method="post">
    apodo<input type="text" name="inp_apodo" value="<?= (isset($_POST['inp_apodo'])? $_POST['inp_apodo'] : "lalalalalal") ?>" /><br />
    email<input type="text" name="inp_r_email" value="<?= (isset($_POST['inp_email'])? $_POST['inp_r_email'] : "lalalalalal") ?>" /><br />
    <input type="submit">
</form>

<p>RET: <?= json_encode($retVal) ?></p>

</body>
</html>