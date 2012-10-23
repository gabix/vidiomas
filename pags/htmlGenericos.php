<?php
/**
 * User: gabix
 * Date: 22/10/12
 * Time: 12:23
 */

/**
 * Crea el <head> de la pag que lo solicita
 */
class htmlGenericos {

//    public static function PrintHead($titulo, $fromLang = null, $utf8 = null, $posicion = null, $fonts = null,
//                                     $bootstrapTweeter = null, $generales = null, $cssAPartirDelTitulo = null) {
//        Debuguie::AddMsg("htmlGenericos - PrintHead()", "args=(tit=$titulo, fromLang=$fromLang, uft=$utf8, pos=$posicion, fonts=$fonts, boots=$bootstrapTweeter, gen=$generales, cssAPartir=$cssAPartirDelTitulo", "fInit");
//
//        $head = "<head>\n";
//
//        if (isset($utf8)) $head .= ' <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
//        if (isset($fromLang)) {
//            $l = new Lang("headMetas");
//            $head .= $l->crearHeadMetas($titulo);
//        } else {
//            $head .= " <title>$titulo</title>\n";
//        }
//
//        if (isset($posicion)) {
//            $cssLoc = $posicion . "/" . CSS_LOCATION;
//            $othLoc = $posicion . "/" . OTHERSLIB_LOCATION;
//        } else {
//            $cssLoc = CSS_LOCATION;
//            $othLoc = OTHERSLIB_LOCATION;
//        }
//
//        if (isset($fonts)) $head .= ' <link rel="stylesheet" type="text/css" href="' . $cssLoc . "/" . 'fonts' . "/" . 'fonts.css" />' . "\n";
//        if (isset($bootstrapTweeter)) $head .= ' <link rel="stylesheet" type="text/css" href="' . $othLoc . "/" . 'bootstrap.css" />' . "\n";
//        if (isset($generales)) $head .= ' <link rel="stylesheet" type="text/css" href="' . $cssLoc."/".'generales.css" />' . "\n";
//        if (isset($cssAPartirDelTitulo)) $head .= ' <link rel="stylesheet" type="text/css" href="' . "$cssLoc/$cssAPartirDelTitulo" . '.css" />' . "\n";
//
//        $head .= "</head>\n";
//
//        Debuguie::AddMsg("htmlGenericos - PrintHead()", "head=($head)", "success");
//        return $head;
//    }

    /**
     * prints <script src="bla.js" with the selected options
     * @param null|string $posicion posición del la pag, si estás en pa/gs/caca.php tenés que pasarle "../.."
     * @param null $jquery incluye jquery
     * @param null $jqueryValidate incluye jquery.validator
     * @param null $sha512 incluye sha512.js
     * @param null $generales incluye generales.js
     * @param null|string $jsAPartirDelTitulo incluye js del string pasado ej=registro => incluye registro.js
     * @return string
     */
    public static function PrintScripts($posicion = null, $jquery = null, $jqueryValidate = null, $sha512 = null, $generales = null, $jsAPartirDelTitulo = null) {
        Debuguie::AddMsg("htmlGenericos - PrintScripts()", "args=(pos=$posicion, gen=$generales, jquery=$jquery, jqueryValidate=$jqueryValidate, jsAPartir=$jsAPartirDelTitulo", "fInit");

        $scripts = "";

        if (isset($posicion)) {
            $jsLoc = $posicion . "/" . JS_LOCATION;
            $othLoc = $posicion . "/" . OTHERSLIB_LOCATION;
        } else {
            $jsLoc = JS_LOCATION;
            $othLoc = OTHERSLIB_LOCATION;
        }

        if (DEBUGUEANDO) {
            if (isset($jquery)) $scripts .= '<script src="' . $othLoc . '/jquery.min.js"></script>' . "\n";
            if (isset($jqueryValidate)) $scripts .= '<script src="' . $othLoc . '/jquery.validate.min.js"></script>' . "\n";
        } else {
            if (isset($jquery)) $scripts .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>' . "\n";
            if (isset($jqueryValidate)) $scripts .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>' . "\n";
        }

        if (isset($sha512)) $scripts .= '<script src="' . $othLoc . '/sha512.js"></script>' . "\n";
        if (isset($generales)) $scripts .= '<script src="' . $jsLoc . '/generales.js"></script>' . "\n";
        if (isset($jsAPartirDelTitulo)) $scripts .= '<script src="'."$jsLoc/$jsAPartirDelTitulo".'.js"></script>' . "\n";


        Debuguie::AddMsg("htmlGenericos - PrintScripts()", "scripts=($scripts)", "success");
        return $scripts;
    }

}