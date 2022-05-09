<?php

namespace core;

/**
 * Базовый класс контроллера, от него наследуются все клиентские контроллеры
 */
abstract class Controller
{
    /**
     * Массив с данными для передачи в вид
     * @var array
     */
    public array $data = [];

    /**
     * Массив с метаданными страницы
     * @var array
     */
    public array $meta = [];

    /**
     * Название шаблона страницы
     * @var false|string
     */
    public false|string $layout = '';

    /**
     * Название вида
     * @var string
     */
    public string $view = '';

    /**
     * Объект модели для данного контроллера
     * @var object
     */
    public object $model;

    /**
     * @param array $route
     */
    public function __construct(public $route = [])
    {

    }

    /**
     * Метод для получения модели
     */
    public function getModel()
    {
        $model = 'app\models\\' . $this->route['admin_prefix'] . $this->route['controller'];
        if (class_exists($model)) {
            $this->model = new $model();
        }
    }

    /**
     * Метод для получения вида
     */
    public function getView()
    {
        $this->view = $this->view ?: $this->route['action'];
        (new View($this->route, $this->layout, $this->view, $this->meta))->render($this->data);
    }

    /**
     * Сеттер для данных, передаваемых в вид
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Сеттер для метаданных страницы
     * @param string $title
     * @param string $description
     * @param string $keywords
     */
    public function setMeta($title = '', $description = '', $keywords = '')
    {
        $this->meta = [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords
        ];
    }
}