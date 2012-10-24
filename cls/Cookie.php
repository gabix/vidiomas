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
        Debuguie::AddMsg("Cookie - getValue()", "parámetros = $key", "fInit");

        if (isset($_COOKIE[$key])) {
            Debuguie::AddMsg("Cookie - getValue()", "val para key=$key = $_COOKIE[$key]", "success");
            return $_COOKIE[$key];
        }

        Debuguie::AddMsg("Cookie - getValue()", "key=$key no seteada", "info");
        return false;
    }

    public static function set($key, $value, $expirTime = 20, $path = '/', $domain='', $secure=false, $httponly=false) {
        $expirTime = time() + (60 * 60 * 24 * $expirTime); //¿¿ves?? DÍAS
        return self::instance()->setValue($key, $value, $expirTime, $path, $domain, $secure, $httponly);
    }

    public function setValue($key, $value, $expirTime, $path, $domain, $secure, $httponly) {

        Debuguie::AddMsg("Cookie - setValue()", "parámetros = $key, $value", "fInit");

        $setCookie = setcookie($key, $value, $expirTime, $path, $domain, $secure, $httponly);

        Debuguie::AddMsg("Cookie - setValue()", "ret de set = $setCookie", "info");
        return $setCookie;
    }

    public static function kill($key) {
        return self::instance()->killCookie($key);
    }

    public function killCookie($key) {
        Debuguie::AddMsg("Cookie - killCookie()", "parámetros = $key", "fInit");

        if (isset($_COOKIE[$key])) {
            $killCookie = setcookie($key, null, -1);
            Debuguie::AddMsg("Cookie - killCookie()", "ret=($killCookie) --supuestamente $key murió", "success");
            return $killCookie;

        } else {
if (is_array($key)) {
    if (isset($_COOKIE[$key[0]][$key[1]])) {

        $killCookie = setcookie($key, null, -1);
        Debuguie::AddMsg("Cookie - killCookie()", "ret=($killCookie) --supuestamente $key murió", "success");
        return $killCookie;

    }
}

            Debuguie::AddMsg("Cookie - killCookie()", "$key no seteada", "info");
            return false;
        }
    }

    public function __clone() {
        die("NO CLONES NO CRY");
    }

}
