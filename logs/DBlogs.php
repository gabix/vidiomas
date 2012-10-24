<?php
/**
 * User: gabix
 * Date: 21/10/12
 * Time: 10:19
 */
//PREG-charly: que onda con el microtime(true) y porque el date no me está trayendo los microseconds

require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'init.php';

$pagTit = "DBlogs";



$dMsgs = getLogs();


function getLogs($limit = 100) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (!(is_int($limit) && $limit < 1000)) return "que feo limit que mandaste cacho!";

    $ret = $mysqli->query('SELECT * FROM debuguie_log ORDER BY id DESC LIMIT 0 , 100');
    if ($ret != false && $ret->num_rows > 0) {

        while ($row = $ret->fetch_assoc()) {
            $dMsgs[] = array('id' => $row['id'], 'titulo' => $row['titulo'], 'time' => $row['time'], 'donde' => $row['claseYmetodo'], 'msg' => $row['msg'], 'tipoDeError' => $row['tipoDeError']);
        }

        $mysqli->close();
        return $dMsgs;
    }

    $mysqli->close();
    return null;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?= $pagTit ?></title>
    <link rel="stylesheet" type="text/css" href="../othersLib/bootstrap.css"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <style>
        #contenido {
            text-align: left;
        }

        .textCenter {
            text-align: center;
        }

        .bold {
            font-weight: bolder;
        }

    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row-fluid">

        <div id="contenido" class="span12">
            <h1 class="textCenter"><?= $pagTit ?></h1>
            <hr/>

            <div class="d_debuguie">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>debug sess</th>
                        <th>time</th>
                        <th>Tipo</th>
                        <th>Donde</th>
                        <th>Mensaje</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (null != $dMsgs) {
                        foreach ($dMsgs as $dMsg) {
                            ?>
                        <tr class="<?= $dMsg['tipoDeError'] ?>">
                            <td><?= $dMsg['id'] ?></td>
                            <td><?= $dMsg['titulo'] ?></td>
                            <td><?= date("Y-m-d H:i:s u", $dMsg['time']) ?></td>
                            <td class="bold"><?= $dMsg['tipoDeError'] ?></td>
                            <td><?= $dMsg['donde'] ?></td>
                            <td><?= $dMsg['msg'] ?></td>
                        </tr>
                            <?php
                        }
                    } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

</script>
</body>
</html>
