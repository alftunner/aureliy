<?php

namespace core;

class Router
{
    protected static array $routes = [];
    protected static array $route = [];

    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes() : array
    {
        return self::$routes;
    }

    public static function getRoute() : array
    {
        return self::$route;
    }

    public static function dispatch($url)
    {
        if (self::matchRoutes($url)) {
            echo 'OK';
        } else {
            echo 'Not OK';
        }
        debug(self::getRoutes());
    }

    public static function matchRoutes($url) : bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['admin_prefix'])) {
                    $route['admin_prefix'] = '';
                } else {
                    $route['admin_prefix'] = '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                return true;
            }
        }
        return false;
    }

    protected static function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }
}