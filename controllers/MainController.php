<?php

use Views\View;

class MainController
{

    function actionMain() {
        $this->showMainPage('article_main.php');
        return true;
    }

    function actionCompany() {
        $this->showMainPage('article_company.php');
        return true;
    }

    private function showMainPage($content) {
        $view = new View();
        $view->content = "<article>THIS IS CONTENT!</article>";

        require_once ROOT . '/views/layouts/main.php';
    }
}