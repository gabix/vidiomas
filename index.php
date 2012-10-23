<?php
// <editor-fold desc="pag init">
require 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$usu->inicio();

//vars para manejo fácil de la pag
$lo = $usu->get('loged');
($lo)? header("location:".CPANEL_PAGE) : header("location:".HOME_PAGE);

exit;
// </editor-fold>
?>