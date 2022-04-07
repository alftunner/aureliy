<?php

namespace core;

/**
 * класс Реестр
 */
class Registry
{
    use TSingleton;

    /**
     * Массив для хранения настроек приложения
     * @var array
     */
    private static array $properties = [];

    /**
     * Сеттер для настроек
     * @param $name
     * @param $value
     */
    public function setProperty($name, $value)
    {
        self::$properties[$name] = $value;
    }

    /**
     * Геттер для настроек, получаем по имени
     * @param $name
     * @return mixed
     */
    public function getProperty($name)
    {
        return self::$properties[$name];
    }

    /**
     * Геттер для получения всего массива настроек
     * @return array
     */
    public function getProperties()
    {
        return self::$properties;
    }
}