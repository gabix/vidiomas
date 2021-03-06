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
    private $login_string = "";

    // otras
    private static $instance = null;
    private $excludeGet = array('excludeGet', 'excludeSet', 'instance', 'todasProps', 'cookieProps'); //acá van las propiedades que no se pueden tocar por get, ej: 'id', 'tuVieja'
    private $excludeSet = array('loged', 'excludeGet', 'excludeSet', 'instance', 'todasProps', 'cookieProps'); //acá van las propiedades que no se pueden tocar por set, ej: 'id', 'tuVieja'
    private $todasProps = array("id", "apodo", "email", "categoria", "creditos", "login_string", "nombre", "pais", "sexo", "tel", "codpostal", "lang", "time");

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new Usuario();
        }
        return self::$instance;
    }
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

            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "args=($prop) ret=($return)", "success");
            return $return;
        }

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "$prop excluida o inexistente", "warning");
        return null;
    }

    /**
     * set para 1SOLA propiedad
     * @param string $prop nombre de la prop
     * @param int|string $val value para la prop
     * @return bool el seteo de la prop o null
     */
    public function set($prop, $val) {
        if (isset($this->$prop) && !in_array($prop, $this->excludeSet)) {
            $return = $this->$prop = $val;

            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "args=($prop) ret=($return)", "success");
            return $return;
        }

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "$prop excluida o inexistente", "warning");
        return null;
    }

    /**
     * setea propiedades de la clase por array
     * @param $params ej=array('id' => 0, 'apodo' => 'pumba', etc)
     * @return bool true pa éxitos, false pa error
     */
    public function set_props($params) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "params=(".json_encode($params).")", "fInit");

        foreach ($params as $prop => $val) {
            if (!isset($this->$prop)) {
                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "no existe prop=($prop)", "error");

                return false;
            }
            $this->set($prop, $val);
        }
        return true;
    }

    /**
     * para traer todas las propiedades de la clase pedidas en $params
     * @param array, ej: array('xx1', 'xx2')
     * @return array, ej: array('xx1' => 'el val de xx1', 'xx2' => 'el val de xx2')
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

    /**
     * Setea TODAS las props de DB de usuario
     * @param $id
     * @param $apodo
     * @param $email
     * @param $categoria
     * @param $creditos
     * @param $login_string
     * @param $nombre
     * @param $pais
     * @param $sexo
     * @param $tel
     * @param $codpostal
     * @param $lang
     * @param $time
     */
    private function set_todo($id, $apodo, $email, $categoria, $creditos, $login_string, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "", "fInit");

        foreach ($this->todasProps as $prop) {
            $this->$prop = ${$prop};
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "seteo this->$prop=(".$this->$prop.")", "info");
        }

        /*
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
        */
    }

    // </editor-fold>
    //
    // <editor-fold desc="Validaciones de inputs">


    // </editor-fold>
    // 
    // <editor-fold desc="Métodos privados">

    /**
     * Carga todas las props en sess usu ($this->props)
     * y tb genera $_SESSION['lang'] con el lang pref del usu
     */
    private function setSession() {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "", "fInit");

        $propsConValor = $this->get_props($this->todasProps);

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "pConVal=(".json_encode($propsConValor).")", "fInit");

        Session::set('usu', $propsConValor);
        Session::set('lang', $propsConValor['lang']);
    }

    /**
     * verifica si la cookie existe y todavía es válida, y luego carga de la db la categoría y los créditos
     * @return bool (t pa logueado, f pa NO logueado)
     */
    private function loguearXcookie() {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "", "fInit");

        if (false != Cookie::get('usu_log')) {
            $tea = new TEA();
            $valPaCook = $tea->decrypt(Cookie::get('usu_log'), ENCKEY);
            $vals = explode("|", $valPaCook);

            if (is_array($vals) && count($vals) === 2) {
                $logStr = $vals[0];
                $usuId = $vals[1];

                $ret = $this->deDBPropsXusuIdYlogStr($usuId, $logStr);

                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "logueado? (ret=$ret)", "info");
                if ($ret) {
                    $this->setSession();
                }

                return $ret;
            } else {
                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "cookie fea y mala", "info");
                return false;
            }
        } else {
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "no cookie no cry", "info");
            return false;
        }
    }

    // </editor-fold> 
    // <editor-fold desc="Metodos x DB">

    /**
     * Dándole un useId, verifica que ese uduario no se zarpe en cantidades de logueo.
     * si hubo más de 10 intentos de logueos erroneos devuelve false.
     * @param $user_id
     * @param $mysqli
     * @return bool
     */
    private function checkBrute($user_id, $mysqli) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "params user_id=($user_id), y mysqli", "fInit");

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
                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "hubo más de 10 intentos de logueo (ret true)", "success");

                return true;
            } else {
                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "no hubo más de 10 intentos de logueo (ret false)", "success");

                return false;
            }
        }
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");

        return false;
    }

    /**
     * Dándole un email y pass setea todos los parámetros de esta clase
     * @param string $email
     * @param string $pass la contraseña ya hasheada
     * @return array 'err' => t/f, 'msg' => mensaje de error
     */
    private function deDBPropsXemailYpass($email, $pass) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "params email=($email), pass=($pass)", "fInit");

        $mysqli = dbFuncs::crearMysqli();

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
                    Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "usuario bloqueado por 2hrs", "success");

                    $mysqli->close();
                    return array('err' => true, 'msg' => "usuarioBloqueado");
                } else {
                    if ($db_password == $pass) {
                        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "dbPass = a pass", "success");
                        // Password is correct!

                        $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
                        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                        $login_string = hash('sha512', $pass . $ip_address . $user_browser);

                        $this->set_todo($user_id, $apodo, $email, $categoria, $creditos, $login_string, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time);

                        $mysqli->close();
                        return array('err' => false, 'msg' => "");

                    } else {
                        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "dbPass != a pass", "success");
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
                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "no existe el mail", "success");

                $mysqli->close();
                return array('err' => true, 'msg' => "noExisteMail");
            }
        }
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");

        $mysqli->close();
        return array('err' => true, 'msg' => "noConectaAdb");
    }

    /** deDBPropsXusuIdYlogStr
     * para comprobar que la cookie es valida
     * @param $usuId
     * @param $logStr
     * @return bool (t pa logueado, f pa NO logueado)
     */
    private function deDBPropsXusuIdYlogStr($usuId, $logStr) {

        Debuguie::AddMsg("Usuario - ".__METHOD__."()", "params usuId=($usuId), logStr=($logStr)", "fInit");

        $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

        $mysqli = dbFuncs::crearMysqli();
        if ($q = $mysqli->prepare("SELECT email, apodo, categoria, pass, salt, creditos, nombre, pais, sexo, tel, codpostal, lang, time FROM usuarios WHERE id = ? LIMIT 1")) {
            $q->bind_param('i', $usuId);
            $q->execute();
            $q->store_result();
            /** @noinspection PhpUndefinedVariableInspection */
            $q->bind_result($email, $apodo, $categoria, $db_password, $salt, $creditos, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time);
            $q->fetch();

            if ($q->num_rows == 1) {
                //$pass = hash('sha512', $db_password . $salt);
                $login_string = hash('sha512', $db_password . $ip_address . $user_browser);

                if ($login_string == $logStr) {
                    // cookie correcta
                    $this->set_todo($usuId, $apodo, $email, $categoria, $creditos, $login_string, $nombre, $pais, $sexo, $tel, $codpostal, $lang, $time);

                    $mysqli->close();
                    return true;

                } else {
                    //cookie mala mala
                    Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "logStr <> ", "info");

                    $mysqli->close();
                    return false;
                }
            } else {
                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "num rows <> 1", "info");

                $mysqli->close();
                return false;
            }
        }

        $mysqli->close();
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");
        return false;
    }

    public function checkApodoEnUso($apodo) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "", "fInit");

        $mysqli = dbFuncs::crearMysqli();

        if ($q = $mysqli->prepare('SELECT apodo FROM usuarios WHERE apodo = ? LIMIT 1')) {
            $q->bind_param('s', $apodo);
            $q->execute();
            $q->store_result();

            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "num rows por ese apodo=(".$q->num_rows.")", "info");


            if ($q->num_rows > 0) {
                $ret = array('tipo' => 'apodoEnUso', 'err' => true);
            } else {
                $ret = array('tipo' => 'apodoEnUso', 'err' => false);
            }
        } else {
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");
        }
        $mysqli->close();

        return $ret;
    }

    public function checkEmailEnUso($email) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "", "fInit");

        $mysqli = dbFuncs::crearMysqli();

        if ($q = $mysqli->prepare('SELECT email FROM usuarios WHERE email = ? LIMIT 1')) {
            $q->bind_param('s', $email);
            $q->execute();
            $q->store_result();

            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "num rows por ese email=(".$q->num_rows.")", "info");

            if ($q->num_rows > 0) {
                $ret = array('tipo' => 'emailEnUso', 'err' => true);
            } else {
                $ret = array('tipo' => 'emailEnUso', 'err' => false);
            }
        } else {
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");
        }
        $mysqli->close();

        return $ret;
    }


    // </editor-fold>
    //
    // <editor-fold desc="Métodos Publicos">

    /**
     *
     * @param string $email
     * @param string $pass
     * @param bool $cookie
     * @return array 'err' => t/f, 'msg' => mensaje de error
     */
    public function loguear($email, $pass, $cookie = false) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "params email=($email), pass=($pass), cookie=($cookie)", "fInit");

        $rta = $this->deDBPropsXemailYpass($email, $pass);
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "rta=(".json_encode($rta).")", "info");

        if (!$rta['err']) {
            //props de this ya seteadas --> guardo el usu en sess
            $this->setSession();

            if ($cookie) {
                //guardo el login_string + el usu id en una cookie (encriptado)

                $valPaCook = $this->login_string . "|" . $this->id;
                $tea = new TEA();
                $enc = $tea->encrypt($valPaCook, ENCKEY);

                Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "enc=(".$enc.")", "info");

                Cookie::set("usu_log", $enc);
            }
            return $rta;
        } else {
            //no logueado
            return $rta;
        }
    }

    public function logueado() {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "", "fInit");

        if (Session::get('usu')) {
            //hay sess?
            $usuSess = Session::get('usu');
            $ret = $this->set_props($usuSess);

            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "hay sess, logueado=($ret)", "info");
            return $ret;
        } else {
            //hay cookie?
            $ret = $this->loguearXcookie();
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "hay cookie, logueado=(".$ret.")", "info");
            return $ret;
        }
    }

    public static function logout() {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "", "fInit");

        $kill = Cookie::kill("usu_log");
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "ret de kill=($kill)", "fInit");

        return $kill;
    }

    // </editor-fold>
}


