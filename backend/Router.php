<?php

class Router
{
    private $path = [];

    public function get(string $path, string $controller, $action)
    {
        $this->path[$path] = [
            'controller' => $controller,
            'action' => $action,
            'method' => 'get'
        ];
    }

    public function post(string $path, string $controller, $action)
    {
        $this->path[$path] = [
            'controller' => $controller,
            'action' => $action,
            'method' => 'post'
        ];
    }

    public function handle()
    {
        $pathInfo = isset($_SERVER['PATH_INFO']) ? htmlspecialchars($_SERVER['PATH_INFO']) : '';
        // var_dump($_SERVER['PATH_INFO'][$_POST]);
        if (array_key_exists($pathInfo, $this->path)) {
            $method = $this->path[$pathInfo]['method'];
            $controller = $this->path[$pathInfo]['controller'];
            $action = $this->path[$pathInfo]['action'];
            // echo $method;
            // echo $controller;
            // echo $action;
            // var_dump($_GET);
            if ($method === 'get') {
                // print_r($this->path);
                // wait from Dima advice of best solution
                return (new $controller)->{$action}();
            } else {
                $jsonData = file_get_contents('php://input');
                $data = json_decode($jsonData, true);
                return (new $controller)->{$action}($data);
            }
        } else {
            // Path not found
            header('HTTP/1.1 404 Not Found');
            echo '404 Not Found';
            exit();
        }
    }
}
