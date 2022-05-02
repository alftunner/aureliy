<?php

namespace core;

/**
 * Класс маршрутизации
 */
class Router
{
    /**
     * Массив всех маршрутов, заполняется в config/routes.php
     * @var array
     */
    protected static array $routes = [];

    /**
     * Текущий маршрут
     * @var array
     */
    protected static array $route = [];

    /**
     * Метод добавления нового маршрута в таблицу маршрутов
     * @param $regexp
     * @param array $route
     */
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * Аксессор получения всех маршрутов
     * @return array
     */
    public static function getRoutes() : array
    {
        return self::$routes;
    }

    /**
     * Аксессор получения текущего маршрута
     * @return array
     */
    public static function getRoute() : array
    {
        return self::$route;
    }

    /**
     * Метод для отсечения GET-параметров от url, для избежания ошибок
     * @param $url
     * @return string|null
     */
    protected static function removeQueryString($url)
    {
        if ($url) {
            $params = explode('&', $url, 2);
            if (false === str_contains($params[0], '=')) {
                return rtrim($params[0], '/');
            }
            return '';
        }
        return $url;
    }

    /**
     * Метод для определения и вызова контроллера и метода для текущего маршрута
     * @param $url
     * @throws \Exception
     */
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        if (self::matchRoutes($url)) {
            $controller = 'app\controllers\\' . self::$route['admin_prefix'] . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = self::$route['action'] . 'Action';
                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Метод {$controller}::{$action} не найден", 404);
                }
            } else {
                throw new \Exception("Контроллер {$controller} не найден", 404);
            }
        } else {
            throw new \Exception("Страница не найдена", 404);
        }
    }

    /**
     * Метод проверяет совпадение текущего адреса с таблицей маршрутов, в случае совпадения пишет в self::route
     * @param $url
     * @return bool
     */
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
                    $route['admin_prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Метод для приведения строки в CamelCase (для контроллера)
     * @param $name
     * @return array|string|string[]
     */
    protected static function upperCamelCase($name)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * Метод для приведения строки в camelCase (для action)
     * @param $name
     * @return string
     */
    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }
}