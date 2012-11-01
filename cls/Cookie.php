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
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "parámetros = $key", "fInit");

        if (isset($_COOKIE[$key])) {
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "val para key=$key = $_COOKIE[$key]", "success");
            return $_COOKIE[$key];
        }

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "key=$key no seteada", "info");
        return false;
    }

    public static function set($key, $value, $expirTime = 20, $path = '/', $domain='', $secure=false, $httponly=false) {
        $expirTime = time() + (60 * 60 * 24 * $expirTime); //¿¿ves?? DÍAS
        return self::instance()->setValue($key, $value, $expirTime, $path, $domain, $secure, $httponly);
    }

    public function setValue($key, $value, $expirTime, $path, $domain, $secure, $httponly) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "parámetros = $key, $value", "fInit");

        $setCookie = setcookie($key, $value, $expirTime, $path, $domain, $secure, $httponly);

        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "ret de set = $setCookie", "info");
        return $setCookie;
    }

    public static function kill($key, $path = '/', $domain='', $secure=false, $httponly=false) {
        return self::instance()->killCookie($key, $path, $domain, $secure, $httponly);
    }

    public function killCookie($key, $path, $domain, $secure, $httponly) {
        Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "parámetros = $key", "fInit");

        if (isset($_COOKIE[$key])) {
            $killCookie = setcookie($key, null, -1, $path, $domain, $secure, $httponly);
            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "ret=($killCookie) --supuestamente $key murió", "success");
            return $killCookie;

        } else {


            Debuguie::AddMsg(__CLASS__." - ".__FUNCTION__, "$key no seteada", "info");
            return false;
        }
    }

    public function __clone() {
        die("NO CLONES NO CRY");
    }

}
