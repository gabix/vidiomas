<?php
/**
 * User: gabix
 * Date: 21/10/12
 * Time: 10:19
 */
//PREG-charly: que onda con el microtime(true) y porque el date no me está trayendo los microseconds

require_once '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'init.php';

$pagTit = "DBlogs";

if (isset($_POST['drop']) && $_POST['drop'] == 'matata') {
    $jojo = dbFuncs::matarTablaLog();
}

$limit = 500;
if (isset($_POST['limit'])) {
    $lim = $_POST['limit'];
    if (is_numeric($lim) && $lim > 0 && $lim < 5000) $limit = $lim;
}

$filterStr = "";
$filter = array();
if (isset($_POST['filter'])) {
    $filter = explode(", ", $_POST['filter']);


    $filterStr = $_POST['filter'];
}

$dMsgs = getLogs($limit);

function getLogs($limit) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    //if (!(is_numeric($limit) && $limit < 1000)) return "que feo limit que mandaste cacho! : $limit";

    $ret = $mysqli->query('SELECT * FROM debuguie_log ORDER BY id DESC LIMIT 0 , '.$limit);
    if ($ret != false && $ret->num_rows > 0) {
        $dMsgs = null;

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
    <script src="../othersLib/jquery.min.js"></script>

    <style>
        #contenido {
            margin-top: 50px;
            width: 100%;
            text-align: left;
        }

        #formi {
            margin-top: 10px;
        }

        .lalola {
            -webkit-box-shadow:  0px 0px 10px 0px rgba(0, 0, 0, 0.3);
            box-shadow:  0px 0px 10px 0px rgba(0, 0, 0, 0.3);
        }

        .textCenter { text-align: center; }

        .bold { font-weight: bolder; }

        .colAzul { color: #005580; }
        .colVerde { color: #499249; }
        .colRojo { color: #993300; }
        .colNaranja { color: #df8505; }

    </style>

</head>
<body>

<div id="contenido" class="">

<div id="formi" class="navbar-fixed-top textCenter">
    <form action="DBlogs.php" method="post" class="form-inline ">
        <div class="input-prepend input-append lalola">
            <span class="add-on">Limit:</span>
            <input type="text" class="span1" name="limit" value="<?= $limit ?>" placeholder="LIMIT" />
            <span class="add-on">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filter:</span>
            <input type="text" class="span6" name="filter" value="<?= $filterStr ?>" placeholder="CLASE1, CLASE2, ETC" />
            <button type="button" class="btn btn-success" id="dropRetado">cleareame</button>
            <input type="hidden" id="drop" name="drop" value="" />
            <button type="submit" class="btn">Submit <i class="icon-circle-arrow-right"></i></button>
        </div>
<!--
        <label for="limit">Limit: </label><input type="text" class="span1" name="limit" value="<?= $limit ?>" placeholder="LIMIT" />

        <label for="filter">filter:  </label><input type="text" class="span6" name="filter" value="<?= $filterStr ?>" placeholder="CLASE1, CLASE2, ETC" />


        <label class="checkbox">
            <input type="checkbox" name="drop" value="matata" />matata
        </label>

        <button type="submit" class="btn">Submit <i class="icon-circle-arrow-right"></i></button>
        -->
    </form>
</div>

    <h1 class="textCenter"><?= $pagTit ?></h1>
    <hr/>

    <div class="d_debuguie">
        <table class="table table-condensed table-hover">
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
            if (null != $dMsgs && is_array($dMsgs)) {
                $cols = array("colRojo", "colVerde", "colNaranja", "colAzul");
                $tit = "";
                $i = 0;

                foreach ($dMsgs as $dMsg) {
                    if ($dMsg['titulo'] != $tit) {
                        $tit = $dMsg['titulo'];
                        $i += 1;
                        if ($i > (count($cols) - 1)) $i = 0;
                    }

                    $clase = explode(" - ", $dMsg['donde']);


                    if (!in_array($clase[0], $filter)) {
                    ?>
                    <tr class="<?= $dMsg['tipoDeError'] ?>">
                        <td><?= $dMsg['id'] ?></td>
                        <td class="<?= $cols[$i] ?> bold"><?= $dMsg['titulo'] ?></td>
                        <td><?= date("H:i:s u", $dMsg['time']) ?></td>
                        <td class="bold"><?= $dMsg['tipoDeError'] ?></td>
                        <td><?= $dMsg['donde'] ?></td>
                        <td><?= $dMsg['msg'] ?></td>
                    </tr>
                        <?php
                    }
                }
            } ?>
            </tbody>
        </table>
    </div>
    <hr />

</div>

<script type="text/javascript">
    var dropRetadoVal = false;
    $('#dropRetado').on('click', function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        $(this).toggleClass('btn-danger btn-success');

        var inpDrop = $('#drop');
        console.log(inpDrop.val());
        if (dropRetadoVal) {
            dropRetadoVal = false;
            inpDrop.val("");
        } else {
            dropRetadoVal = true;
            inpDrop.val("matata");
        }
        console.log(inpDrop.val());
    });
</script>

</body>
</html>
