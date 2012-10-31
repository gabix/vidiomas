<?php
require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'init.php';

class BlogEntrada {

    //<editor-fold desc="props">
    private $id = -1;
    private $visible = 1;
    private $nombre = "";
    private $titulo = "";
    private $timeCreated = 0;
    private $usuId = 0;
    private $comentarios = null;
    // otras
    private $excludeGet = array('excludeGet', 'excludeSet');
    private $excludeSet = array('excludeGet', 'excludeSet');

    public function get($prop) {
        if (!isset($this->$prop)) {
            trigger_error("Err: No existe la propiedad $prop, en get.");
            return false;
        }
        if (!in_array((string) $prop, $this->excludeGet)) {
            return $this->$prop;
        }
        trigger_error("get_$prop excluido, ");
    }

    public function set($prop, $val) {
        if (!isset($this->$prop)) {
            trigger_error("Err: No existe la propiedad $prop, en set.");
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

    public static function Validar($prop, $val) {
        //TODO: agregar funcionalidad de msg (cosa inválida porque)
        $ret = false;

        if ($prop == "comId" || $prop == "usuId" || $prop == "id") {
            $ret = is_numeric($val);
        } elseif ($prop == "visible") {
            if ($val == 0 || $val == 1) {
                $ret = true;
            }
        } elseif ($prop == "nombre") {
            $exp = '#^([0-9a-zA-Z\-]{1,75})$#';
            if (preg_match($exp, $val) === 1) {
                $ret = true;
            }
        } elseif ($prop == "titulo") {
            $count = strlen($val);
            if (0 < $count && $count < 200) {
                $ret = true;
            }
        } elseif ($prop == "txt") {
            $exp = array('/(<([^>]+)>)/', '/ |&nbsp;|\r\n|\r|\n/');
            $val = preg_replace($exp, "", $val);
            if (strlen($val) > 2) {
                $ret = true;
            }
        }

        Debuguie::AddMsg("BlogEntrada - Validar()", "prop: $prop | val: $val | ret: $ret", "info");
        return $ret;
    }

    //</editor-fold>

    public function Crear_entrada($txt) {
        $return = false;

        if ($this->CrearDB_entrada() && $this->CrearModificarArch_entrada($txt)) {
            $return = true;
        }

        return $return;
    }

    public function Modificar_entrada($txt, $titulo) {
        $return = false;

        $return = $this->CrearModificarArch_entrada($txt);
        Debuguie::AddMsg("BlogEntrada - Modificar_entrada()", "par tit: $titulo par thisTit $this->titulo", "info");

        if ($titulo != $this->titulo) {
            $return = $this->ModificarDB_entradaXid($titulo);
        }

        return $return;
    }

    private function ModificarDB_entradaXid($titulo) {
        $return = false;

        $mysqli = dbFuncs::crearMysqli();
        if ($q = $mysqli->prepare('UPDATE blog_entradas SET titulo = ? WHERE id = ?')) {
            Debuguie::AddMsg("BlogEntrada - ModificarDB_entradaXid()", "bindeame esto: tit: $this->titulo, id: $this->id ", "info");

            $q->bind_param('si', $titulo, $this->id);
            $q->execute();

            if ($q->affected_rows == 1) {
                $return = true;
                Debuguie::AddMsg("BlogEntrada - ModificarDB_entradaXid()", "", "success");
            } else {
                Debuguie::AddMsg("BlogEntrada - ModificarDB_entradaXid()", "no se afectaron filas", "warning");
            }
        } else {
            Debuguie::AddMsg("BlogEntrada - ModificarDB_entradaXid()", "Err: " . "fallo prepare", "error");
            if (!DEBUGUEANDO)
                die();
        }

        $mysqli->close();
        return $return;
    }

    private function CrearDB_entrada() {
        $return = false;

        $mysqli = dbFuncs::crearMysqli();
        if ($q = $mysqli->prepare("INSERT INTO blog_entradas (visible, nombre, titulo, time, usuId) VALUES (?, ?, ?, ?, ?)")) {
            $q->bind_param('issii', $this->visible, $this->nombre, $this->titulo, $this->timeCreated, $this->usuId);
            $q->execute();
            $return = true;
        } else {
            Debuguie::AddMsg("BlogEntrada - CrearDB_entrada()", "Err: " . "falló prepare", "error");
            if (!DEBUGUEANDO)
                die();
        }

        $mysqli->close();
        return $return;
    }

    public function EliminarRestaurarDB_entrada() {
        $return = false;

        $visible = 0;
        if ($this->visible == 1)
            $visible = 0;
        if ($this->visible == 0)
            $visible = 1;

        $mysqli = dbFuncs::crearMysqli();
        if ($q = $mysqli->prepare("UPDATE blog_entradas SET visible = $visible WHERE id = ?")) {
            $q->bind_param('i', $this->id);
            $q->execute();

            if ($q->affected_rows == 1) {
                $return = true;
                Debuguie::AddMsg("BlogEntrada - EliminarRestaurarDB_entrada()", "", "success");
            } else {
                Debuguie::AddMsg("BlogEntrada - EliminarRestaurarDB_entrada()", "no se afectaron filas", "warning");
            }
        } else {
            Debuguie::AddMsg("BlogEntrada - LlenarDesdeDB_entradaXnombre()", "Err: " . "falló prepare", "error");
            if (!DEBUGUEANDO) die();
        }

        $mysqli->close();
        return $return;
    }

    public function LlenarDB_entradaXnombre($nombre) {
        $return = false;
        if (self::Validar('nombre', $nombre) == 0) {
            Debuguie::AddMsg("BlogEntrada - LlenarDesdeDB_entradaXnombre()", "param nombre inválido: " . $nombre, "error");
            return $return;
        }

        $mysqli = dbFuncs::crearMysqli();
        if ($q = $mysqli->prepare("SELECT id, visible, titulo, time, usuId FROM blog_entradas WHERE nombre = ?")) {
            $q->bind_param('s', $nombre);
            $q->execute();
            $q->store_result();
            $titulo = $time = $usuId = null;
            $q->bind_result($id, $visible, $titulo, $time, $usuId);
            $q->fetch();

            if ($q->num_rows == 1) {
                $this->id = $id;
                $this->visible = $visible;
                $this->nombre = $nombre;
                $this->titulo = $titulo;
                $this->timeCreated = $time;
                $this->usuId = $usuId;

                $return = true;
                Debuguie::AddMsg("BlogEntrada - LlenarDesdeDB_entradaXnombre()", "" . $this->id, "success");
            } else {
                Debuguie::AddMsg("BlogEntrada - LlenarDesdeDB_entradaXnombre()", "No existe esa entrada en la DB", "warning");
            }
        } else {
            Debuguie::AddMsg("BlogEntrada - LlenarDesdeDB_entradaXnombre()", "Err: " . "falló prepare", "error");
            if (!DEBUGUEANDO)
                die();
        }

        $mysqli->close();
        return $return;
    }

    private function CrearModificarArch_entrada($txt) {
        $txt = SuperFuncs::ComentarScriptsDeStr($txt);
        $html = APP_ROOT.DS.BLOG_PAGES_LOCATION.DS.$this->nombre.".html";

        $puntero = fopen($html, 'w');
        fwrite($puntero, $txt);
        fclose($puntero);

        Debuguie::AddMsg("BlogEntrada - CrearModificarArch_entrada()", "", "success");
        return true;
    }

    public function PrintEntrada() {
        $html = APP_ROOT.DS.BLOG_PAGES_LOCATION.DS.$this->nombre.".html";
        Loader::LoadItemByPath($html);
        Debuguie::AddMsg("BlogEntrada - PrintEntrada()", "", "success");
    }

    public function LlenarComentarios($pag = "1") {
        $BlCo = new BlogComentarios($this->nombre);
        $this->comentarios = $BlCo->comentarios;

        Debuguie::AddMsg("BlogEntrada - LlenarComentarios($pag)", "this->comments: " . $this->comentarios, "info");
    }

}