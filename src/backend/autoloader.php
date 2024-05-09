<?php
spl_autoload_register(function ($className) {
    // Define the base directory for the namespace prefix
    $baseDir = __DIR__ . '/src/';

    // Replace namespace separator with directory separator,
    // append with .php and load the file
    $className = str_replace('\\', '/', $className);
    $file = $baseDir . $className . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

require_once('./Router.php');
require_once('./src/utils/consts/dictionary.consts.php');