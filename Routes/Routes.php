<?php

namespace App\Routes;

use App\Controllers\CompanySeederController;
use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Core\Controller;

$router = new Router();

// $router->get('/', function() {
//     (new HomeController)->index();
// });
// $router->get('/dashboard', function() {
//     (new HomeController)->dashboard();
// });

// $router->get('/logout', function() {
//     (new HomeController)->logout();
// });
// $router->get('/login', function() {
//     (new HomeController)->login();
// });


//Companies



$router->get('/companies', function() {
    (new HomeController)->companies();
});
$router->get('/companies/(\d+)', function($id) {
    (new HomeController)->getCompany($id);
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


// Contacts


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


// Invoices


// $router->get('/invoices', function() {
//     (new Controller)->invoices();
// });
// $router->post('/new-invoices', function(){
//     (new Controller)->newInvoice();
// });
// $router->get('/all-invoices', function(){
//     (new Controller)->allInvoice();
// });
// $router->get('/last-invoices', function(){
//     (new Controller)->lastInvoice();
// });
// $router->get('/page-invoices/{page}/{limit}', function($page, $limit){
//     (new Controller)->paginatedInvoices($page, $limit);
// });


// Test connection


$router->post('/login', function(){
    (new Controller)->connectUser();
});

$router->get('/seed-companies', function() {
    (new CompanySeederController)->__invoke();
});

$router->run();
