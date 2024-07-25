<?php

namespace App\Routes;

use App\Core\Controller;
use App\Core\Middleware;
use Bramus\Router\Router;
use App\Middleware\JwtMiddleware;
use App\Controllers\HomeController;
use App\Controllers\CompanySeederController;
use App\Controllers\ContactSeederController;
use App\Controllers\InvoiceSeederController;
use App\Controllers\LoginController;

$router = new Router();

// Middleware JWT
$jwtMiddleware = function () {
    $jwtMiddleware = new JwtMiddleware();
    $request = $_SERVER; // Or whatever you use to represent the current request
    $next = function () {}; // Dummy next function for demonstration
    $jwtMiddleware->handle($request, $next);
};

// Routes sans authentification
$router->get('/', function () {
    (new HomeController)->index();
});

$router->get('/companies', function () {
    (new HomeController)->companies();
});

$router->get('/companies/(\d+)', function ($id) {
    (new HomeController)->getCompany($id);
});

$router->get('/contacts', function () {
    (new HomeController)->contacts();
});

$router->get('/contacts/(\d+)', function ($id) {
    (new HomeController)->getContact($id);
});

$router->get('/invoices', function () {
    (new HomeController)->invoices();
});

$router->get('/invoices/(\d+)', function ($id) {
    (new HomeController)->getInvoice($id);
});

$router->post('/signup', function () {
    (new Controller)->newUser();
});

$router->post('/login', function () {
    (new LoginController)->login();
});

$router->post('/check-auth', function () {
    (new HomeController)->checkAuth();
});

$router->get('/seed-companies', function () {
    (new CompanySeederController)->__invoke();
});

$router->get('/seed-contacts', function () {
    (new ContactSeederController)->__invoke();
});

$router->post('/register', function () {
    (new HomeController)->register();
});

$router->get('/seed-invoices', function () {
    (new InvoiceSeederController)->__invoke();
});

$router->get('/users', function () {
    (new Controller)->allUser();
});

$router->get('/users/(\d+)', function ($id) {
    (new HomeController)->getUser($id);
});

// Appliquer le middleware JWT aux routes protégées
$router->before('POST|PUT|DELETE', '/jwt/.*', $jwtMiddleware);

$router->mount('/jwt', function () use ($router) {
    $router->post('/companies', function () {
        (new HomeController)->createCompany();
    });
    $router->put('/companies/(\d+)', function ($id) {
        (new HomeController)->updateCompany($id);
    });
    $router->delete('/companies/(\d+)', function ($id) {
        (new HomeController)->deleteCompany($id);
    });

    $router->post('/contacts', function () {
        // Middleware::permission('create_contact');
        (new HomeController)->createContact();
    });
    $router->put('/contacts/(\d+)', function ($id) {
        // Middleware::permission('edit_contact');
        (new HomeController)->updateContact($id);
    });
    $router->delete('/contacts/(\d+)', function ($id) {
        // Middleware::permission('delete_contact');
        (new HomeController)->deleteContact($id);
    });

    $router->post('/invoices', function () {
        // Middleware::permission('create_invoice');
        (new HomeController)->createInvoice();
    });
    $router->put('/invoices/(\d+)', function ($id) {
        // Middleware::permission('edit_invoice');
        (new HomeController)->updateInvoice($id);
    });
    $router->delete('/invoices/(\d+)', function ($id) {
        // Middleware::permission('delete_invoice');
        (new HomeController)->deleteInvoice($id);
    });
});

$router->run();
