<?php
return array(
    'restore/([a-z]+)' => 'page/restore/$1',
    'edit/books/add' => 'adminBook/add',
    'edit/books/delete/([0-9]+)' => 'adminBook/delete/$1',
    'edit/books' => 'adminBook/main',
    'edit/([a-z]+)' => 'page/edit/$1',
    'admin/signIn' => 'admin/signIn',
    'admin/signUp' => 'admin/signUp',
    'admin/logOut' => 'admin/logOut',
    'books/([0-9]+)' => 'bookList/category/$1',
    'book/([0-9]+)' => 'book/main/$1',
    'books' => 'bookList/main',
    'admin' => 'admin/main',
    '([a-z]+)' => 'main/main/$1',
    '' => 'main/main/main'
);