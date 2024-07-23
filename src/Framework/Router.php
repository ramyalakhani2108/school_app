<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $error_handler = [];
    private array $middlewares = [];
    public function add(string $method, string $path, array $controller)
    {
        $path = $this->normalized_path($path);

        // $regex_path = preg_replace('#{[^/]+}#', '([^/]+)', $path);
        $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $path);

        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath
        ];
    }

    public function normalized_path(string $path): string
    {
        $path = trim($path, '/'); //remove / from beginning and end
        $path = "/{$path}/"; //add slashes on both sides to get accurate paths
        $path = preg_replace("#[/][2,]#", '/', $path); //if string have consecutive more than one slashes it changes it to one
        return $path;
    }

    public function add_middlewares(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function dispatch(string $path, string $method, Container $container = null)
    {

        $path = $this->normalized_path($path);
        $method = strtoupper($_POST['_METHOD'] ?? $method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['regexPath']}#", $path, $param_values) ||
                $route['method'] !== $method
            ) {

                continue;
            }

            array_shift($param_values);

            preg_match_all("#{([^/]+)}#", $route['path'], $param_keys);
            $param_keys = $param_keys[1];

            $params = array_combine($param_keys, $param_values);
            [$class, $function] = $route['controller'];


            $controller_instance = $container ? $container->resolve($class) :  new $class();
            $action = fn () => $controller_instance->{$function}($params);

            $all_middlewares = [...$route['middlewares'], ...$this->middlewares];

            foreach ($all_middlewares as $middleware) {
                $middleware_instance = $container ? $container->resolve($middleware) : new $middleware();
                $action = fn () => $middleware_instance->process($action);
            }

            $action();
            return;
        }
        $this->dispatch_not_found($container);
    }
    public function add_route_middleware(string $middleware)
    {
        $last_route_key = array_key_last($this->routes);
        $this->routes[$last_route_key]['middlewares'][] = $middleware;
    }
    public function dispatch_not_found(?Container $container)
    {

        [$class, $function] = $this->error_handler;
        $controller_instance = $container ? $container->resolve($class) : new $class();

        $action = fn () => $controller_instance->{$function}();


        foreach ($this->middlewares as $middleware) {
            $middleware_instance = $container ? $container->resolve($middleware) : new $middleware();
            $action = fn () => $middleware_instance->process($action);
        }
        $action();
    }

    public function set_error_handler(array $controller)
    {
        $this->error_handler = $controller;
    }
    public function dipatchNotFound(?Container $container)
    {
        [$class, $function] = $this->error_handler;
        $controlllerInstance = $container ? $container->resolve($class) : new $class();

        $action = fn () => $controlllerInstance->$function();

        foreach ($this->middlewares as $middleware) {
            $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware();
            $action = fn () => $middlewareInstance->process($action);
        }
        $action();
    }
}
