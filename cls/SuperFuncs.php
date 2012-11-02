<?php

class SuperFuncs {

    /**
     * Devuelve un array
     * @param bool $err decile si hubo un error
     * @param string $msg el mensaje a responder
     * @param string $xtra si querés pasar algo extra
     * @return string json array con los params de arriba
     */
    public static function errYmsg($err = true, $msg = "", $xtra = "") {
        $ret = json_encode(array('err' => $err, 'msg' => $msg, 'xtra' => null));

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "ret=(".json_encode($ret).")", "info");
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
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "arg str=($str)", "fInit");

        $exp = array('/ |&nbsp;|\r\n|\r|\n/');
        $str = preg_replace($exp, "", $str);

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "return=($str)", "info");
        return $str;
    }

    public static function ComentarScriptsDeStr($str) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "", "fInit");

        $str = (string) $str;
        $find = array("<script", "script>", "<?php", "<?=", "?>");
        $replace = array("<!--scr", "scr-->", "<!--?", "<!--?=", "?-->");
        $str = str_ireplace($find, $replace, $str);

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "return=($str)", "info");
        return $str;
    }

    public static function Validar($tipoDeValidaciones, $objAValidar) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "args=(tipo=($tipoDeValidaciones), obj=($objAValidar))", "fInit");
        $err = true;

        $tipoDeValidaciones = explode("|", $tipoDeValidaciones);

        foreach ($tipoDeValidaciones as $tipoDeValidacion) {
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "tipoDeValid=($tipoDeValidacion)", "info");

            if (preg_match('/Min/', $tipoDeValidacion) === 1) {
                $objAValidar = self::EliminarEspaciosDeStr($objAValidar);
                $min = str_replace("Min", "", $tipoDeValidacion);
                $tipoDeValidacion = "Min";

                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "pregMatch(Min)--> tipoDeValid=($tipoDeValidacion), min=($min), objAVal=($objAValidar)", "info");
            }
            if (preg_match('/Max/', $tipoDeValidacion) === 1) {
                $objAValidar = self::EliminarEspaciosDeStr($objAValidar);
                $max = str_replace("Max", "", $tipoDeValidacion);
                $tipoDeValidacion = "Max";

                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "pregMatch(Max)--> tipoDeValid=($tipoDeValidacion), min=($max), objAVal=($objAValidar)", "info");
            }


            switch($tipoDeValidacion) {
                case 'numerico' :
                    if (is_numeric($objAValidar)) {
                        $err = false;
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

            $ret[] = array('tipo' => $tipoDeValidacion, 'err' => $err);
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "ret=(".json_encode($ret).")", "success");
        }

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "ret=(".json_encode($ret).")", "info");
        return $ret;
    }
}
