<?php
// Define configuration options
// Define configuration options

// !!!!!THINK ABOUT RENAME TO CORE POLICE. fILE NAMING;
$allowedOrigins = [
    'http://localhost:3000',
    'http://localhost/projects/SW/backend',
    'http://localhost:3000/addproduct'
];
$allowedHeaders = ['Content-Type'];
$allowedMethods = ['OPTIONS','GET', 'POST', 'DELETE'];

// Set headers for CORS
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

// Check if the requesting origin is allowed
if (in_array($origin, $allowedOrigins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
} 
// else {
//     header('HTTP/1.1 403 Forbidden');
//     exit();
// }

// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: ' . implode(', ', $allowedMethods));
header('Access-Control-Allow-Headers: ' . implode(', ', $allowedHeaders));

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header('Access-Control-Allow-Methods: ' . implode(', ', $allowedMethods));
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        $requestHeaders = array_map('trim', explode(',', $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']));
        if (count(array_intersect($requestHeaders, $allowedHeaders)) === count($requestHeaders)) {
            header('Access-Control-Allow-Headers: ' . implode(', ', $allowedHeaders));
        }
    }
    exit();
}

// Set default headers for non-preflight requests
header('Content-Type: application/json-rpc');

// Validate allowed methods for non-preflight requests
if (!in_array($_SERVER['REQUEST_METHOD'], $allowedMethods)) {
    header('HTTP/1.1 405 Method Not Allowed');
    exit();
}

//config
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'scandiweb');

// v konfigi zapretit dostup k php
