<?php
require_once "helpers.php";
if (isset($_SERVER['REQUEST_METHOD'])) {
  require_once "routes.php";
}

UnitType::QUANTITY; // Hack to load unit class

$db = new PDO('pgsql:host=localhost;dbname=marmiton', 'm4t', '123456');
DataMapper::init($db);

if (defined('CONTROLLER') && defined('ACTION')) {
  $controller_name = ucfirst(CONTROLLER.'Controller');
  $controller = new $controller_name(CONTROLLER, ACTION);
  $controller->params = $_REQUEST;

  $data             = file_get_contents('php://input');
  $controller->data = json_decode($data);

  $action = ACTION;
  if ($action == 'new')
    $action = 'niou';

  if (is_callable(array($controller, 'before_filter'))) {
    $controller->before_filter();
  }


  $controller->$action(unserialize(PARAMS));
}
