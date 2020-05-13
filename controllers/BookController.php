<?php

use Views\BookView;

class BookController extends ViewController {

    private function getCategories() {
        return Db::querySelect("select * from category order by \"order\"");
    }

    function actionCategory($category) {
        $categories = $this->getCategories();

        $this->showView(new BookView($categories, $category));
        return true;
    }

    function actionMain() {
        $categories = $this->getCategories();
        $category = $categories[0];
        $id = $category->id;

        header("Location: /books/$id");
        return true;
    }
}