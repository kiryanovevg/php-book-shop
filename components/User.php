<?php


class User {

    static function isAuthorized(): bool {
        return isset($_SESSION['userId']);
    }
}