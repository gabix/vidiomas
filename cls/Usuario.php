<?php

/**
 * clase de Usuario
 *
 * @author gabix
 */
class Usuario {

    // <editor-fold desc="Atributos Generales">
    //en la db
    private $id = -1;
    private $apodo = "";
    private $email = "";
    private $categoria = -1;
    private $creditos = -1;
    private $nombre = "";
    private $pais = "";
    private $sexo = "";
    private $tel = "";
    private $codpostal = "";
    private $lang = "en";
    private $time = 0;
    //de acá
    private static $instance = null;
    private $login_string = "";
    private $loged = false;
    // otras
    private $excludeGet = array('excludeGet', 'excludeSet', 'instance'); //acá van las propiedades que no se pueden tocar por get, ej: 'id', 'tuVieja'
    private $excludeSet = array('excludeGet', 'excludeSet', 'instance', 'loged'); //acá van las propiedades que no se pueden tocar por set, ej: 'id', 'tuVieja'
    private $todasProps = array("id", "apodo", "email", "categoria", "creditos", "login_string", "nombre", "pais", "sexo", "tel", "codpostal", "lang", "time");
    private $cookieProps = array("id", "apodo", "email", "login_string", "nombre", "pais", "sexo", "tel", "codpostal", "lang", "time");

    // </editor-fold>
    // 
    // <editor-fold desc="Propiedades">

    /**
     * _get para 1SOLA propiedad
     * @param (string) $prop nombre de la prop
     * @return type el valor de esa prop
     */
    private function _get($prop) {
        if (!in_array((string) $prop, $this->excludeGet)) {
            return $this->$prop;
        }
        trigger_error("_get_$prop excluido, ");
    }

    private function _set($prop, $val) {
        if (!in_array($prop, $this->excludeSet)) {
            return $this->$prop = $val;
        }
        trigger_error("_set_$prop excluido, ");
    }

    public function __call($metodo, $argumentos) {
        //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu: met: $metodo args: " . json_encode($argumentos));}
        $prop = $setter = $getter = false;
        if (strpos($metodo, 'set_') === 0) {
            $setter = true;
            $prop = substr($metodo, 4);
        } elseif (strpos($metodo, 'get_') === 0) {
            $getter = true;
            $prop = substr($metodo, 4);
        }
        if (!isset($this->$prop)) {
            trigger_error("Err: No existe la porpiedad $prop, en __call, ");
        }
        //$prop tiene ahora el nombre de la propiedad a setear / traer
        if ($getter) {
            return $this->_get($prop);
        } elseif ($setter) {
            return $this->_set($prop, $argumentos[0]);
        }
        trigger_error("Método $metodo inexistente.");
    }

    public function set_props($params) {
        //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu: met: set_props args: " . json_encode($params));}
        foreach ($params as $prop => $val) {
            if (!isset($this->$prop)) {
                trigger_error("Err: No existe la porpiedad $prop, en set_props, ");
                return false;
            }
            $this->_set($prop, $val);
            //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu: set_props set($prop, $val)");}
        }
    }

    /**
     * para traer todas las propiedades de la clase pedidas en $params
     * @param type array(), ej: array('xx1', 'xx2')
     * @return type array(), ej: array('xx1' => 'el val de xx1', 'xx2' => 'el val de xx2') 
     */
    public function get_props($params) {
        //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu: met: get_props args: " . json_encode($params));}
        $ret = array();
        foreach ($params as $prop) {
            if (!isset($this->$prop)) {
                //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu: met: get_props ");}
                trigger_error("Err: No existe la porpiedad $prop, en get_props, ");
                return false;
            }
            //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu: met: get_props ");}
            $ret[$prop] = $this->_get($prop);
        }
        return $ret;
    }

