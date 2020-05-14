<?php
return array(
    'restore/([a-z]+)' => 'page/restore/$1',
    'admin/signIn' => 'admin/signIn',
    'admin/signUp' => 'admin/signUp',
    'admin/logOut' => 'admin/logOut',
    'admin/editMain' => 'page/editMain',
    'admin/editCompany' => 'page/editCompany',
    'admin/editDeveloper' => 'page/editDeveloper',
//    'edit/([a-z]+)' => 'admin/edit/$1',
    'book/([0-9]+)' => 'book/main/$1',
    'books/([0-9]+)' => 'bookList/category/$1',
    'books' => 'bookList/main',
    'developer' => 'main/developer',
    'company' => 'main/company',
    'admin' => 'admin/main',
    '' => 'main/main'
);