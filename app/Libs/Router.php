<?php
namespace App\Libs;

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

class Router
{
  private static $routes = [];
  private static $dispatcher;

  public static function get(string $path, callable|array $handler): void
  {
    self::$routes[] = ['GET', $path, $handler];
  }

  public static function post(string $path, callable|array $handler): void
  {
    self::$routes[] = ['POST', $path, $handler];
  }

  public static function match(array $methods, string $path, callable|array $handler): void
  {
    self::$routes[] = [$methods, $path, $handler];
  }

  public static function any(string $path, callable|array $handler): void
  {
    self::$routes[] = [['GET', 'POST', 'PUT', 'DELETE'], $path, $handler];
  }

  public static function dispatch(): void
  {
    if (! self::$dispatcher) {
      self::$dispatcher = simpleDispatcher(function (RouteCollector $r) {
        foreach (self::$routes as $route) {
          [$methods, $path, $handler] = $route;
          $r->addRoute($methods, $path, $handler);
        }
      });
    }

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    // Loại bỏ query string (nếu có)
    if (false !== $pos = strpos($uri, '?')) {
      $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    // Dispatch route
    $routeInfo = self::$dispatcher->dispatch($httpMethod, $uri);

    switch ($routeInfo[0]) {
      case Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo '404 Not Found';
        break;
      case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo '405 Method Not Allowed';
        break;
      case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // Xử lý Controller
        if (is_array($handler) && count($handler) === 2) {
          [$controller, $method] = $handler;
          if (class_exists($controller) && method_exists($controller, $method)) {
            call_user_func([new $controller, $method], $vars);
          } else {
            echo 'Controller or method not found.';
          }
        } elseif (is_callable($handler)) {
          call_user_func($handler, $vars);
        } else {
          echo 'Handler not callable';
        }
        break;
    }
  }
}
