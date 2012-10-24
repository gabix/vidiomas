<?php

class Debuguie {

    private $debuguieMsgs = array();
    private $debugTable = null;
    private $logFilePath = null;
    private $logFile = null;
    private $debugSessionName = null;
    private static $instance = null;

    private $doNotDebug = array("Lang", "");

    public function __construct() {
        $this->debugSessionName = "Debug log | " . date("Y-m-d H:i:s", time());
        $this->debugTable = $debugTable = $this->_genDebugTable();

        //echo "construyo debug(" . $this->debugSessionName . ")<br>\n";

        if (GENERARLOG) {
            //$this->logFilePath = $logFilePath = APP_ROOT . DS . LOGS_LOCATION . DS . "debugLog." . date("Ymd-H", time()) . ".html";
            //$this->logFile = $logFile = new SuperFile($logFilePath);
            //if (ONTHEFLY) $logFile->PushToDebugLogFile($debugTable, false);

            if (ONTHEFLY) DBfuncs::crearTablaLog();
        }
    }

    private function _genDebugTable() {
        $ret = '<div id="' . $this->debugSessionName . '" class="well well-small">' . "\n";
        $ret .= ' <div class="d_debuguie">' . "\n";
        $ret .= '  <caption>' . $this->debugSessionName . '</caption>' . "\n";
        $ret .= '  <table class="table table-condensed">' . "\n";
        $ret .= '   <thead>' . "\n";
        $ret .= '    <tr>' . "\n";
        $ret .= '     <th>id</th><th>debug sess</th><th>time</th><th>Tipo</th><th>Donde</th><th>Mensaje</th>' . "\n";
        $ret .= '    </tr>' . "\n";
        $ret .= '   </thead>' . "\n";
        $ret .= '   <tbody>' . "\n";
        $ret .= '<!--DEBUG_MSG_INPUT-->' . "\n";
        $ret .= '   </tbody>' . "\n";
        $ret .= '  </table>' . "\n";
        $ret .= ' </div>' . "\n";
        $ret .= '</div>' . "\n";
        return $ret;
    }

    public static function instance() {
        if (!DEBUGUEANDO) die("error nro 718263, muere bastardo MUERE!");
        if (null === self::$instance) {
            self::$instance = new Debuguie();
        }
        return self::$instance;
    }

    /**
     * @param string $donde
     * @param object|string $msg
     * @param string $tipoDeError "success|error|warning|info|fInit"
     * @return array
     */
    public static function AddMsg($donde, $msg, $tipoDeError) {
        self::instance()->_addMsg($donde, $msg, $tipoDeError);
        if (ONTHEFLY) self::instance()->_onTheFly();
    }

    private function _addMsg($donde, $msg, $tipoDeError) {
        //TODO: is_otra cosa --> bla
        if (($msg == "") || ($msg == null)) $msg = 'vacio';
        //if (is_numeric($msg)) $msg = "(numeric)=".(string) $msg;
        //if (is_bool($msg)) $msg = "(bool)=".(string) $msg;
        if (is_array($msg)) $msg = "(array)=" . json_encode($msg);
        //if (is_numeric($msg)) $msg = "(obj)=".var_export ($msg, true);

        $donde = htmlentities($donde, ENT_QUOTES, "UTF-8");
        $msg = htmlentities($msg, ENT_QUOTES, "UTF-8");

        return $this->debuguieMsgs[] = array('donde' => $donde, 'msg' => $msg, 'tipoDeError' => $tipoDeError, 'time' => microtime(true));
    }

    public static function PrintMsgs() {
        return self::instance()->_printMsgs();
    }

