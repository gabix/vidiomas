<?php
require_once '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'init.php';

Usuario::logout();
Session::kill();

//TODO: redirigir?
//header("location:".HOMEPAGE);
//defino el título de la pag
?>