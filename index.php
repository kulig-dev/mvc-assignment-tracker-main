<?php
// index.php

require 'vendor/autoload.php';

require __DIR__ . '/app/core/Router.php';
require __DIR__ . '/app/config/db_handler.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router();

// Tworzenie obiektów bazy danych
$assignmentDB = new Newde\MvcAssignmentTracker\models\AssignmentDB($db);
$courseDB = new Newde\MvcAssignmentTracker\models\CourseDB($db);


// Dodaj trasę dla strony głównej (domyślna akcja)
$router->get('/', 'AssignmentController@listAction', $assignmentDB); // Przekazujemy obiekt bazy danych do kontrolera

// Dodaj inne trasy do routera
$router->get('/courses', 'CourseController@listAction', $courseDB);
$router->post('/courses/add', 'CourseController@addAction', $courseDB);
$router->post('/courses/delete', 'CourseController@deleteAction', $courseDB);

$router->get('/assignments', 'AssignmentController@listAction', $assignmentDB);
$router->post('/assignments/add', 'AssignmentController@addAction', $assignmentDB);
$router->post('/assignments/delete', 'AssignmentController@deleteAction', $assignmentDB);

// Obsługa żądania
$route = $router->match($method, $uri);

if ($route) {
    list($controllerName, $action) = explode('@', $route);
    $controllerClass = 'Newde\\MvcAssignmentTracker\\controllers\\' . ucfirst($controllerName);

    // Utwórz instancję kontrolera z odpowiednimi zależnościami (np. PDO)
    $controller = new $controllerClass($assignmentDB, $courseDB);

    // Wywołaj odpowiednią akcję kontrolera
    $controller->$action($_REQUEST);
} else {
    // Obsługa 404 Not Found
    http_response_code(404);
    echo '404 Not Found';
}