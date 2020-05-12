<?php

use Views\CompanyView;
use Views\DeveloperView;
use Views\MainView;

class MainController
{

    function actionMain() {
        $this->showMainPage(new MainView());
        return true;
    }

    function actionCompany() {
        $this->showMainPage(new CompanyView());
        return true;
    }

    function actionDeveloper() {
        $this->showMainPage(new DeveloperView());
        return true;
    }

    private function showMainPage($view) {
        require_once ROOT . '/views/layouts/main.php';
    }
}