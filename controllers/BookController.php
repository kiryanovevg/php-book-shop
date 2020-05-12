<?php

use Views\BookView;

class BookController extends ViewController {

    private function getCategories() {
        $conn = Db::getConnection();

        $query = "select * from category";
        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

        $models = array();
        while ($row = pg_fetch_row($result)) {
            array_push($models, [
                'id' => $row[0],
                'name' => $row[1]
            ]);
        }

        pg_close($conn);
        return $models;
    }

    function actionCategory($category) {
        $categories = $this->getCategories();

        $this->showView(new BookView($categories));
        return true;
    }

    function actionMain() {
        $categories = $this->getCategories();
        $category = $categories[0];
        $id = $category['id'];

        header("Location: /books/$id");
        return true;
    }
}