<?php
/**
 * User: gabix
 * Date: 21/10/12
 * Time: 10:19
 */

require_once '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'init.php';

$pagTit = "DBlogs";

$dMsgs = null;

function getLogs($limit = 100) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($q = $mysqli->prepare("SELECT * FROM debuguie_log LIMIT $limit ORDER BY id DESC")) {
        $q->execute();
        $result = $q->get_result();

        echo "success<br>";

        while ($row = $result->fetch_assoc()) {
            $dMsgs[] = array('id' => $row['id'], 'titulo' => $row['titulo'], 'time' => $row['time'], 'donde' => $row['clase'], 'msg' => $row['msg'], 'tipoDeError' => $row['tipoDeError']);
        }
    }
    $mysqli->close();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= $pagTit ?></title>
    <link rel="stylesheet" type="text/css" href="../othersLib/bootstrap.css" />
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
            <hr />

            <div class="d_debuguie well">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>id</th><th>debug sess</th><th>time</th><th>Tipo</th><th>Donde</th><th>Mensaje</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (null != $dMsgs) {
                    foreach ($dMsgs as $debMsg) { ?>
                    <tr class="<?= $debMsg['tipoDeError'] ?>">
                        <td class="bold"></b><?= $debMsg['tipoDeError'] ?></td>
                        <td><?= $debMsg['id'] ?></td>
                        <td><?= $debMsg['titulo'] ?></td>
                        <td><?= date("Y-m-d H:i:s", $debMsg['time']) ?></td>
                        <td><?= $debMsg['donde'] ?></td>
                        <td><?= $debMsg['msg'] ?></td>
                    </tr>
                    <?php } } ?>
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
