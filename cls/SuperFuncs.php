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

    public static function EliminarTagsDeStr($str) {
        Debuguie::AddMsg("SuperFuncs - EliminarTagsDeStr()", "arg str=($str)", "fInit");

        $str = (string) $str;

        $find = '/(<([^>]+)>)/';
        $repl = "";

        $str = str_ireplace($find, $repl, $str);

        Debuguie::AddMsg("SuperFuncs - EliminarTagsDeStr()", "returns: $str", "info");
        return $str;
    }

    public static function ComentarScriptsDeStr($str) {
        $str = (string) $str;
        $find = array("<script", "script>", "<?php", "<?=", "?>");
        $replace = array("<!--scr", "scr-->", "<!--?", "<!--?=", "?-->");
        $str = str_ireplace($find, $replace, $str);

        Debuguie::AddMsg("SuperFuncs - ComentarScriptsDeStr()", "returns: $str", "info");
        return $str;
    }

    public static function Validar($tipoDeValidaciones, $objAValidar) {
        Debuguie::AddMsg("SuperFuncs - Validar()", "args=(tipo=($tipoDeValidaciones), obj=($objAValidar))", "fInit");
        $valido = false;
        $msg = "";

        $tipoDeValidaciones = explode("|", $tipoDeValidaciones);

        foreach ($tipoDeValidaciones as $tipoDeValidacion) {
            switch($tipoDeValidacion) {
                case 'numerico' :
                    if (is_numeric($objAValidar)) {
                        $valido = true;
                        $msg = "";
                    } else {
                        $msg = "no es un número";
                    }
                    break;

                case 'letrasYGuion' :
                    $exp = '#^([0-9a-zA-Z\-])$#';
                    if (preg_match($exp, $objAValidar) === 1) {
                        $valido = true;
                        $msg = "";
                    } else {
                        $msg = "solo se permiten números, letras normales (sin acentos) y guiones '-'";
                    }
                    break;


                default :
                    $valido = false;
                    $msg = "pedidoInvalido";
                    break;
            }
            $ret[$tipoDeValidacion] = array('valido' => $valido, 'msg' => $msg);
        }



        Debuguie::AddMsg("SuperFuncs - Validar()", "ret=(".json_encode($ret).")", "fInit");
        return $ret;
    }
}
