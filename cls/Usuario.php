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
    private $excludeGet = array('excludeGet', 'excludeSet', 'instance', 'todasProps', 'cookieProps'); //acá van las propiedades que no se pueden tocar por get, ej: 'id', 'tuVieja'
    private $excludeSet = array('loged', 'excludeGet', 'excludeSet', 'instance', 'todasProps', 'cookieProps'); //acá van las propiedades que no se pueden tocar por set, ej: 'id', 'tuVieja'
    private $todasProps = array("id", "apodo", "email", "categoria", "creditos", "login_string", "nombre", "pais", "sexo", "tel", "codpostal", "lang", "time");
    private $cookieProps = array("id", "apodo", "email", "login_string", "nombre", "pais", "sexo", "tel", "codpostal", "lang", "time");

    // </editor-fold>
    // 
    // <editor-fold desc="Propiedades">

    /**
     * get para 1SOLA propiedad
     * @param string $prop nombre de la prop
     * @return string|int el valor de esa prop
     */
    public function get($prop) {
        if (isset($this->$prop) && !in_array((string) $prop, $this->excludeGet)) {
            $return = $this->$prop;

            Debuguie::AddMsg("Usuario - get()", "args=($prop) ret=($return)", "success");
            return $return;
        }

        Debuguie::AddMsg("Usuario - get()", "$prop excluida o inexistente", "warning");
        return null;
    }

    /**
     * set para 1SOLA propiedad
     * @param string $prop nombre de la prop
     * @param $val value para la prop
     * @return int|null el seteo de la prop o null
     */
    public function set($prop, $val) {
        if (isset($this->$prop) && !in_array($prop, $this->excludeSet)) {
            $return = $this->$prop = $val;

            Debuguie::AddMsg("Usuario - set()", "args=($prop) ret=($return)", "success");
            return $return;
        }

        Debuguie::AddMsg("Usuario - set()", "$prop excluida o inexistente", "warning");
        return null;
    }

    /**
     * setea propiedades de la clase por array
     * @param $params ej=array('id' => 0, 'apodo' => 'pumba', etc)
     * @return bool true pa éxitos, false pa error
     */
    public function set_props($params) {
        Debuguie::AddMsg("Usuario - set_props()", "params=(".json_encode($params).")", "fInit");

        foreach ($params as $prop => $val) {
            if (!isset($this->$prop)) {
                Debuguie::AddMsg("Usuario - set_props()", "no existe prop=($prop)", "error");

                return false;
            }
            $this->set($prop, $val);
        }
        return true;
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
                trigger_error("Err: No existe la propiedad $prop, en get_props, ");
                return false;
            }
            //if (SuperFuncs::debuguie) {SuperFuncs::debuguie("en c_usu: met: get_props ");}
            $ret[$prop] = $this->get($prop);
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
        Debuguie::AddMsg("Usuario - set_todo()", "", "fInit");
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
        Debuguie::AddMsg("Usuario - checkBrute()", "params user_id=($user_id), y mysqli", "fInit");

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
                Debuguie::AddMsg("Usuario - checkBrute()", "hubo más de 10 intentos de logueo (ret true)", "success");

                return true;
            } else {
                Debuguie::AddMsg("Usuario - checkBrute()", "no hubo más de 10 intentos de logueo (ret false)", "success");

                return false;
            }
        }
        Debuguie::AddMsg("Usuario - checkBrute()", "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");

        return false;
    }

    /**
     * Dándole un email y pass setea todos los parámetros de esta clase
     * @param string $email
     * @param string $pass la contraseña ya hasheada
     * @return array 'err' => t/f, 'msg' => mensaje de error
     */
    private function deDBPropsXemailYpass($email, $pass) {
        Debuguie::AddMsg("Usuario - deDBPropsXemailYpass()", "params email=($email), pass=($pass)", "fInit");

        $mysqli = dbFuncs::DBcrearMysqli();
        if (null == $mysqli) return array('err' => true, 'msg' => "noConectaAdb");

        if ($q = $mysqli->prepare("SELECT id, apodo, categoria, pass, salt, creditos, nombre, pais, sexo, tel, codpostal, lang, time FROM usuarios WHERE email = ? LIMIT 1")) {
            $q->bind_param('s', $email);
            $q->execute();
            $q->store_result();
            /** @noinspection PhpUndefinedVariableInspection */
            $q->bind_result($user_id, $apodo, $categoria, $db_password, $salt, $creditos, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time);
            $q->fetch();
            $pass = hash('sha512', $pass . $salt);

            if ($q->num_rows == 1) {
                if ($this->checkBrute($user_id, $mysqli) == true) {
                    // usuario bloqueado!
                    Debuguie::AddMsg("Usuario - deDBPropsXemailYpass()", "usuario bloqueado por 2hrs", "success");

                    $mysqli->close();
                    return array('err' => true, 'msg' => "usuarioBloqueado");
                } else {
                    if ($db_password == $pass) {
                        Debuguie::AddMsg("Usuario - deDBPropsXemailYpass()", "dbPass = a pass", "success");
                        // Password is correct!

                        $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
                        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                        $login_string = hash('sha512', $pass . $ip_address . $user_browser);

                        $this->set_todo($user_id, $apodo, $email, $categoria, $creditos, $login_string, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time);

                        Debuguie::AddMsg("Usuario - deDBPropsXemailYpass()", "this->loged a true", "success");
                        $this->loged = true;

                        $mysqli->close();

                        return array('err' => false, 'msg' => "");
                    } else {
                        Debuguie::AddMsg("Usuario - deDBPropsXemailYpass()", "dbPass != a pass", "success");
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
                Debuguie::AddMsg("Usuario - deDBPropsXemailYpass()", "no existe el mail", "success");

                $mysqli->close();
                return array('err' => true, 'msg' => "noExisteMail");
            }
        }
        Debuguie::AddMsg("Usuario - deDBPropsXemailYpass()", "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");

        $mysqli->close();
        return array('err' => true, 'msg' => "noConectaAdb");
    }

    /**
     * trae de db la cat y los cred asociados a un id, y los carga en las props de la clase
     * @param int $usuId
     * @return array 'err' => true, 'msg' => ""
     */
    private function dbDBcatYcreditosXid($usuId) {
        $mysqli = dbFuncs::DBcrearMysqli();
        if (null == $mysqli) return array('err' => true, 'msg' => "noConectaAdb");

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
        Debuguie::AddMsg("Usuario - dbDBcatYcreditosXidYpass()", "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");
        return array('err' => true, 'msg' => "noConectaAdb");
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

        $mysqli = dbFuncs::DBcrearMysqli();
        if (null == $mysqli) return array('err' => true, 'msg' => "noConectaAdb");

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
        Debuguie::AddMsg("Usuario - checkCookie()", "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");
        return false;
    }

    /**
     * Genera un cookie con todas las props no protegidas
     */
    private function setCookies() {
        Debuguie::AddMsg("Usuario - setCookies()", "", "fInit");
        $paCookie = $this->get_props($this->cookieProps);

        foreach ($paCookie as $cooKey => $val) {
            $cooName = "usu[".$cooKey."]";

            Cookie::set($cooName, $val);
        }
    }

    private function killCookies() {
        Debuguie::AddMsg("Usuario - killCookies()", "", "fInit");
        foreach ($this->cookieProps as $cooKey) {
            $cooName = "usu[".$cooKey."]";

            Cookie::kill($cooName);
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
        Debuguie::AddMsg("Usuario - setSession()", "", "fInit");

        $propsConValor = null;
        foreach($this->todasProps as $prop) {
            $propsConValor[] = array($prop => $this->$prop);
        }

        Session::set('usu', $propsConValor);
        Session::set('lang', $this->lang);

        /*Session::set('usu', array(
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
        */
    }

    /**
     * verifica si la cookie existe y todavía es válida, y luego carga de la db la categoría y los créditos
     * @return array 'err' => t/f, 'msg' => mensaje de error
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
        Debuguie::AddMsg("Usuario - loguear()", "params email=($email), pass=($pass), cookie=($cookie)", "fInit");

        $rta = $this->deDBPropsXemailYpass($email, $pass);
        Debuguie::AddMsg("Usuario - loguear()", "rta=(".json_encode($rta).")", "info");

        if (!$rta['err']) {
            //props de this ya seteadas --> guardo el usu en sess

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
        Debuguie::AddMsg("Usuario - inicio()", "", "fInit");

        if (Session::get('usu')) {
            Debuguie::AddMsg("Usuario - inicio()", "hay usu sess", "info");

            //TODO: función rta de q seteo correctamente.
            $this->set_props(Session::get('usu'));
            $this->loged = true;
            return null;
        } else {
            //hay cookie?
            //SuperFuncs::debuguie("cusu", "no sess");
            if (isset($_COOKIE["usu"])) {
                Debuguie::AddMsg("Usuario - inicio()", "hay cookie usu", "info");
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
