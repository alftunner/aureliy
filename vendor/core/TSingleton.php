<?php

namespace core;

trait TSingleton
{
    private static ?self $instance;

    private function __construct() {}

    public static function getInstance()
    {
        return self::$instance ?? new static();
    }
}