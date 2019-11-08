<?php

use components\Router;

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/app');
require_once(ROOT . '/components/Autoload.php');

$router = new Router();
$router->run();