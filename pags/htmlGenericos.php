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

    public static function PrintHead($titulo, $fromLang = null, $utf8 = null, $posicion = null, $fonts = null,
                                     $bootstrapTweeter = null, $generales = null, $cssAPartirDelTitulo = null) {
        Debuguie::AddMsg("htmlGenericos - PrintHead()", "args=(tit=$titulo, fromLang=$fromLang, uft=$utf8, pos=$posicion, fonts=$fonts, boots=$bootstrapTweeter, gen=$generales, cssAPartir=$cssAPartirDelTitulo", "fInit");

        $head = "<head>\n";

        if (isset($utf8)) $head .=  ' <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
        if (isset($fromLang)) {
            $l = new Lang("headMetas");
            $head .= $l->crearHeadMetas($titulo);
        } else {
            $head .= " <title>$titulo</title>\n";
        }

        if (isset($posicion)) {
            $cssLoc = $posicion.DS.CSS_LOCATION;
            $othLoc = $posicion.DS.OTHERSLIB_LOCATION;
        } else {
            $cssLoc = CSS_LOCATION;
            $othLoc = OTHERSLIB_LOCATION;
        }

        if (isset($fonts)) $head .=  ' <link rel="stylesheet" type="text/css" href="'.$cssLoc.DS.'fonts'.DS.'fonts.css" />' . "\n";
        if (isset($bootstrapTweeter)) $head .=  ' <link rel="stylesheet" type="text/css" href="'.$othLoc.DS.'bootstrap.css" />' . "\n";
        if (isset($generales))  $head .= ' <link rel="stylesheet" type="text/css" href="'.$cssLoc.DS.'generales.css" />' . "\n";
        if (isset($cssAPartirDelTitulo)) $head .=  ' <link rel="stylesheet" type="text/css" href="'.$cssLoc.DS.$titulo.'.css" />' . "\n";

        $head .= '<head>' . "\n";

        Debuguie::AddMsg("htmlGenericos - PrintHead()", "head=($head)", "success");
        return $head;
    }

    public static function PrintScripts($posicion = null, $generales = null, $jquery = null, $jqueryValidator = null, $sha512 = null, $jsAPartirDelTitulo = null) {
        Debuguie::AddMsg("htmlGenericos - PrintScripts()", "args=(pos=$posicion, gen=$generales, jquery=$jquery, jqueryValidator=$jqueryValidator, jsAPartir=$jsAPartirDelTitulo", "fInit");

        $sripts = "";

        if (isset($posicion)) {
            $jsLoc = $posicion.DS.JS_LOCATION;
            $othLoc = $posicion.DS.OTHERSLIB_LOCATION;
        } else {
            $jsLoc = JS_LOCATION;
            $othLoc = OTHERSLIB_LOCATION;
        }

//        if(DEBUGUEANDO)
//        <script src="othersLib/jquery.min.js"></script>
//         } else {
//        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
//        }


        return $sripts;
    }

}