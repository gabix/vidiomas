<?php

class SuperFuncs {

    /**
     * Imprime (con echo json_encode) un array con el valor de err y msg
     * @param bool $err t/f
     * @param string $msg string con msg
     * @param obj|string|bla $xtra lo que quieras, para pasar datos extra
     */
    public static function errYmsg($err = true, $msg = "", $xtra = "") {
        echo json_encode(array('err' => $err, 'msg' => $msg, 'xtra' => null));
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

}
