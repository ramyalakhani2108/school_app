<?php

declare(strict_types=1);

namespace Framework;

class App
{
    private Router $router;
    private Container $container;

    public function __construct(string $container_definition_path = null)
    {
        $this->router = new Router();
        $this->container = new Container();

        if ($container_definition_path) {
            $container_definition_path = include $container_definition_path;

            $this->container->add_definitions($container_definition_path);
        }
    }

    public function get(string $path, array $controller): App
    {

      
        $this->router->add("GET", $path, $controller);

        return $this;
    }
    public function delete(string $path, array $controller): App //accept the route name as path and array of data [contoller class and function name]
    {
        $this->router->add("DELETE", $path, $controller); //we are using get method instead of post because it is okay to show just a name of route for understanding
        return $this;
    }
    public function post(string $path, array $controller): App
    {
        $this->router->add("POST", $path, $controller);
        return $this;
    }
    public function add_middlewares(string $middlewares)
    {
        $this->router->add_middlewares($middlewares);
    }
    public function add(string $middleware)
    {
        $this->router->add_route_middleware($middleware);
    }
    public function run()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //return trailing path like /,/about
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispatch($path, $method, $this->container);
    }

    public function set_error_handler(array $controller)
    {
        $this->router->set_error_handler($controller);
    }
}
