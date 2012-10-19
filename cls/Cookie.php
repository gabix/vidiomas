<?php

class Cookie {

    private static $instance = null;

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new Cookie;
        }
        return self::$instance;
    }

    public static function get($key) {
        if (null <> (self::instance()->getValue($key))) {
            return self::instance()->getValue($key);
        } else {
            return false;
        }
    }

    public function getValue($key) {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
        return false;
    }

    public static function set($key, $value, $expirTime = 20) {
        $expirTime = time() + (60 * 60 * 24 * $expirTime); //¿¿ves?? DÍAS

        return self::instance()->setValue($key, $value, $expirTime);
    }

    public function setValue($key, $value, $expirTime) {
        return setcookie($key, $value, $expirTime);
    }

    public static function kill($key) {
        return self::instance()->killValue($key);
    }

    public function killValue($key) {
        if (isset($_COOKIE[$key])) {
            return setcookie($key, null, -1);
        } else {
            return false;
        }
    }

    public function __clone() {
        die("NO CLONES NO CRY");
    }

}
