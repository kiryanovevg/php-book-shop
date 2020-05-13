<?php
return array(
    'book/([0-9]+)' => 'book/main/$1',
    'books/([0-9]+)' => 'bookList/category/$1',
    'books' => 'bookList/main',
    'developer' => 'main/developer',
    'company' => 'main/company',
    '' => 'main/main'
);