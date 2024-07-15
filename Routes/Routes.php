<?php

namespace App\Routes;

use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Core\Controller;

$router = new Router();

$router->get('/', function() {
    (new HomeController)->index();
});
$router->get('/invoices', function() {
    (new HomeController)->invoices();
});
$router->get('/contact', function() {
    (new HomeController)->contact();
});
$router->get('/companies', function() {
    (new HomeController)->companies();
});
$router->get('/show-companies', function() {
    (new HomeController)->showCompanies();
});
$router->get('/dashboard', function() {
    (new HomeController)->dashboard();
});
$router->get('/logout', function() {
    (new HomeController)->logout();
});
$router->get('/login', function() {
    (new HomeController)->login();
});

//test connection
$router->post('/login', function(){
    (new Controller)->connectUser();
});

$router->run();