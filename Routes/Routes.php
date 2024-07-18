<?php

namespace App\Routes;

use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Core\Middleware;

$router = new Router();

$router->get('/', function() {
    (new HomeController)->index();
});

$router->post('/login', function() {
    (new HomeController)->login();
});


// Companies


$router->get('/companies', function() {
    Middleware::permission('view_companies');
    Middleware::sessionTimeout();
    (new HomeController)->companies();
});
$router->get('/companies/(\d+)', function($id) {
    Middleware::permission('view_company');
    Middleware::sessionTimeout();
    (new HomeController)->getCompany($id);
});
$router->post('/companies', function() {
    Middleware::permission('create_company');
    Middleware::sessionTimeout();
    (new HomeController)->createCompany();
});
$router->put('/companies/(\d+)', function($id) {
    Middleware::permission('edit_company');
    Middleware::sessionTimeout();
    (new HomeController)->updateCompany($id);
});
$router->delete('/companies/(\d+)', function($id) {
    Middleware::permission('delete_company');
    Middleware::sessionTimeout();
    (new HomeController)->deleteCompany($id);
});



// Contacts


$router->get('/contacts', function() {
    Middleware::permission('view_contacts');
    Middleware::sessionTimeout();
    (new HomeController)->contacts();
});
$router->get('/contacts/(\d+)', function($id) {
    Middleware::permission('view_contact');
    Middleware::sessionTimeout();
    (new HomeController)->getContact($id);
});
$router->post('/contacts', function() {
    Middleware::permission('create_contact');
    Middleware::sessionTimeout();
    (new HomeController)->createContact();
});
$router->put('/contacts/(\d+)', function($id) {
    Middleware::permission('edit_contact');
    Middleware::sessionTimeout();
    (new HomeController)->updateContact($id);
});
$router->delete('/contacts/(\d+)', function($id) {
    Middleware::permission('delete_contact');
    Middleware::sessionTimeout();
    (new HomeController)->deleteContact($id);
});


// Test connection


$router->post('/login', function(){
    (new HomeController)->connectUser();
});




$router->post('/register', function() {
    (new HomeController)->register();
});


$router->run();
