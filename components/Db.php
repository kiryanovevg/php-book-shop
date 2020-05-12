<?php

class Db {

    public static function getConnection() {
        // Получаем параметры подключения из файла
        $paramsPath = ROOT . '/config/config.php';
        include($paramsPath);
        $params = Config\DB();

        $host = "host=" . $params['host'];
        $dbname = "dbname=" . $params['dbname'];
        $username = "username=" . $params['username'];
        $password = "password=" . $params['password'];

        $connectionStr = $host ." ". $dbname; /*." ". $username ." ". $password;*/

        $db = pg_connect($connectionStr)
        or die('Не удалось соединиться: ' . pg_last_error());

        // Устанавливаем соединение
//        $dsn = "postgresql:host={$params['host']};dbname={$params['dbname']}";
//        $db = new PDO($dsn, $params['user'], $params['password']);

        // Задаем кодировку
//        $db->exec("set names utf8");

        return $db;
    }

}
