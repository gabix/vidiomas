<?php

class EntradaDeBlog {

    //<editor-fold desc="proprs">
    private $id = -1;
    private $nombre = "";
    private $titulo = "";
    private $timeCreated = 0;
    private $usuId = 0;
    private $entradaHtml = "";
    private $comentarios = array();
    // otras
    private $excludeGet = array('excludeGet', 'excludeSet');
    private $excludeSet = array('excludeGet', 'excludeSet');

    public function __construct() {
        
    }

    public function get($prop) {
        if (!isset($this->$prop)) {
            trigger_error("Err: No existe la porpiedad $prop, en get.");
            return false;
        }
        if (!in_array((string) $prop, $this->excludeGet)) {
            return $this->$prop;
        }
        trigger_error("get_$prop excluido, ");
    }

    public function set($prop, $val) {
        if (!isset($this->$prop)) {
            trigger_error("Err: No existe la porpiedad $prop, en set.");
            return false;
        }
        if (!in_array($prop, $this->excludeSet)) {
            return $this->$prop = $val;
        }
        trigger_error("set_$prop excluido, ");
    }

    public function set_props($params) {
        foreach ($params as $prop => $val) {
            $this->set($prop, $val);
        }
    }

    //</editor-fold>

    private function generarRuta($tipo, $pag = "1") {
        if ($tipo == "html") return APP_ROOT.DS.'pags'.DS.'blog'.DS.$this->nombre.".html";
        if ($tipo == "comentarios") return APP_ROOT.DS.'pags'.DS.'blog'.DS.'comentarios.'.$this->nombre.".$pag.html";
    }


    public function Llenar_comentarios($pag = "1") {
        $comentarios = array();
        $ret = false;

        $html = $this->generarRuta("comentarios", $pag);
        if (file_exists($html)) {
            $html = simplexml_load_file($html);
            for ($i = 0; $i < count($xml->li); $i++) {
                $liId = (string) $xml->li[$i]['id'];
                $usuId = (int) $xml->li[$i]['usuId'];
                $time = (int) $xml->li[$i]['time'];
                $div = (string) $xml->li[$i];
                $comentarios[] = array('id' => $liId, 'usuId' => $usuId, 'time' => $time, 'div' => $div);
            }
            $ret = true;
        } else {
            Debuguie::AddMsg("EntradaDeBlog", "no existe el archivo xml", "error");
            return false;
        }

        $this->comentarios = $comentarios;
        return $ret;
    }

    public function PrintEntrada() {
        $html = $this->generarRuta("html");
        
        Debuguie::AddMsg("EntradaDeBlog - PrintEntrada()", "var html: $html", "info");
        Loader::LoadItemByPath($html);
    }

}