    /**
     * Muestra como trigger_error() los msj pasados a debuguie que son del tipo warning y error
     * Y
     * manda un insert a la db.
     */
    private function _onTheFly() {
        $debMsg = end($this->debuguieMsgs);

        $sessName = $this->debugSessionName;
        $time = $debMsg['time'];
        $donde = $debMsg['donde'];
        $msg = $debMsg['msg'];
        $tipo = $debMsg['tipoDeError'];

        if ($tipo == "error" || ($tipo == "warning")) {
            trigger_error("<b>" . $tipo . "</b>: en " . $donde . " | " . $msg);
        }

        if (GENERARLOG) {
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!mysqli_connect_errno()) {
                if ($q = $mysqli->prepare("INSERT INTO debuguie_log (titulo, time, claseYmetodo, msg, tipoDeError) VALUES (?, ?, ?, ?, ?)")) {

                    //echo "sqleo (JA!) debug(".$this->debugSessionName.")<br>\n";

                    $r = $q->bind_param('sssss', $sessName, $time, $donde, $msg, $tipo);

                    //echo "caca bind?($r)<br>\n";

                    $funciono = $q->execute();

                    $mysqli->close();
                    //echo "caca funciono?($funciono) con $sessName | $time | $donde | $msg | $tipo<br>\n";
                    return true;
                }
            }
            $mysqli->close();
            trigger_error("Desde Debuguie, no se puede conectar a la DB. Err: " . mysqli_connect_error());
            return null;
        }
    }

    private function _printMsgs() {
        self::AddMsg("Debuguie - _printMsgs", "<--*--END--*-->", "none"); //p'agregar una linea al final...

        $ret = null;
        if (count($this->debuguieMsgs) > 0) {

            $dMsgsFormateado = "";
            $id = 0;
            foreach ($this->debuguieMsgs as $debMsg) {
                $id += 1;

                //pa ignorar los addMsg de ciertas clases
                $clase = explode(" - ", $debMsg['donde']);
                if (!in_array($clase[0], $this->doNotDebug)) {

                    $dMsgsFormateado .= '    <tr class="' . $debMsg['tipoDeError'] . '">' . "\n";
                    $dMsgsFormateado .= '     <td>' . $id . '</td>' . "\n";
                    $dMsgsFormateado .= '     <td>' . $this->debugSessionName . '</td>' . "\n";
                    $dMsgsFormateado .= '     <td>' . date("Y-m-d H:i:s u", $debMsg['time']) . '</td>' . "\n";
                    $dMsgsFormateado .= '     <td class="bold">' . $debMsg['tipoDeError'] . '</td>' . "\n";
                    $dMsgsFormateado .= '     <td>' . $debMsg['donde'] . '</td>' . "\n";
                    $dMsgsFormateado .= '     <td>' . $debMsg['msg'] . '</td>' . "\n";
                    $dMsgsFormateado .= '    </tr>' . "\n";
                }
            }
            $ret = str_replace("<!--DEBUG_MSG_INPUT-->", $dMsgsFormateado, $this->debugTable);

            //if (GENERARLOG && !ONTHEFLY) $this->logFile->PushToDebugLogFile($ret, false);
        }

        return $ret;
    }

    private function _printMsgsFromDB() {

    }
}

//obsoleto?
//     /**
//     * Imprime divs con el coso donde sea que se está el """puntero""" actual de escritura de la pag.
//     * Usar el otro con <script es más mejor.
//     * @return string (divo div)
//     */
//    private function _onTheFly() {
//        $debMsg = end($this->debuguieMsgs);
//        $ret = '<div class="alert alert-' . $debMsg['color'] . '">' . "\n";
//        $ret .= "\t" . '<a href="#" class="close" data-dismiss="alert">×</a>' . "\n";
//        $ret .= "\t<strong>" . $debMsg['color'] . "</strong> <em>en</em> " . $debMsg['donde'] . " | " . $debMsg['msg'] . "\n";
//        $ret .= "</div>\n";
//        return $ret;
//    }
//
//    /**
//     * También imprime en el log cada vez que se agrega un msg (de cualquier tipo)
//     */
//    private function _onTheFly() {
//        $debMsg = end($this->debuguieMsgs);
//
//        if (GENERARLOG) {
//
//            $dMsg = '    <tr class="' . $debMsg['tipoDeError'] . '">' . "\n";
//            $dMsg .= "     <td>" . $debMsg['tipoDeError'] . "</td><td>" . $debMsg['donde'] . "</td><td>" . $debMsg['msg'] . "</td>\n";
//            $dMsg .= "    </tr>\n";
//
//            $this->logFile->PushToDebugLogFile($dMsg, true);
//
//        }
//    }