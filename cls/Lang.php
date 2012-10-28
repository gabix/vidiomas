<?php
class Lang {

    public $lang = null;
    private $errMsg = null;
    private $grales = null;
    private $headMetas = null;
    private $footer = null;

    private function carga_($fName) {
        Debuguie::AddMsg("Lang - carga_()", "args=(fName=($fName))", "fInit");

        $path = APP_ROOT . DS . LANG_PAGES_LOCATION . DS . "l_$fName." . $this->lang . ".php";
        require_once $path;

        $this->$fName = SuperFuncs::htmlent(${$fName});
    }

    /**
     * Llama a re_($fName) de esta clase para cargar los archs del lang adecuado
     * @param (array/string) $soloTal Solo cargar el array de tal. ej: 'errMsg'
     */
    private function carga($soloTal) {
        Debuguie::AddMsg("Lang - carga()", "args=(soloTal=($soloTal))", "fInit");

        if ($soloTal === null)
            $soloTal = array('headMetas', 'errMsg', 'grales');

        if (is_array($soloTal)) {
            foreach ($soloTal as $val) {
                $this->carga_($val);
            }
        } else {
            $this->carga_($soloTal);
        }
    }

    /**
     * Constructor!!
     * @param string $soloTal
     * @param string $lang
     */
    public function Lang($soloTal = null, $lang = null) {
        Debuguie::AddMsg("Lang - Lang()", "args=(soloTal=($soloTal), lang=($lang))", "fInit");
        $this->setLang($soloTal, $lang);
    }

    public function setLang($soloTal, $lang = "") {
        Debuguie::AddMsg("Lang - setLang()", "args=(soloTal=($soloTal), lang=($lang))", "fInit");

        if (isset($_POST['inp_lang']) && strlen($_POST['inp_lang']) === 2) {
            //hay un cambio de lenguaje? (viene por post inp_lang)
            $this->lang = $_POST['inp_lang'];
            $lang = $_POST['inp_lang'];
            //PREG-LAU: preguntar si cambio en la db o no
            
        } elseif (isset($_GET['lang']) && strlen($_GET['lang']) === 2) {
            //hay un cambio de lenguaje? (viene por get lang)
            $lang = $_GET['lang'];
            //PREG-LAU: preguntar si cambio en la db o no
            
        } elseif (Session::get('lang')) {
            //pues no, está seteado el lenguaje en sess?
            $lang = Session::get('lang');
        } else {
            $lang = DEFLANG;
        }

        $this->lang = $lang;
        Session::set('lang', $lang);
        $this->carga($soloTal);
    }

    public function crearHeadMetas($pagTitu) {
        Debuguie::AddMsg("Lang - crearHeadMetas()", "args=($pagTitu)", "fInit");
        $ret = '';
        $ret .= ' <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
        $ret .= sprintf(' <title>%s - %s</title>%s', $pagTitu, $this->headMetas['titu'], "\n");
        $ret .= sprintf(' <meta name="title" content="%s - %s" />%s', $pagTitu, $this->headMetas['titu'], "\n");
        $ret .= sprintf(' <meta name="keywords" content="%s" />%s', $this->headMetas['keys'], "\n");
        $ret .= sprintf(' <meta name="description" content="%s" />%s', $this->headMetas['desc'], "\n");
        $ret .= sprintf(' <meta name="subject" content="%s" />%s', $this->headMetas['subj'], "\n");
        $ret .= sprintf(' <meta name="Classification" content="%s" />%s', $this->headMetas['class'], "\n");
        $ret .= sprintf(' <meta name="lang" content="%s" />%s', $this->lang, "\n");
        $ret .= sprintf(' <meta http-equiv="Content-Language" content="%s" />%s', $this->lang, "\n");
        return $ret;
    }

    public function errMsg($msg) {
        Debuguie::AddMsg("Lang - errMsg()", "atributo=$msg", "fInit");

        if ($msg == ""  && $this->errMsg == null) return false;

        $msg = explode("-", $msg);

        if (count($msg) == 1) {
            return $this->generico('errMsg', $msg[0]);
        } elseif (count($msg) > 1) {
            $ret = "";
            for ($i = 0; $i < count($msg); $i++) {
                if (array_key_exists($msg[$i], $this->errMsg)) {
                    $ret.= $this->errMsg[$msg[$i]];
                } else {
                    $ret.= $msg[$i];
                }
                if ($i <> count($msg) - 1)
                    $ret.= " | ";
            }
            return $ret;

        } else {
            Debuguie::AddMsg("Lang - errMsg()", "msg=$msg vacio?", "warning");
            return $this->errMsg['defErr'];
        }
    }

    /**
     * Forma 1 de conseguir un msje de las pags de idioma ($l->generico('grales', 'holaUsu'))
     * @param (string) $arr el nombre del array con los msjes
     * @param (string) $msg el key del msje
     * @return (string) el msje en el array | warning y el $msg enviado
     */
    public function generico($arr, $msg) {
        if (($this->$arr <> null) && (array_key_exists($msg, $this->$arr))) {
            return $this->{$arr}[$msg];
        } else {
            Debuguie::AddMsg("Lang - generico()", "(arr=($arr) | msg=($msg)) inválido", "info");
            return $msg;
        }
    }

    /**
     * Forma 2 de conseguir un msje de las pags de idioma ($l->grales('holaUsu'))
     * @param string $metodo
     * @param string $argumentos
     * @return string
     */
    public function __call($metodo, $argumentos) {
        Debuguie::AddMsg("Lang - __call()", "m: $metodo args: ".json_encode($argumentos), "fInit");

        if (!isset($this->$metodo)) {
            Debuguie::AddMsg("Lang - __call()", "$metodo inexistente", "error");
            return null;
        }
        return $this->generico($metodo, $argumentos[0]);
    }

}