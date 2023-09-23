<?php
// app/core/Router.php

class Router {
    private $routes = [];

    /**
     * Define a route for GET requests.
     *
     * @param string $route The route path.
     * @param string $controllerAction The controller and action to be executed (e.g., 'ControllerName@actionName').
     */
    public function get($route, $controllerAction) {
        $this->routes['GET'][$route] = $controllerAction;
    }

    /**
     * Define a route for POST requests.
     *
     * @param string $route The route path.
     * @param string $controllerAction The controller and action to be executed (e.g., 'ControllerName@actionName').
     */
    public function post($route, $controllerAction) {
        $this->routes['POST'][$route] = $controllerAction;
    }

    /**
     * Sprawdź dopasowanie trasy do żądania.
     *
     * @param string $method Metoda HTTP (GET lub POST).
     * @param string $uri URI żądania.
     * @return string|false Nazwa kontrolera i akcji lub false, jeśli brak dopasowania.
     */
    public function match($method, $uri) {
        foreach ($this->routes[$method] as $route => $controllerAction) {
            $pattern = '/' . str_replace('/', '\/', $route) . '/';
            if (preg_match($pattern, $uri)) {
                return $controllerAction;
            }
        }
        return false;
    }

    /**
     * Handle incoming requests and dispatch them to the appropriate controller and action.
     */
    public function run() {
        // Read the request method (GET, POST, etc.)
        $method = $_SERVER['REQUEST_METHOD'];
        // Read the request URL path
        $uri = $_SERVER['REQUEST_URI'];
        $routeFound = false;

        // Review the defined routes for a given method
        foreach ($this->routes[$method] as $route => $controllerAction) {
            $pattern = '/' . str_replace('/', '\/', $route) . '/';

            // Compare the pattern with the current URL path
            if (preg_match($pattern, $uri)) {
                // Extract the controller name and action from the route mapping
                list($controllerName, $action) = explode('@', $controllerAction);
                // Specify the path to the controller file
                $controllerFile = __DIR__ . '/../src/controllers/' . $controllerName . '.php';

                // Check if the controller file exists
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $controllerClass = ucfirst($controllerName) . 'Controller';

                    // Check if the controller class exists
                    if (class_exists($controllerClass)) {
                        // Create a controller instance
                        $controllerInstance = new $controllerClass();

                        // Check if the action method exists in the controller
                        if (method_exists($controllerInstance, $action)) {
                            // Trigger the controller action
                            var_dump("Route matched: $route");
                            var_dump("Controller: $controllerClass");
                            var_dump("Action: $action");
                            $controllerInstance->$action();
                            $routeFound = true;
                            break;
                        }
                    }
                }
            }
        }

        // If no route was matched, handle 404 error
        if (!$routeFound) {
            // Handle 404 Not Found
            var_dump("Route not found: $uri");
            header("HTTP/1.0 404 Not Found");
            include(__DIR__ . '/../src/views/error_404.php');
        }
    }
}