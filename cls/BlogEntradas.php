<?php

class BlogEntradas {

    public $entradas = null;
    public $ultimaEntradaId = null;
    public $entradaActiva = null;
    private $paginacionResultadosXpag = 10;

    public function BlogEntradas() {
        $this->LlenarDB_entradas();
    }

    private function LlenarDB_entradas() {
        $entradas = array();
        $ret = false;

        $mysqli = dbFuncs::crearMysqli();
        
        if ($q = $mysqli->prepare("SELECT id, visible, nombre, titulo, time, usuId FROM blog_entradas ORDER BY nombre ASC")) {
            $q->execute();
            $result = $q->get_result();

            $tempTime = 0;
            while ($row = $result->fetch_assoc()) {
                $entrada = new BlogEntrada();
                $entrada->set_props(array('id' => $row['id'], 'visible' => $row['visible'], 'nombre' => $row['nombre'], 'titulo' => $row['titulo'], 'timeCreated' => $row['time'], 'usuId' => $row['usuId']));

                if ($entrada->get('timeCreated') > $tempTime && $entrada->get('visible') != 0) {
                    $tempTime = $entrada->get('timeCreated');
                    $this->ultimaEntradaId = $row['id'];
                    $this->entradaActiva = $entrada;
                    Session::set('entradaActiva', $entrada);
                }
                $entradas[] = $entrada;
                Debuguie::AddMsg("BlogEntradas - LlenarDesdeDB_entradas()", "Cargada end(entradas): id:" . end($entradas)->get('id') . " | nom: " . end($entradas)->get('nombre'), "success");
            }
            
            Debuguie::AddMsg("BlogEntradas - LlenarDesdeDB_entradas()", "", "success");
            $ret = true;
        } else {
            Debuguie::AddMsg("BlogEntradas - LlenarDesdeDB_entradas()", "Err: " . "fallo prepare", "error");
            if (!DEBUGUEANDO) die();
            $entradas = null;
        }

        $this->entradas = $entradas;
        $mysqli->close();
        return $ret;
    }
    
    public function TraerEntradaXnombre($nombre) {
        if (BlogEntrada::Validar("nombre", $nombre) != 1) {
            //no es un nom válido
            return false;
        }
        
        foreach ($this->entradas as $entrada) {
            if ($nombre == $entrada->get('nombre')) {
                $this->entradaActiva = $entrada;
                Session::set('entradaActiva', $entrada);
                return true;
            }
        }
        //no existe esa entrada
        return false;
    }

}