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
$router->get('/companies', function() {
    (new HomeController)->companies();
});
$router->get('/dashboard', function() {
    (new HomeController)->dashboard();
});
$router->get('/dashboard/new-invoices', function() {
    (new HomeController)->newInvoices();
});

$router->get('/logout', function() {
    (new HomeController)->logout();
});
$router->get('/login', function() {
    (new HomeController)->login();
});
$router->post('/companies', function() {
    (new HomeController)->createCompany();
});
$router->put('/companies/(\d+)', function($id) {
    (new HomeController)->updateCompany($id);
});
$router->delete('/companies/(\d+)', function($id) {
    (new HomeController)->deleteCompany($id);
});


$router->get('/contacts', function() {
    (new HomeController)->contacts();
});
$router->get('/contacts/(\d+)', function($id) {
    (new HomeController)->getContact($id);
});
$router->post('/contacts', function() {
    (new HomeController)->createContact();
});
$router->put('/contacts/(\d+)', function($id) {
    (new HomeController)->updateContact($id);
});
$router->delete('/contacts/(\d+)', function($id) {
    (new HomeController)->deleteContact($id);
});

// Test connection
$router->post('/login', function(){
    (new Controller)->connectUser();
});

$router->run();
