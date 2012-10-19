<?php

class Session {

    private static $instance = null;

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new Session;
        }
        return self::$instance;
    }

    private function __construct() {
        $this->startSession();
    }

    private function startSession() {
        if (session_id() == '') {
            session_start();
        }
    }

    private function _kill() {
        if (session_id() <> '') {
            session_unset();
            session_destroy();
        }
    }
    
    public static function start() {
        return null;
    }


    public static function get($key) {
        if (null <> (self::instance()->getValue($key))) {
            return self::instance()->getValue($key);
        } else {
            return false;
        }
    }

    public static function set($key, $value) {
        return self::instance()->setValue($key, $value);
    }

    public static function kill() {
        return self::instance()->_kill();
    }

    public function getValue($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return false;
    }

    public function setValue($key, $value) {
        return $_SESSION[$key] = $value;
    }

    public function __clone() {
        die("NO CLONES NO CRY");
    }

}