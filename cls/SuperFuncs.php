<?php

class SuperFuncs {

    public static function htmlent($s) {
        if (is_array($s)) {
            foreach ($s as $k => $val) {
                $s[$k] = htmlentities($val, ENT_QUOTES, "UTF-8");
            }
            return $s;
        }
        return htmlentities($s, ENT_QUOTES, "UTF-8");
    }

    public static function miDefine($name, $value) {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Imprime (con echo json_encode) un array con el valor de err y msg
     * @param bool $err t/f
     * @param string $msg string con msg
     * @param object|string $xtra lo que quieras, para pasar datos extra
     */
    public static function errYmsg($err = true, $msg = "", $xtra = "") {
        echo json_encode(array('err' => $err, 'msg' => $msg, 'xtra' => $xtra));
    }

    /**
     * hace un echo entre <p></p> de htmlspecialchars($s)
     * @param string $s
     * @param string $style "", "rojo", "azul"
     */
    public static function echoConP($s, $style = "") {
        switch ($style) {
            case "" :
                echo sprintf("<p>%s</p>\n", self::htmlent($s));
                break;
            case "rojo" :
                echo sprintf('<p style="%s">%s</p>%s', "color:red;", self::htmlent($s), "\n");
                break;
            case "azul" :
                echo sprintf('<p style="%s">%s</p>%s', "color:blue;", self::htmlent($s), "\n");
                break;
        }
    }

    public static function echoConPArray($arr, $style = "") {
        $s = "";
        foreach ($arr as $k => $v) {
            $k = self::htmlent($k);
            $v = self::htmlent($v);
            $s .= ("$k = $v <br />\n");
        }

        switch ($style) {
            case "" :
                echo "<p>$s</p>\n";
                break;
            case "err" :
                echo sprintf('<p style="%s">%s</p>%s', "color:red;", $s, "\n");
                break;
            case "azul" :
                echo sprintf('<p style="%s">%s</p>%s', "color:bule;", $s, "\n");
                break;
        }
    }
    
    public static function aDateConH($t) {
        if (is_int($t)) {
            $t = date("y-m-d H:i:s", $t);
        } else {
            return null;
        }
        return $t;
    }

}
