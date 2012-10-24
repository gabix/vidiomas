<?php
require_once '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'init.php';

Debuguie::AddMsg("p_logout", "", "fInit");

Usuario::logout();
Session::kill();

header("location:".HOME_PAGE);
exit();
