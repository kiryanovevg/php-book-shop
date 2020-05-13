<?php


use Views\BookView;

class BookController extends ViewController {

    private function getBook(int $bookId) {
        $query = "select * from book where id = $bookId";
        $result = Db::querySelect($query);

        if (count($result) != 0) {
            return $result[0];
        } else die("Book doesn't exist");
    }

    function actionMain($bookId) {
        $book = $this->getBook($bookId);

        $this->showView(new BookView($book));
        return true;
    }
}