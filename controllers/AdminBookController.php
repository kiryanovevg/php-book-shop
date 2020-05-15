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

    private function updateBook(int $bookId, int $categoryId, $book) {
        Db::query("UPDATE book SET "
            ."category=$categoryId, name='$book->name', author='$book->author', "
            ."price=$book->price, image='$book->image', description='$book->description' WHERE id = $bookId;");
    }

    private function getBook(int $bookId) {
        $query = "select b.*, b.price::money::numeric as price_num, c.name as category_name "
            ."from book b join category c on b.category = c.id where b.id = $bookId";
        $result = Db::query($query);

        if (count($result) != 0) {
            $item = $result[0];
            return $this->getBookInstance(
                $item->name, $item->category_name, $item->author,
                $item->price_num, $item->description, $item->image
            );
        } else return false;
    }

    private function addCategory(string $name) {
        Db::query("insert into category(name, \"order\") values ('$name', 0)");
    }

    function actionDelete($bookId) {
        Db::query("delete from book where id = $bookId");
        header("Location: /edit/books");
        return true;
    }

    function actionAdd($bookId) {
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

            $categoryId = null;
            if (!($categoryId = $this->getCategoryIdByName($book->category))){
                $this->addCategory($book->category);
                $categoryId = $this->getCategoryIdByName($book->category);
            }

            if ($bookId != -1) {
                $this->updateBook($bookId, $categoryId, $book);
            } else {
                $this->addBook($categoryId, $book);
            }

            header("Location: /edit/books");
        }

        $book = null;
        if ($bookId != -1) {
            if ($item = $this->getBook($bookId)) $book = $this->getBook($bookId);
            else header("Location: /edit/books");
        } else $book = $this->getBookInstance();

        $this->showView(new AdminBookEditView($book));
        return true;
    }

    function actionMain() {
        $this->checkAuthorization();

        $result = Db::query("select b.*, c.name as category_name from book b join category c on b.category = c.id");

        $this->showView(new AdminBooksView($result));
        return true;
    }
}