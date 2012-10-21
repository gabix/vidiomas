<?php

class dbFuncs {

    public static function CrearTablasEnDB() {
        mysql_query("SHOW TABLES FROM yourDB");
    }

    public static function DBcrearMysqli() {
        Debuguie::AddMsg("dbFuncs - DBcrearMysqli()", "", "success");
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (mysqli_connect_errno()) {
            Debuguie::AddMsg("dbFuncs - DBcrearMysqli()", "No se puede conectar a la DB. Err: " . mysqli_connect_error(), "error");
            return null;

        }
        return $mysqli;
    }

    public static function DBcrearTablaLog() {
        //no uso el self::DBcrearMysqli porque esa func usa Debuguie, y no puedo debuguear el debug
        $mysqli = new mysqli(DB_HOST, 'root', '', DB_NAME);
        if (mysqli_connect_errno()) {
            trigger_error("EN dbFuncs, No se puede conectar a la DB. Err: " . mysqli_connect_error());

            return null;
        }

        $q = "SHOW TABLES LIKE 'debuguie_log'";
        $ret = $mysqli->query($q);

        if ($ret != false && $ret->num_rows > 0) {
            $mysqli->close();
            return true;
        }

        $q = 'CREATE TABLE IF NOT EXISTS debuguie_log (
                id int(11) NOT NULL AUTO_INCREMENT,
                titulo varchar(200) COLLATE utf8_unicode_ci NOT NULL,
                time int(11) NOT NULL,
                claseYmetodo varchar(200) COLLATE utf8_unicode_ci NOT NULL,
                msg varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
                tipoDeError varchar(20) COLLATE utf8_unicode_ci NOT NULL,
                PRIMARY KEY (id), UNIQUE KEY titulo (titulo)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';

        $ret = $mysqli->query($q);

        $mysqli->close();
        return $ret;
    }

    //    /**
    //     *
    //     * @param string $rowNames ej: "id, nombre, lala, lalala"
    //     * @param type $tableName ej: usuarios
    //     * @param type $limit
    //     * @return array
    //     */
    //    public static function DBselectSimple($rowNames, $tableName, $limit = -1) {
    //        $ret = null;
    //        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //        if (mysqli_connect_errno()) {
    //            trigger_error("No se puede conectar a la DB. Err: " . mysqli_connect_error());
    //        }
    //
    //        $limit = (($limit == -1)? "" : "LIMIT $limit");
    //
    //        if ($q = $mysqli->prepare("SELECT $rowNames FROM $tableName $limit")) {
    //
    //
    //        }
    //
    //        $mysqli->close();
    //        return $ret;
    //    }

    //    public static function mysqli_prepared_query($link, $sql, $typeDef = FALSE, $params = FALSE) {
    //        $link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    //        $result = FALSE;
    //
    //        if (mysqli_connect_errno()) {
    //            trigger_error("No se puede conectar a la DB. Err: " . mysqli_connect_error());
    //        }
    //
    //        if ($stmt = mysqli_prepare($link, $sql)) {
    //            if (count($params) == count($params, 1)) {
    //                $params = array($params);
    //                $multiQuery = FALSE;
    //            } else {
    //                $multiQuery = TRUE;
    //            }
    //
    //            if ($typeDef) {
    //                $bindParams = array();
    //                $bindParamsReferences = array();
    //                $bindParams = array_pad($bindParams, (count($params, 1) - count($params)) / count($params), "");
    //                foreach ($bindParams as $key => $value) {
    //                    $bindParamsReferences[$key] = &$bindParams[$key];
    //                }
    //                array_unshift($bindParamsReferences, $typeDef);
    //                $bindParamsMethod = new ReflectionMethod('mysqli_stmt', 'bind_param');
    //                $bindParamsMethod->invokeArgs($stmt, $bindParamsReferences);
    //            }
    //
    //            $result = array();
    //            foreach ($params as $queryKey => $query) {
    //                foreach ($bindParams as $paramKey => $value) {
    //                    $bindParams[$paramKey] = $query[$paramKey];
    //                }
    //                $queryResult = array();
    //                if (mysqli_stmt_execute($stmt)) {
    //                    $resultMetaData = mysqli_stmt_result_metadata($stmt);
    //                    if ($resultMetaData) {
    //                        $stmtRow = array();
    //                        $rowReferences = array();
    //                        while ($field = mysqli_fetch_field($resultMetaData)) {
    //                            $rowReferences[] = &$stmtRow[$field->name];
    //                        }
    //                        mysqli_free_result($resultMetaData);
    //                        $bindResultMethod = new ReflectionMethod('mysqli_stmt', 'bind_result');
    //                        $bindResultMethod->invokeArgs($stmt, $rowReferences);
    //                        while (mysqli_stmt_fetch($stmt)) {
    //                            $row = array();
    //                            foreach ($stmtRow as $key => $value) {
    //                                $row[$key] = $value;
    //                            }
    //                            $queryResult[] = $row;
    //                        }
    //                        mysqli_stmt_free_result($stmt);
    //                    } else {
    //                        $queryResult[] = mysqli_stmt_affected_rows($stmt);
    //                    }
    //                } else {
    //                    $queryResult[] = FALSE;
    //                }
    //                $result[$queryKey] = $queryResult;
    //            }
    //            mysqli_stmt_close($stmt);
    //        } else {
    //            $result = FALSE;
    //        }
    //
    //        $link->close();
    //        if ($multiQuery) {
    //            return $result;
    //        } else {
    //            return $result[0];
    //        }
    //    }

}
