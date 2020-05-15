<?php

use Views\AdminBookEditView;
use Views\AdminBooksView;

class AdminBookController extends ViewController {

    private function checkAuthorization() {
        session_start();
        if (!User::isAuthorized()) {
            header("Location: /admin");
            exit();
        }
    }

    private function showError($book, $error) {
        $this->showView(new AdminBookEditView($book, $error));
        exit();
    }

    private function getBookInstance(
        ?string $name = null, ?string $category = null, ?string $author = null,
        ?string $price = null, ?string $description = null, ?string $image = null
    ) {
        $book = new stdClass();
        $book->name = $name != null ? $name : '';
        $book->category = $category != null ? $category : '';
        $book->author = $author != null ? $author : '';
        $book->price = $price != null ? $price : '';
        $book->description = $description != null ? $description : '';
        $book->image = $image != null ? $image : '';

        return $book;
    }

    private function getCategoryIdByName(string $name) {
        $result = Db::query("select * from category where name = '$name' limit 1");
        if (count($result) != 0) return $result[0]->id;
        else return false;
    }

    private function addBook(int $categoryId, $book) {
        Db::query("INSERT INTO book(category, name, author, price, image, description) VALUES ("
            ."$categoryId, '$book->name', '$book->author', $book->price, '$book->image', '$book->description');"
        );
    }

    private function addCategory(string $name) {
        Db::query("insert into category(name, \"order\") values ('$name', 0)");
    }

    function actionDelete($bookId) {

    }

    function actionAdd() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book = $this->getBookInstance(
                $_POST['name'], $_POST['category'], $_POST['author'],
                $_POST['price'], $_POST['description'],
                !empty($_POST['image']) ? $_POST['image'] : null
            );

            if (empty($book->name)) $this->showError($book,"Имя не может быть пустым!");
            if (empty($book->category)) $this->showError($book,"Категория не может быть пустой");
            if (empty($book->author)) $this->showError($book,"Автор не может быть пустым");
            if (empty($book->price)) $this->showError($book,"Цена не может быть пустой");

            if ($categoryId = $this->getCategoryIdByName($book->name)) {
                $this->addBook($categoryId, $book);
            } else {
                $this->addCategory($book->category);
                $categoryId = $this->getCategoryIdByName($book->category);
                $this->addBook($categoryId, $book);
                header("Location:/edit/books");
                return true;
            }
        }

        $this->showView(new AdminBookEditView($this->getBookInstance()));
        return true;
    }

    function actionMain() {
        $this->checkAuthorization();

        $result = Db::query("select b.*, c.name as category_name from book b join category c on b.category = c.id");

        $this->showView(new AdminBooksView($result));
        return true;
    }
}