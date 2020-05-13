<?php

class Db {

    public static function getConnection() {
        // Получаем параметры подключения из файла
        $paramsPath = ROOT . '/config/config.php';
        include_once ($paramsPath);
        $params = Config\DB();

        $host = "host=" . $params['host'];
        $dbname = "dbname=" . $params['dbname'];
        $username = "username=" . $params['username'];
        $password = "password=" . $params['password'];

        $connectionStr = $host ." ". $dbname; /*." ". $username ." ". $password;*/

        $db = pg_connect($connectionStr)
        or die('Не удалось соединиться: ' . pg_last_error());

        return $db;
    }

    public static function querySelect(string $selectQuery) {
        $conn = Db::getConnection();

        $query = pg_query($selectQuery) or die('Ошибка запроса: ' . pg_last_error());

        $result = array();
        while ($data = pg_fetch_object($query)) {
            array_push($result, $data);
        }

        pg_free_result($query);
        pg_close($conn);
        return $result;
    }
}
