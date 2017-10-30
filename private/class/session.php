<?php
final class Session
{
    public static function set()
    {
        try {
            session_start();
        } catch (Exception $ex) {
            Maintenance::handleExceptions($ex);
        }

        // $browsercap = get_browser($_SERVER['HTTP_USER_AGENT'], true);

        $_SESSION['BROWSER'] = null; //$browsercap['browser'];
        $_SESSION['PLATFORM'] = null; //$browsercap['platform'];
        $_SESSION['DEVICE_TYPE'] = null; //$browsercap['device_type'];
        $_SESSION['ROLE'] = self::getClientRole();
        $_SESSION['IP_ADDRESS'] = self::getClientIP();
        $_SESSION['COUNTRY'] = self::getClientCountry();
        $_SESSION['LANGUAGE'] = self::getClientLanguage($_SESSION['COUNTRY']);
        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['AUTHORIZATION'] = null;
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    private static function getClientRole()
    {
        return ADMIN;
    }

    private static function getClientCountry()
    {
        return strtolower('IR' /*json_decode(file_get_contents("http://ipinfo.io/{$_SESSION['IP_ADDRESS']}/json")) -> country*/);
    }

    private static function getClientLanguage($_country)
    {
        switch ($_country) {
            case 'us':
            case 'uk':
            case 'ca':
                return EN_LANG;
            case 'ir':
                return FA_LANG;
            default:
                return EN_LANG;
        }
    }

    private static function getClientIP()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            return getenv('HTTP_CLIENT_IP');
        }
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            return getenv('HTTP_X_FORWARDED_FOR');
        }
        if (getenv('HTTP_X_FORWARDED')) {
            return getenv('HTTP_X_FORWARDED');
        }
        if (getenv('HTTP_FORWARDED_FOR')) {
            return getenv('HTTP_FORWARDED_FOR');
        }
        if (getenv('HTTP_FORWARDED')) {
            return getenv('HTTP_FORWARDED');
        }
        if (getenv('REMOTE_ADDR')) {
            return getenv('REMOTE_ADDR');
        }

        return '-';
    }
}
