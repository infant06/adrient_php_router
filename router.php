<?php
class Router
{
    private $routes = [];

    public function add($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                call_user_func($route['callback']);
                return;
            }
        }

        // Default 404 response
        http_response_code(404);
        include __DIR__ . '/theme/adrient/404.php';
    }

    // Adding a route for 404 page
    public function __construct()
    {
        $this->add('GET', '/404', function () {
            include __DIR__ . '/theme/adrient/404.php';
        });
    }
}
?>