<?php
// TODO create autload!! REQUIRED!
require_once('./src/Controllers/ResponseController.php');
require_once('./src/Controllers/ProductsController.php');
require_once('./src/Products/Product.php');
require_once('./src/utils/dictionary.consts.php');
require_once('./src/Database/Database.php');
require_once('./src/Model/Products.php');
require_once('./src/Products/Book.php');
require_once('./src/Products/DVD.php');
require_once('./src/Products/Furniture.php');
require_once('./Router.php');
include_once './config.php';

// spl_autoload_register(function ($class) {
//     // Replace backslashes with directory separators
//     $classFile = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
//     // Check if the file exists
//     if (file_exists($classFile)) {
//         require_once $classFile;
//     }
// });

$router = new Router();

$router->get('/products/get', 'Controllers\ProductsController', 'get');

$router->post('/products/add', 'Controllers\ProductsController', 'create');
$router->post('/products/delete', 'Controllers\ProductsController', 'deleteListOfProducts');

$router->handle();
Database\Database::close();