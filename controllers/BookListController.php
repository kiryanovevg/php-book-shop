<?php

use Views\BookListView;

class BookListController extends ViewController {

    private function getCategories(bool $first = false) {
        $query = "select * from category order by \"order\"";
        if ($first) $query .= " limit 1";

        return Db::query($query);
    }

    private function getBooks(int $category) {
        $query = "select * from book where category = $category";

        return Db::query($query);
    }

    function actionCategory($category) {
        $categories = $this->getCategories();
        $books = $this->getBooks($category);

        $this->showView(new BookListView($categories, $category, $books));
        return true;
    }

    function actionMain() {
        $categories = $this->getCategories(true);
        if (count($categories) != 0) {
            $category = $categories[0];
            $id = $category->id;

            header("Location: /books/$id");
        } else die("Categories doesn't exists!");
    }
}