<?php

namespace core;

/**
 * Класс контейнер приложения
 */
class App
{
    /**
     * статический контейнер для хранения экземляра регистра
     * @var Registry|TSingleton
     */
    public static $app;

    public function __construct()
    {
        $url = trim(urldecode($_SERVER['QUERY_STRING']), '/');
        new ErrorHandler();
        self::$app = Registry::getInstance();
        $this->getParams();
        Router::dispatch($url);
    }

    /**
     * Метод для заполнения массива с параметрами приложения
     */
    public function getParams()
    {
        $params = require_once CONFIG . '/params.php';
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                self::$app->setProperty($key, $value);
            }
        }
    }

}