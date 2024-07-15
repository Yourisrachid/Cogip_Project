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
$router->get('/dashboard/new-invoices', function() {
    (new HomeController)->newInvoices();
});
$router->get('/dashboard/new-companies', function() {
    (new HomeController)->newCompanies();
});
$router->get('/dashboard/new-contact', function() {
    (new HomeController)->newContact();
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