<?php

class Router
{
    private $path = [];

    public function get(string $path, string $controller, $action)
    {
        array_push($this->path, [$path, $controller, 'get']);
    }

    public function post(string $path, string $controller, $action)
    {
        array_push($this->path, [$path, $controller, 'post']);
    }

    public function handle()
    {
        $pathInfo = isset($_SERVER['PATH_INFO']) ? strtolower(htmlspecialchars($_SERVER['PATH_INFO'])) : '';
        $key = array_search(strtolower($pathInfo), array_column($this->path, 0));
        
        if ($key !== false) {
            $method = $this->path[$key][2];
            $controller = $this->path[$key][1];
            if ($method === 'get') {
                // print_r($this->path);
                // wait from Dima advice of best solution
                return call_user_func($controller);
            } else {
                return call_user_func($controller, $_POST);
            }
        }
        else {
            // Path not found
            header('HTTP/1.1 404 Not Found');
            echo '404 Not Found';
            exit();
        }
    }
}
