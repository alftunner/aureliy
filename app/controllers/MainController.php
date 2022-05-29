<?php

namespace app\controllers;

use core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $this->setMeta('Главная страница', 'Описание главной страницы', 'Главная страница, мой фреймворк');
        $this->setData(['test' => 'Тестовые данные']);
    }
}