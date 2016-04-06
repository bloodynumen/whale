<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Whale
{
    private static $app = '';

    public static function validUri()
    {
        if (!self::isCli()) {
            $uri = $_SERVER['REQUEST_URI'];
            if ($uri == '/' || $uri == '') {
                return false;
            }
        }
        self::setApp();
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

    private static function setApp()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $queryData = explode('/', $uri);
        self::$app = current($queryData);
    }

    public static function getApp()
    {
        return self::$app;
    }
}