///**
// * Genera un cookie con todas las props no protegidas
// */
//private function setCookies() {
//    Debuguie::AddMsg("Usuario - setCookies()", "", "fInit");
//    $paCookie = $this->get_props($this->cookieProps);
//
//    foreach ($paCookie as $cooKey => $val) {
//        $cooName = "usu_".$cooKey;
//
//        Cookie::set($cooName, $val);
//    }
//}
//
//private function killCookies() {
//    Debuguie::AddMsg("Usuario - killCookies()", "", "fInit");
//    foreach ($this->cookieProps as $cooKey) {
//        $cooName = 'usu_'.$cooKey;
//
//        Cookie::kill($cooName);
//    }
//}
///**
// * trae de db la cat y los cred asociados a un id, y los carga en las props de la clase
// * @param int $usuId
// * @return array 'err' => true, 'msg' => ""
// */
//private function dbDBcatYcreditosXid($usuId) {
//    $mysqli = dbFuncs::crearMysqli();
//    if (null == $mysqli) return array('err' => true, 'msg' => "noConectaAdb");
//
//    if ($q = $mysqli->prepare("SELECT categoria, creditos FROM usuarios WHERE id = ? LIMIT 1")) {
//        $q->bind_param('i', $usuId);
//        $q->execute();
//        $q->store_result();
//
//        if ($q->num_rows == 1) {
//            $q->bind_result($cat, $cred);
//            $q->fetch();
//
//            $this->set_props(array('categoria' => $cat, 'creditos' => $cred));
//            $mysqli->close();
//            return array('err' => false, 'msg' => "");
//            ;
//        }
//    }
//
//    $mysqli->close();
//    Debuguie::AddMsg("Usuario - dbDBcatYcreditosXidYpass()", "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");
//    return array('err' => true, 'msg' => "noConectaAdb");
//}
//
///** checkCookie
// * para comprobar que la cookie es valida
// * @param type $usuId
// * @param type $logStr
// * @return bool
// */
//private function checkCookie($usuId, $logStr) {
//    //if (SuperFuncs::debuguie) { SuperFuncs::debuguie("cusu-checkCookie", "entré"); }
//
//    $ip_address = $_SERVER['REMOTE_ADDR']; // Get the IP address of the user.
//    $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
//
//    $mysqli = dbFuncs::crearMysqli();
//    if (null == $mysqli) return array('err' => true, 'msg' => "noConectaAdb");
//
//    if ($q = $mysqli->prepare("SELECT pass FROM usuarios WHERE id = ? LIMIT 1")) {
//        $q->bind_param('i', $usuId);
//        $q->execute();
//        $q->store_result();
//
//        if ($q->num_rows == 1) {
//            $q->bind_result($pass); // get variables from result.
//            $q->fetch();
//            $login_string = hash('sha512', $pass . $ip_address . $user_browser);
//            //if (SuperFuncs::debuguie) { SuperFuncs::debuguie("cusu-checkCookie", "$login_string"); }
//
//            if ($login_string == $logStr) {
//                // cookie correcta
//                $mysqli->close();
//                return true;
//            } else {
//                $mysqli->close();
//                return false;
//            }
//        } else {
//            $mysqli->close();
//            return false;
//        }
//    }
//
//    $mysqli->close();
//    Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "falló el mysql->prepare. Cacho, chequeate los params del statement", "error");
//    return false;
//}