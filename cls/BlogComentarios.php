<?php
class BlogComentarios {
    public $comentarios = array();
    private $cPagRuta = "";
    private $file = null;
    private $ultimoComId = 0;

    public function __construct($nomEntrada, $pag = 1) {
        Debuguie::AddMsg("BlogComentarios - __construct()", "", "info");

        $this->cPagRuta = $ruta = Loader::LoadObjectPath("pags_blog", $nomEntrada, "php", "c$pag");
        $this->file = new SuperFile($ruta);

        $this->LlenarComentarios();
    }

    private function LlenarComentarios() {
        $comentarios = $this->file->get();

        if (count($comentarios) > 0) {
            Debuguie::AddMsg("BlogComentarios - LlenarComentarios()", "entré", "info");
            $uId = 0;
            foreach ($comentarios as $c) {
                if ($c['comId'] > $uId) $uId = $c['comId'];
            }
            $this->ultimoComId = $uId;
            $this->comentarios = $comentarios;
        } else Debuguie::AddMsg("BlogComentarios - LlenarComentarios()", "no hay comentarios", "info");
        return true;
    }

    private function GuardarComentarios() {
        Debuguie::AddMsg("BlogComentarios - GuardarComentarios()", "cPagRuta: $this->cPagRuta", "info");

        return $this->file->put($this->comentarios);
    }

    public function ModificarComentario($comId, $txt) {
        Debuguie::AddMsg("BlogComentarios - ModificarComentario()", "", "info");

        $reCom = array();
        foreach ($this->comentarios as $c) {
            if ($c['comId'] == $comId) {
                $c['txt'] = $txt;
                $c['time'] = time();
            }
            $reCom[] = $c;
        }
        $this->comentarios = $reCom;
        return $this->GuardarComentarios();
    }

    public function EliminarRestaurarComentario($comId) {
        Debuguie::AddMsg("BlogComentarios - ElimiarComentario()", "", "info");

        $reCom = array();
        foreach ($this->comentarios as $c) {
            if ($c['comId'] != $comId) {
                $reCom[] = $c;
            } else {
                if ($c['visible'] == 1) {
                    $c['visible'] = 0;
                } elseif ($c['visible'] == 0) {
                    $c['visible'] = 1;
                }
                $reCom[] = $c;
            }
        }
        $this->comentarios = $reCom;
        return $this->GuardarComentarios();
    }

    public function AgregarComentario($usuId, $txt) {
        Debuguie::AddMsg("BlogComentarios - AgregarComentario()", "", "info");

        $this->comentarios[] = array(
            'comId' => $this->ultimoComId + 1,
            'visible' => 1,
            'usuId' => (int)$usuId,
            'time' => time(),
            'txt' => $txt
        );
        return $this->GuardarComentarios();
    }

}