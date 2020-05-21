<?php

use Views\AdminBookEditView;
use Views\AdminBooksView;
use function Views\UploadedImagesDir;

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
        int $id,
        ?string $name = null, ?string $category = null, ?string $author = null,
        ?string $price = null, ?string $description = null, ?string $image = null
    ) {
        $book = new stdClass();
        $book->id = $id;
        $book->name = $name;
        $book->category = $category;
        $book->author = $author;
        $book->price = $price;
        $book->description = $description;
        $book->image = $image;

        return $book;
    }

    private function getCategoryIdByName(string $name) {
        $result = Db::query("select * from category where name = '$name' limit 1");
        if (count($result) != 0) return $result[0]->id;
        else return false;
    }

    private function addBook(int $categoryId, $book) {
        $query = "INSERT INTO book (category, name, author, price, image, description) VALUES ("
            ."$categoryId, '$book->name', '$book->author', $book->price"
            .($book->image != null ? ", '$book->image'" : ", NULL")
            .($book->description != null ? ", '$book->description'" : ", NULL")
            .")";

        Db::query($query);
    }

    private function updateBook(int $categoryId, $book) {
        $query = "UPDATE book SET "
            ."category=$categoryId, name='$book->name', author='$book->author', "
            ."price=$book->price, description=".($book->description != null ? "'$book->description'" : "NULL")
            .($book->image != null ? ", image='$book->image' " : ' ')
            ."WHERE id = $book->id";

        Db::query($query);
    }

    private function getBook(int $bookId) {
        $query = "select b.*, b.price::money::numeric as price_num, c.name as category_name "
            ."from book b join category c on b.category = c.id where b.id = $bookId";
        $result = Db::query($query);

        if (count($result) != 0) {
            $item = $result[0];
            return $this->getBookInstance(
                $item->id,
                $item->name, $item->category_name, $item->author,
                $item->price_num, $item->description, $item->image
            );
        } else return false;
    }

    private function addCategory(string $name) {
        Db::query("insert into category(name, \"order\") values ('$name', 0)");
    }

    private function deleteImage($bookId) {
        $result = Db::query("select * from book where id = $bookId limit 1");
        if (count($result) != 0) {
            $book = $result[0];
            if ($book->image != null) {
                $destination = UploadedImagesDir() . $book->image;
                if (is_file($destination)) {
                    return unlink(UploadedImagesDir() . $book->image);
                }
            }
        }

        return true;
    }

    function actionDeleteImage($bookId) {
        $this->checkAuthorization();

        if ($this->deleteImage($bookId)) {
            Db::query("update book set image = null where id = $bookId");
        }

        header("Location: /edit/book/$bookId");
        return true;
    }

    function actionDelete($bookId) {
        $this->checkAuthorization();

        if ($this->deleteImage($bookId)) {
            Db::query("delete from book where id = $bookId");
        }
        header("Location: /edit/books");
        return true;
    }

    function actionEdit($bookId) {
        $this->checkAuthorization();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $book = $this->getBookInstance(
                $bookId,
                $_POST['name'], $_POST['category'], $_POST['author'], $_POST['price'],
                !empty($_POST['description']) ? $_POST['description'] : null,
                is_uploaded_file($_FILES['image']['tmp_name'])
                    ? uniqid() . '-' . $_FILES['image']['name']
                    : null
            );

            if (empty($book->name)) $this->showError($book,"Имя не может быть пустым!");
            if (empty($book->category)) $this->showError($book,"Категория не может быть пустой");
            if (empty($book->author)) $this->showError($book,"Автор не может быть пустым");
            if (empty($book->price)) $this->showError($book,"Цена не может быть пустой");
            if ($_FILES['image']['error'] == UPLOAD_ERR_INI_SIZE) $this->showError(
                $book,"Ошибка при загрузке изображения. Код: " . $_FILES['image']['error']
            );

            $categoryId = null;
            if (!($categoryId = $this->getCategoryIdByName($book->category))) {
                $this->addCategory($book->category);
                $categoryId = $this->getCategoryIdByName($book->category);
            }

            if ($book->id != -1) {//Обновление книги
                if ($book->image != null) {//Пользователь обновляет изображение
                    if ($this->deleteImage($book->id)) {//Если удалилось старое изображение
                        $destination = UploadedImagesDir() . $book->image;
                        move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                        $this->updateBook($categoryId, $book);
                    } else {//Ошибка удаления изображения
                        $this->showError($book, "Ошибка обновления изображения");
                    }
                } else {
                    $this->updateBook($categoryId, $book);
                }
            } else {//Добавление новой книги
                $destination = UploadedImagesDir() . $book->image;
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                $this->addBook($categoryId, $book);
            }

            header("Location: /edit/books");
        }

        $book = null;
        if ($bookId != -1) {
            if ($item = $this->getBook($bookId)) $book = $this->getBook($bookId);
            else header("Location: /edit/books");
        } else $book = $this->getBookInstance($bookId);

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