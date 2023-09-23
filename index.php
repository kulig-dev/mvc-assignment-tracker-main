<?php
// index.php

// Include the Composer autoloader to load dependencies
require 'vendor/autoload.php';

// Include necessary files
require __DIR__ . '/app/core/Router.php';
require __DIR__ . '/app/config/db_handler.php';

// Get the current URI and HTTP method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Initialize the router
$router = new Router();

// Create database objects
$assignmentDB = new Newde\MvcAssignmentTracker\models\AssignmentDB($db);
$courseDB = new Newde\MvcAssignmentTracker\models\CourseDB($db);

// Add a route for the homepage (default action)
$router->get('/', 'AssignmentController@listAction'); // Pass the database object to the controller

// Add other routes to the router
$router->get('/courses', 'CourseController@listAction');
$router->post('/courses/add', 'CourseController@addAction');
$router->post('/courses/delete', 'CourseController@deleteAction');

$router->get('/assignments', 'AssignmentController@listAction');
$router->post('/assignments/add', 'AssignmentController@addAction');
$router->post('/assignments/delete', 'AssignmentController@deleteAction');

// Handle the request
$route = $router->match($method, $uri);

if ($route) {
    list($controllerName, $action) = explode('@', $route);
    $controllerClass = 'Newde\\MvcAssignmentTracker\\controllers\\' . ucfirst($controllerName);

    // Create an instance of the controller with the required dependencies (e.g., PDO)
    $controller = new $controllerClass($assignmentDB, $courseDB);

    // Invoke the appropriate controller action
    $controller->$action($_REQUEST);
} else {
    // Handle 404 Not Found
    http_response_code(404);
    echo '404 Not Found';
}