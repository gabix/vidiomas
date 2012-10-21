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

    /**
     * hace un echo entre <p></p> de htmlspecialchars($s)
     * @param type $s
     * @param type $style "", "rojo", "azul"
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
                echo sprintf('<p style="%s">%s</p>%s', "color:bule;", self::htmlent($s), "\n");
                break;
        }
    }

    /**
     * @param int $time
     * @param string $formato default: y-m-d H:i:s | ymd_his: ymd_His
     * @return string
     */
    public static function aDate($time, $formato = "y-m-d H:i:s") {
        $ret = null;
        if (is_int($time)) {
            switch ($formato) {
                case "ymd_his" :
                    $ret = date("ymd_His", $time);
                    break;
                case "y-m-d H:i:s" :
                default :
                    $ret = date("y-m-d H:i:s", $time);
                    break;
            }
        }
        return $ret;
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
