<?php

spl_autoload_register(function ($class) {
    $array_paths = array(
        '/components/',
        '/controllers/',
        '/models/',
    );

    foreach ($array_paths as $path) {
        $file = ROOT . $path . $class . '.php';
        if (is_file($file)) {
            include $file;
        }
    }
});