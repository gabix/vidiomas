<?php
// <editor-fold desc="pag init">
require 'config'.DIRECTORY_SEPARATOR.'init.php';

$usu = new Usuario;
$usu->inicio();

//defino el lenguaje de la pag
$l = new Lang;

//vars para manejo fácil de la pag
$lo = $usu->get_loged();
$cat = $usu->get_categoria();

//defino el título de la pag
$selPag = "oPru";
$pagTit = $l->grales($selPag);
// </editor-fold>

$pagTitle = "php page template";
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $pagTitle ?></title>
    <link rel="stylesheet" type="text/css" href="inc/<?= $pagTitle ?>"/>
    <style type="text/css">
    </style>
</head>
<body>
<h1><?= $pagTitle ?></h1>
<hr/>

<script type="text/javascript" src="othersLib/jquery.min.js"></script>
<script type="text/javascript" src="inc/<?= $pagTitle ?>"></script>
<script type="text/javascript"></script>
</body>
</html>
