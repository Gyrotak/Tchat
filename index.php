<?php

require_once ("autoloader.php");

session_start();

autoloader::$files = [
    "App/Controller/Authentification",
    "App/Controller/TChat",
    "App/Service/FieldVerification/field_verification",
    "App/Service/Router/Route",
    "App/Service/Router/Router",
    "App/Service/ViewLoad/ViewLoad",
    "Models/Chat",
    "Models/Credential"
];

autoloader::register();

use  App\Controller\Authentification;
use  App\Controller\TChat;
use  App\Service\Router\Router as Router;

$router = new Router($_GET['url']);

$router->get('/', "Authentification@index");
$router->post('/', "Authentification@connect");
$router->get('/Tchat', "TChat@index");
$router->post('/Tchat', "TChat@send");
$router->get('/TChat/deconnexion', "TChat@deconnexion");
$router->get('/error_404', "Authentification@error");

try {
    $router->run();
} catch (\Exception $e) {
    header("Location: /error_404");
    exit;
}

?>