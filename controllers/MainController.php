<?php


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
        require_once ROOT . '/views/main.php';
    }
}