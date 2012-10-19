<?php
function dateame($time, $formato = "y-m-d H:i:s") {
    $exp = '#^([a-zA-Z\-: ]{1,})$#';
    if (!preg_match($exp, $formato)) exit();
    
    if (is_int($time)) {
        return date($formato, $time);
    } else {
        return false;
    }
}

$formato = "y-m-d";
$time = time();
if (isset($_GET['time'])) {
    if (isset($_GET['timeFormato'])) $formato = $_GET['timeFormato'];
    $time = (int) $_GET['time'];
}
if (isset($_POST['time'])) {
    if (isset($_POST['timeFormato'])) $formato = $_POST['timeFormato'];
    $time = (int) $_POST['time'];
}

$ret = dateame($time, $formato);
echo $ret;