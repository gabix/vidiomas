<?php

class Debuguie {

    private $debuguieMsgs = array();
    private $debugTable = null;
    private $logFilePath = null;
    private $logFile = null;
    private $debugSessionName = null;
    private static $instance = null;

    public function __construct() {
        $this->debugSessionName = "Debug log | " . date("Y-m-d H:i:s", time());
        $this->debugTable = $debugTable = $this->_genDebugTable();

        if (GENERARLOG) {
            $this->logFilePath = $logFilePath = APP_ROOT.DS.LOGS_LOCATION.DS."debugLog.".date("Ymd-H", time()).".html";
            $this->logFile = $logFile = new SuperFile($logFilePath);

            if (ONTHEFLY) $logFile->PushToDebugLogFile($debugTable, false);
        }
    }

    private function _genDebugTable() {
        $ret = '<div id="'.$this->debugSessionName.'" class="well well-small">'."\n";
        $ret .= ' <div class="d_debuguie">'."\n";
        $ret .= '  <caption>'.$this->debugSessionName.'</caption>'."\n";
        $ret .= '  <table class="table table-condensed">'."\n";
        $ret .= '   <thead>'."\n";
        $ret .= '    <tr>'."\n";
        $ret .= '     <th>Tipo</th><th>Donde</th><th>Mensaje</th>'."\n";
        $ret .= '    </tr>'."\n";
        $ret .= '   </thead>'."\n";
        $ret .= '   <tbody>'."\n";
        $ret .= '<!--DEBUG_MSG_INPUT-->'."\n";
        $ret .= '   </tbody>'."\n";
        $ret .= '  </table>'."\n";
        $ret .= ' </div>'."\n";
        $ret .= '</div>'."\n";
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
     * @param string $tipoDeError "success|error|warning|info"
     * @return array
     */
    public static function AddMsg($donde, $msg, $tipoDeError) {
        self::instance()->_addMsg($donde, $msg, $tipoDeError);
        if (ONTHEFLY) self::instance()->_printMsgsOnTheFly();
    }

    private function _addMsg($donde, $msg, $tipoDeError) {
        //TODO: is_otra cosa --> bla
        if (($msg == "") || ($msg == null)) $msg = 'vacio';
        //if (is_numeric($msg)) $msg = "(numeric)=".(string) $msg;
        //if (is_bool($msg)) $msg = "(bool)=".(string) $msg;
        if (is_array($msg)) $msg = "(array)=".json_encode($msg);
        if (is_numeric($msg)) $msg = "(obj)=".var_export ($msg, true);

        $msg = htmlentities($msg, ENT_QUOTES, "UTF-8");
        return $this->debuguieMsgs[] = array('donde' => $donde, 'msg' => $msg, 'tipoDeError' => $tipoDeError);
    }

    public static function PrintMsgs() {
        return self::instance()->_printMsgs();
    }

    private function _printMsgsOnTheFly() {
        $debMsg = end($this->debuguieMsgs);

        if ($debMsg['tipoDeError'] == "error" || ($debMsg['tipoDeError'] == "warning")) {
            trigger_error("<b>".$debMsg['tipoDeError']."</b>: en ".$debMsg['donde']." | ".$debMsg['msg']);
        }

        if (GENERARLOG) {
            $dMsg = '    <tr class="' . $debMsg['tipoDeError'] . '">' . "\n";
            $dMsg .= "     <td>" . $debMsg['tipoDeError'] . "</td><td>" . $debMsg['donde'] . "</td><td>" . $debMsg['msg'] . "</td>\n";
            $dMsg .= "    </tr>\n";

            $this->logFile->PushToDebugLogFile($dMsg, true);
        }
    }

    private function _printMsgs() {
        $ret = null;
        if (count($this->debuguieMsgs) > 0) {
            $dMsgs = "";
            foreach ($this->debuguieMsgs as $debMsg) {
                $dMsgs .= '    <tr class="' . $debMsg['tipoDeError'] . '">' . "\n";
                $dMsgs .= "     <td>" . $debMsg['tipoDeError'] . "</td><td>" . $debMsg['donde'] . "</td><td>" . $debMsg['msg'] . "</td>\n";
                $dMsgs .= "    </tr>\n";
            }
            $ret = str_replace("<!--DEBUG_MSG_INPUT-->", $dMsgs, $this->debugTable);

            if (GENERARLOG && !ONTHEFLY) $this->logFile->PushToDebugLogFile($ret, false);
        }
        return $ret;
    }

    //obsoleto?
    //     /**
    //     * Imprime divs con el coso donde sea que se está el """puntero""" actual de escritura de la pag.
    //     * Usar el otro con <script es más mejor.
    //     * @return string (divo div)
    //     */
    //    private function _printDebuguieMsgsOnTheFly() {
    //        $debMsg = end($this->debuguieMsgs);
    //        $ret = '<div class="alert alert-' . $debMsg['color'] . '">' . "\n";
    //        $ret .= "\t" . '<a href="#" class="close" data-dismiss="alert">×</a>' . "\n";
    //        $ret .= "\t<strong>" . $debMsg['color'] . "</strong> <em>en</em> " . $debMsg['donde'] . " | " . $debMsg['msg'] . "\n";
    //        $ret .= "</div>\n";
    //        return $ret;
    //    }
}