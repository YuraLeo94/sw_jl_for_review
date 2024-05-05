<?php

// class Router
// {
//     private $path = [];

//     public function get(string $path, string $controller, $action)
//     {
//         array_push($this->path, [$path, $controller, 'get']);
//     }

//     public function post(string $path, string $controller, $action)
//     {
//         array_push($this->path, [$path, $controller, 'post']);
//     }

//     public function handle()
//     {
//         $pathInfo = isset($_SERVER['PATH_INFO']) ? strtolower(htmlspecialchars($_SERVER['PATH_INFO'])) : '';
//         $key = array_search(strtolower($pathInfo), array_column($this->path, 0));
        
//         if ($key !== false) {
//             $method = $this->path[$key][2];
//             $controller = $this->path[$key][1];
//             if ($method === 'get') {
//                 // print_r($this->path);
//                 // wait from Dima advice of best solution
//                 return call_user_func($controller);
//             } else {
//                 return call_user_func($controller, $_POST);
//             }
//         }
//         else {
//             // Path not found
//             header('HTTP/1.1 404 Not Found');
//             echo '404 Not Found';
//             exit();
//         }
//     }
// }

 // return response(['status' => 'test', 'message' => 'check inputs', 'inputs' => $inputs]);

// require_once('./src/Controllers/ResponseController.php');
// require_once('./src/Controllers/ProductsController.php');
// require_once('./src/Model/Products/Product.php');
// require_once('./src/utils/consts/dictionary.consts.php');
// require_once('./src/Database/Database.php');
// require_once('./src/utils/BindHelper.php');
// require_once('./src/Servieces/ProductsService.php');
// require_once('./src/Model/Products/Book.php');
// require_once('./src/Model/Products/DVD.php');
// require_once('./src/Model/Products/Furniture.php');
// require_once('./Router.php');
// include_once './config.php';

//TODO FOR ProductsService
// Rename to repositories and create repor services ProductsModel -> ProductsService
// example here -> https://github.com/Dmitrijs1710/Crypto_market/blob/main/app/Repositories/CoinsFromApiRepository.php
// ask naming chat gtp!!
// Products move to model;