<?php

use Views\BookView;

class BookController extends ViewController {

    function actionMain() {
        $this->showView(new BookView());
        return true;
    }
}