    // </editor-fold>
    // 
    // <editor-fold desc="Inicializadores">
    
    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new Usuario();
        }
        return self::$instance;
    }

    private function set_todo($id, $apodo, $email, $categoria, $creditos, $login_string, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time) {
        $this->id = $id;
        $this->apodo = $apodo;
        $this->email = $email;
        $this->categoria = $categoria;
        $this->creditos = $creditos;
        $this->login_string = $login_string;
        $this->nombre = $nombre;
        $this->pais = $pais;
        $this->sexo = $sexo;
        $this->tel = $tel;
        $this->codpostal = $codpostal;
        $this->lang = $lang;
        $this->time = $time;
    }

    // </editor-fold> 
    // <editor-fold desc="Metodos Privados">

    private function checkBrute($user_id, $mysqli) {
        $now = time();
        // All login attempts are counted from the past 2 hours. 
        $valid_attempts = $now - (2 * 60 * 60);

        if ($q = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
            $q->bind_param('i', $user_id);
            // Execute the prepared query.
            $q->execute();
            $q->store_result();

            // If there has been more than 10 failed logins
            if ($q->num_rows > 10) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * Dandole un email y pass setea todos los parametros de esta clase
     * @param (string) $email 
     * @param (string) $pass la contraseña ya hasheada
     * @return (array) 'err' => t/f, 'msg' => mensaje de error 
     */
    private function deDBPropsXemailYpass($email, $pass) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            return array('err' => true, 'msg' => "noConectaAdb-" . mysqli_connect_error());
            die();
        }
        if ($q = $mysqli->prepare("SELECT id, apodo, categoria, pass, salt, creditos, nombre, pais, sexo, tel, codpostal, lang, time FROM usuarios WHERE email = ? LIMIT 1")) {
            $q->bind_param('s', $email);
            $q->execute();
            $q->store_result();
            $q->bind_result($user_id, $apodo, $categoria, $db_password, $salt, $creditos, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time);
            $q->fetch();
            $pass = hash('sha512', $pass . $salt);

            if ($q->num_rows == 1) {
                if ($this->checkBrute($user_id, $mysqli) == true) {
                    // usuario bloqueado!
                    // TODO: mandar email informando que el usu esta bloqueado
                    $mysqli->close();
                    return array('err' => true, 'msg' => "usuarioBloqueado");
                } else {
                    if ($db_password == $pass) {
                        // Password is correct!
                        $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
                        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                        $login_string = hash('sha512', $pass . $ip_address . $user_browser);

                        $this->set_todo($user_id, $apodo, $email, $categoria, $creditos, $login_string, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time);
                        $this->loged = true;

                        $mysqli->close();
                        return array('err' => false, 'msg' => "");
                    } else {
                        // Password is not correct
                        // We record this attempt in the database
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts (user_id, time) VALUES ('$user_id', '$now')");
                        $mysqli->close();
                        return array('err' => true, 'msg' => "passIncorrecta");
                    }
                }
            } else {
                //no existe el mail
                $mysqli->close();
                return array('err' => true, 'msg' => "noExisteMail");
            }
        }
        $mysqli->close();
        return array('err' => true, 'msg' => "falloSqlPrep-deDBPropsXemailYpass");
    }

    /**
     * trae de db la cat y los cred asociados a un id, y los carga en las props de la clase
     * @param (int) $usuId
     * @return (array) 'err' => true, 'msg' => ""
     */
    private function dbDBcatYcreditosXid($usuId) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            return array('err' => true, 'msg' => "noConectaAdb-" . mysqli_connect_error());
            die();
        }
        if ($q = $mysqli->prepare("SELECT categoria, creditos FROM usuarios WHERE id = ? LIMIT 1")) {
            $q->bind_param('i', $usuId);
            $q->execute();
            $q->store_result();

            if ($q->num_rows == 1) {
                $q->bind_result($cat, $cred);
                $q->fetch();

                $this->set_props(array('categoria' => $cat, 'creditos' => $cred));
                $mysqli->close();
                return array('err' => false, 'msg' => "");
                ;
            }
        }
        $mysqli->close();
        return array('err' => true, 'msg' => "falloSqlPrep-dbDBcatYcreditosXidYlogString");
    }

    /** checkCookie
     * para comprobar que la cookie es valida
     * @param type $usuId
     * @param type $logStr
     * @return bool
     */
    private function checkCookie($usuId, $logStr) {
        //if (SuperFuncs::debuguie) { SuperFuncs::debuguie("cusu-checkCookie", "entré"); }

        $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user. 
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            return array('err' => true, 'msg' => "noConectaAdb-" . mysqli_connect_error());
            die();
        }

        if ($q = $mysqli->prepare("SELECT pass FROM usuarios WHERE id = ? LIMIT 1")) {
            $q->bind_param('i', $usuId);
            $q->execute();
            $q->store_result();

            if ($q->num_rows == 1) {
                $q->bind_result($pass); // get variables from result.
                $q->fetch();
                $login_string = hash('sha512', $pass . $ip_address . $user_browser);
                //if (SuperFuncs::debuguie) { SuperFuncs::debuguie("cusu-checkCookie", "$login_string"); }

                if ($login_string == $logStr) {
                    // cookie correcta
                    $mysqli->close();
                    return true;
                } else {
                    $mysqli->close();
                    return false;
                }
            } else {
                $mysqli->close();
                return false;
            }
        }
        $mysqli->close();
        return false;
    }

    /**
     * Genera un cookie con todas las props no protegidas
     */
    private function setCookies() {
        $paCookie = $this->get_props($this->cookieProps);

        foreach ($paCookie as $cooKey => $val) {
            $cooname = "usu_".$cooKey;

            Cookie::set($cooname, $val);
        }
    }

    private function killCookies() {
        foreach ($this->cookieProps as $cooKey) {
            $cooname = "usu_".$cooKey;

            Cookie::kill($cooname);
        }
        
    }

    // </editor-fold>
    // 
    // <editor-fold desc="Métodos Publicos">
    /**
     * Carga todas las props en sess usu ($this->props)
     * y tb genera $_SESSION['lang'] con el lang pref del usu
     * ojo con inciar sess antes!
     */
    private function setSession() {
        //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu->aSess", "init");}
        Session::set('usu', array(
            'id' => $this->id,
            'apodo' => $this->apodo,
            'email' => $this->email,
            'categoria' => $this->categoria,
            'creditos' => $this->creditos,
            'login_string' => $this->login_string,
            'nombre' => $this->nombre,
            'pais' => $this->pais,
            'sexo' => $this->sexo,
            'tel' => $this->tel,
            'codpostal' => $this->codpostal,
            'lang' => $this->lang,
            'time' => $this->time
        ));
        Session::set('lang', $this->lang);
        $this->loged = true;
    }

    /**
     * verifica si la cookie existe y todavía es válida, y luego carga de la db la categoría y los créditos
     * @return (array) 'err' => t/f, 'msg' => mensaje de error 
     */
    private function deCookieAsess() {
        if (isset($_COOKIE["usu"]['id']) && isset($_COOKIE["usu"]['login_string'])) {
            //if (SuperFuncs::debuguie) { SuperFuncs::debuguie("cusu-deCookieAsess", "si isset"); }

            $usuId = $_COOKIE["usu"]['id'];
            $logStr = $_COOKIE["usu"]['login_string'];
            //if (SuperFuncs::debuguie) { SuperFuncs::debuguie("cusu-deCookieAsess", "usuID: $usuId, logStr: $logStr"); }
            $chkCook = $this->checkCookie($usuId, $logStr);

            //if (SuperFuncs::debuguie) { SuperFuncs::debuguie("cusu-deCookieAsess", sprintf(json_encode($chkCook))); }
            if ($chkCook) {
                $this->dbDBcatYcreditosXid($usuId);

                foreach ($_COOKIE["usu"] as $k => $val) {
                    $this->$k = $val;
                }
                $this->setSession();

                $this->loged = true;
                return array('err' => false, 'msg' => "");
            } else {
                return array('err' => true, 'msg' => 'cookieDesactualizada');
            }
        } else {
            return array('err' => true, 'msg' => 'noExisteCookie');
        }
    }

    /**
     * se hace?
     * @param type $id
     * @param type $logStr 
     */
    public function logueadoXdb($id, $logStr) {
        //TODO: logueadoXdb si es nesario
    }

    /**
     * 
     * @param string $email
     * @param string $pass
     * @param bool $cookie
     * @return array 'err' => t/f, 'msg' => mensaje de error
     */
    public function loguear($email, $pass, $cookie = false) {
        $rta = $this->deDBPropsXemailYpass($email, $pass);
        //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu->loguear", $rta);}
        if (!$rta['err']) {
            //props de this seteadas, guardo el usu en sess
            //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu->loguear", "si log");}

            $this->setSession();
            if ($cookie) {
                $this->setCookies();
            }
            return $rta;
        } else {
            //no logueado
            //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu->loguear", "no log");}

            return $rta;
        }
    }
    
    public function inicio() {
        if (Session::get('usu')) {
            //SuperFuncs::debuguie("cusu", "si sess");
            //TODO: función rta de q seteo correctamente.
            $this->set_props(Session::get('usu'));
            $this->loged = true;
            return null;
        } else {
            //hay cookie?
            //SuperFuncs::debuguie("cusu", "no sess");
            if (isset($_COOKIE["usu"])) {
                $this->deCookieAsess();
            }
            return null;
        }
        
    }

    /**
     * Redirige a wwwwww/logout.php
     */
    public static function logout() {
        return self::instance()->killCookies();
    }

    // </editor-fold> 
}
