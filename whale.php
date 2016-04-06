<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Whale
{
    public static function validUri()
    {
        if (!self::isCli()) {
            $uri = $_SERVER['REQUEST_URI'];
            if ($uri == '/' || $uri == '') {
                return false;
            }
        }
        return true;
    }

    public static function redirect()
    {
        header('Location: /whale');
        exit();
    }

    public static function isCli()
    {
        return substr(php_sapi_name(), 0, 3) === 'cli';
    }
}
