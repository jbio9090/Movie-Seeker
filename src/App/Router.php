<?php
declare(strict_types=1);
namespace App;

use App\Exceptions\PageNotFoundException;
use App\Exceptions\RouteNotFoundException;


require_once(__DIR__ . "/../../vendor/autoload.php");



class Router
{

    private array $routes;

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;
        return $this;
    }


    public function get(string $route, callable|array $action): self
    {
        return $this->register('GET', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('POST', $route, $action);
    }



    public function resolve(string $route, string $requestMethod)
    {
        $uri = explode("?", $route)[0];
        $action = $this->routes[$requestMethod][$uri] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            // $action();
            var_dump($uri);
        }

        if (is_array($action)) {
            [$class, $method] = $action;

            $obj = new $class;
            $obj->$method();
        }

    }
}



