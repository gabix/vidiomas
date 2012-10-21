<?php
class SuperFile {

    private $filePath = null;

    public function setFilePath($filePath) {
        $this->filePath = $filePath;
    }

    public function getFilePath() {
        return $this->filePath;
    }

    public function __construct($filePath = "") {
        $this->filePath = $filePath;
    }

    /**
     * Get entry form file.
     * @param bool $strict (optinal, def=true, triggers error if file is not found)
     * @return object if file exists returns $entry in specified file.
     */
    public function get($strict = true) {
        if (!is_file($this->filePath)) {
            if ($strict) Debuguie::AddMsg("SuperFile - get()", "$this->filePath is not a file", "error");
            return null;
        } else {
            require_once($this->filePath);
            if (isset($entry)) {
                return $entry;
            } else {
                Debuguie::AddMsg("SuperFile - get()", "entry not found in file", "error");
                return null;
            }
        }
    }

    public function put(array $data) {
        $entry = '<?php $entry = ' . var_export($data, true) . ';';
        $ret = file_put_contents($this->filePath, $entry);

        if (!$ret) Debuguie::AddMsg("SuperFile - get()", "No la pudo poner, ". var_export($data, true) . "en $this->filePath", "error");
        return $ret;
    }

    private function CreateHtmlFileStructure($name, $includeBootstrapCss = true) {
        $str = '<!DOCTYPE html>' . "\n";
        $str .= '<html>' . "\n";
        $str .= '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>' . $name . '</title>';
        if ($includeBootstrapCss) $str .= '<link rel="stylesheet" type="text/css" href="../othersLib/bootstrap.css" />';
        $str .= '</head>' . "\n";
        $str .= '<body>' . "\n\n";
        $str .= '<!--TOP_CONTENT_INPUT-->' . "\n";
        $str .= '</body>' . "\n";
        $str .= '</html>' . "\n";

        return $str;
    }

    /**
     * @param $content
     * @param bool $onMSG_INPUT
     * @param bool $includeBootstrapCss
     * @return bool|int
     */
    public function PushToDebugLogFile($content, $onMSG_INPUT, $includeBootstrapCss = true) {
        $fPath = $this->filePath;

        if (is_file($fPath)) {
            $structure = file_get_contents($fPath);
        } else {
            $structure = $this->CreateHtmlFileStructure("DebugLog", $includeBootstrapCss);
        }

        if ($onMSG_INPUT) {
            $filtro = "<!--DEBUG_MSG_INPUT-->";
            $content = $content . $filtro;
        } else {
            $filtro = "<!--TOP_CONTENT_INPUT-->\n";
            $content = $filtro . $content . "\n";
        }

        $structure = SuperFuncs::str_replace_once($filtro, $content, $structure);

        return file_put_contents($fPath, $structure);
    }

}