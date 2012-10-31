<?php

class SuperFuncs {

    /**
     * Imprime (con echo json_encode) un array con el valor de err y msg
     * @param bool $err t/f
     * @param string $msg string con msg
     * @param obj|string|bla $xtra lo que quieras, para pasar datos extra
     */
    public static function errYmsg($err = true, $msg = "", $xtra = "") {
        $ret = json_encode(array('err' => $err, 'msg' => $msg, 'xtra' => null));

        Debuguie::AddMsg("SuperFuncs - errYmsg()", "ret=(".json_encode($ret).")", "info");
        return $ret;
    }

    /**
     * ejecuta htmlentities($s, ENT_QUOTES, "UTF-8");
     * @param string|array $s string or array with strings to convert
     * @return array|string
     */
    public static function htmlent($s) {
        if (is_array($s)) {
            foreach ($s as $k => $val) {
                $s[$k] = htmlentities($val, ENT_QUOTES, "UTF-8");
            }
            return $s;
        }
        return htmlentities($s, ENT_QUOTES, "UTF-8");
    }

    /**
     * Looks for the first occurrence of $needle in $haystack
     * and replaces it with $replace.
     * @param $needle
     * @param $replace
     * @param $haystack
     * @return mixed
     */
    public static function str_replace_once($needle , $replace , $haystack){
        $pos = strpos($haystack, $needle);
        if ($pos === false) {
            // Nothing found
            return $haystack;
        }
        return substr_replace($haystack, $replace, $pos, strlen($needle));
    }

    public static function EliminarEspaciosDeStr($str) {
        Debuguie::AddMsg("SuperFuncs - EliminarEspaciosDeStr()", "arg str=($str)", "fInit");

        $exp = array('/ |&nbsp;|\r\n|\r|\n/');
        $str = preg_replace($exp, "", $str);

        Debuguie::AddMsg("SuperFuncs - EliminarEspaciosDeStr()", "return=($str)", "info");
        return $str;
    }

    public static function EliminarTagsDeStr($str) {
        Debuguie::AddMsg("SuperFuncs - EliminarTagsDeStr()", "arg str=($str)", "fInit");

        $str = (string) $str;

        $find = '/(<([^>]+)>)/';
        $repl = "";

        $str = str_ireplace($find, $repl, $str);

        Debuguie::AddMsg("SuperFuncs - EliminarTagsDeStr()", "return=($str)", "info");
        return $str;
    }

    public static function ComentarScriptsDeStr($str) {
        $str = (string) $str;
        $find = array("<script", "script>", "<?php", "<?=", "?>");
        $replace = array("<!--scr", "scr-->", "<!--?", "<!--?=", "?-->");
        $str = str_ireplace($find, $replace, $str);

        Debuguie::AddMsg("SuperFuncs - ComentarScriptsDeStr()", "return=($str)", "info");
        return $str;
    }

    public static function Validar($tipoDeValidaciones, $objAValidar) {
        Debuguie::AddMsg("SuperFuncs - Validar()", "args=(tipo=($tipoDeValidaciones), obj=($objAValidar))", "fInit");
        $err = true;

        $tipoDeValidaciones = explode("|", $tipoDeValidaciones);

        foreach ($tipoDeValidaciones as $tipoDeValidacion) {
            if (preg_match("Min", $tipoDeValidacion) === 1) {
                $objAValidar = self::EliminarEspaciosDeStr(self::EliminarTagsDeStr($objAValidar));
                $min = str_replace("Min", "", $tipoDeValidacion);
                $tipoDeValidacion = "Min";
            }
            if (preg_match("Max", $tipoDeValidacion) === 1) {
                $objAValidar = self::EliminarEspaciosDeStr(self::EliminarTagsDeStr($objAValidar));
                $max = str_replace("Max", "", $tipoDeValidacion);
                $tipoDeValidacion = "Max";
            }

            switch($tipoDeValidacion) {
                case 'numerico' :
                    if (is_numeric($objAValidar)) {
                        $err = false;
                    } else {
                        $msg = $tipoDeValidacion;
                    }
                    break;

                case 'Min' :
                    if (strlen($objAValidar) >= $min) {
                        $err = false;
                    }
                    break;

                case 'Max' :
                    if (strlen($objAValidar) <= $max) {
                        $err = false;
                    }
                    break;

                case 'letrasYGuion' :
                    $exp = '#^([0-9a-zA-Z\-]{1,})$#';
                    if (preg_match($exp, $objAValidar) === 1) {
                        $err = false;
                    }
                    break;

                case 'email' :
                    if (filter_var($objAValidar, FILTER_VALIDATE_EMAIL)) {
                        $err = false;
                    }
                    break;

                case 'tel' :
                    $exp = '#^([0-9\(\)\/\+ \-\*]{1,})$#';;
                    if (preg_match($exp, $objAValidar) === 1) {
                        $err = false;
                    }
                    break;

                default :
                    $err = true;
                    break;
            }
            $ret[$tipoDeValidacion] = $err;
        }

        Debuguie::AddMsg("SuperFuncs - Validar()", "ret=(".json_encode($ret).")", "fInit");
        return $ret;
    }
}
