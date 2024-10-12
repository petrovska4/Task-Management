<?php

session_start();

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'task';
$controllerName = $controller . 'Controller';

require_once(__DIR__ . '/app/controllers/taskController.php');
$controllerObject = new $controllerName();

$action = "index";
if (method_exists($controllerObject, $action)) {
    $controllerObject->$action();
} else {
    echo $action;
    echo "Action not found!";
}
