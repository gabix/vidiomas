<?php
require 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$lo = $usu->logueado();

($lo)? header("location:".CPANEL_PAGE) : header("location:".HOME_PAGE);
exit;
