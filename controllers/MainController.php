<?php

use Views\CompanyView;
use Views\DeveloperView;
use Views\MainView;

class MainController extends ViewController {

    function actionMain() {
        $this->showView(new MainView());
        return true;
    }

    function actionCompany() {
        $this->showView(new CompanyView());
        return true;
    }

    function actionDeveloper() {
        $this->showView(new DeveloperView());
        return true;
    }
}