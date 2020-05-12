<?php


use Views\View;

abstract class ViewController {

    protected function showView(View $view) {
        require_once ROOT . '/views/layouts/main.php';
    }
}