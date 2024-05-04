<?php
require_once('./Controllers/ResponseController.php');
require_once('./Products/Product.php');
require_once('./utils/dictionary.consts.php');
require_once('./Database/Database.php');
require_once('./Model/Products.php');
require_once('./Products/Book.php');
require_once('./Products/DVD.php');
require_once('./Products/Furniture.php');
require_once('./Controllers/ProductsController.php');
require_once('./Router.php');
include_once './config.php';
require_once './Helper.php';

$router = new Router();

$router->get('/products/get', 'ProductsController::get');

$router->post('/products/add', 'ProductsController::add');
$router->post('/products/delete', 'ProductsController::deleteListOfProducts');

$router->handle();