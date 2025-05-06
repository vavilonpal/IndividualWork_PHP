<?php

namespace Core;

class Router
{
    protected static array $routes = [];

    public static function get(string $uri, callable $callback): void
    {
        self::$routes['GET'][] = ['uri' => $uri, 'callback' => $callback];
    }

    public static function post(string $uri, callable $callback): void
    {
        self::$routes['POST'][] = ['uri' => $uri, 'callback' => $callback];
    }

    public static function put(string $uri, callable $callback): void
    {
        self::$routes['PUT'][] = ['uri' => $uri, 'callback' => $callback];
    }

    public static function delete(string $uri, callable $callback): void
    {
        self::$routes['DELETE'][] = ['uri' => $uri, 'callback' => $callback];
    }

    public static function route(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = rtrim($requestUri, '/') ?: '/';

        foreach (self::$routes[$method] ?? [] as $route) {
            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $route['uri']);
            $pattern = "#^" . rtrim($pattern, '/') . "/?$#";

            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Удаляем полный матч
                 call_user_func_array($route['callback'], $matches);
                 exit;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}

