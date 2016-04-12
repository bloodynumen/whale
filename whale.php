<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Whale
{
    private static $app = '';
    private static $appsDir = 'apps';

    public static function validUri()
    {
        if (self::isCli() == false) {
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
        if (self::isCli() == false) {
            $uri = trim($_SERVER['REQUEST_URI'], '/');
            $queryData = explode('/', $uri);
            self::$app = current($queryData);
        } else {
            $argv = $_SERVER['argv'];
            self::$app = $argv[1];
        }
    }

    public static function getApp()
    {
        return self::$app;
    }

    public static function getAppDir()
    {
        return self::$appsDir . DIRECTORY_SEPARATOR . self::$app;
    }

    public static function removeAppUri($uri = '')
    {
        if (!$uri) {
            return $uri;
        }

        return ltrim($uri, self::$app);
    }

    public static function removeAppArg($args = [])
    {
        if (!$args || count($args) == 1) {
            return $args;
        }

		return array_slice($args, 1);
    }

    public static function importController($args = [])
    {
        require_once FCPATH.'/apps/whale/core/WhaleController.php';
    }
}
