<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/AutoLoad.php');
require_once(ROOT . '/components/Views.php');

// Вызов Router
$router = new Router();
$router->run();