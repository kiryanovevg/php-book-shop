<?php


class MainController
{

    function actionMain() {
        echo 'MAIN';
    }

    function actionTest($word, $num) {
        echo $word;
        echo $num;
        return true;
    }
}