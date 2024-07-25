<?php

namespace App\Routes;

use App\Core\Controller;
use App\Core\Middleware;
use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Controllers\CompanySeederController;
use App\Controllers\ContactSeederController;
use App\Controllers\InvoiceSeederController;

// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

$router = new Router();

// $router->before('GET|POST', '/(?!login|logout|signup).*', function() {
//     if (!isset($_SESSION['user'])) {
//         $response = ['status' => 403, 'message' => 'Not authenticated'];
//         $controller = new Controller();
//         //var_dump($controller);
//         $message = $controller->returnJson($response);
//         echo $message;
//         exit();
//     }
// });

$router->mount('/admin', function () use ($router) {
    $router->before('GET|POST|PUT|DELETE', '/.*', function () {
        if ($_SESSION['role_id'] !== 1) { // Suppose que 1 est l'ID pour les administrateurs
            $response = ['status' => 403, 'message' => 'Access denied'];
            $controller = new Controller();
            echo $controller->returnJson($response);
            exit();
        }
    });

    $router->post('/companies', function () {
        Middleware::permission('create_company');
        // Middleware::sessionTimeout();
        (new HomeController)->createCompany();
    });
    $router->put('/companies/(\d+)', function ($id) {
        Middleware::permission('edit_company');
        // Middleware::sessionTimeout();
        (new HomeController)->updateCompany($id);
    });
    $router->delete('/companies/(\d+)', function ($id) {
        Middleware::permission('delete_company');
        // Middleware::sessionTimeout();
        (new HomeController)->deleteCompany($id);
    });



    $router->post('/contacts', function () {
        Middleware::permission('create_contact');
        // Middleware::sessionTimeout();
        (new HomeController)->createContact();
    });
    $router->put('/contacts/(\d+)', function ($id) {
        Middleware::permission('edit_contact');
        // Middleware::sessionTimeout();
        (new HomeController)->updateContact($id);
    });
    $router->delete('/contacts/(\d+)', function ($id) {
        Middleware::permission('delete_contact');
        // Middleware::sessionTimeout();
        (new HomeController)->deleteContact($id);
    });



    $router->post('/invoices', function () {
        Middleware::permission('create_invoice');
        // Middleware::sessionTimeout();
        (new HomeController)->createInvoice();
    });
    $router->put('/invoices/(\d+)', function ($id) {
        Middleware::permission('edit_invoice');
        // Middleware::sessionTimeout();
        (new HomeController)->updateInvoice($id);
    });
    $router->delete('/invoices/(\d+)', function ($id) {
        Middleware::permission('delete_invoice');
        // Middleware::sessionTimeout();
        (new HomeController)->deleteInvoice($id);
    });


    $router->put('/users/(\d+)/role', function ($id) {
        (new HomeController)->updateUserRole($id);
    });




});

$router->mount('/moderator', function () use ($router) {
    $router->before('GET|POST', '/.*', function () {
        if ($_SESSION['role_id'] !== 2 && $_SESSION['role_id'] !== 1) { // Suppose que 2 est l'ID pour les modérateurs
            $response = ['status' => 403, 'message' => 'Access denied'];
            $controller = new Controller();
            echo $controller->returnJson($response);
            exit();
        }
    });

    $router->post('/companies', function () {
        Middleware::permission('create_company');
        // Middleware::sessionTimeout();
        (new HomeController)->createCompany();
    });


    $router->post('/contacts', function () {
        Middleware::permission('create_contact');
        // Middleware::sessionTimeout();
        (new HomeController)->createContact();
    });


    $router->post('/invoices', function () {
        Middleware::permission('create_invoice');
        // Middleware::sessionTimeout();
        (new HomeController)->createInvoice();
    });

});

$router->get('/', function () {
    (new HomeController)->index();
});
// $router->get('/dashboard', function() {
//     (new HomeController)->dashboard();
// });

// $router->get('/logout', function() {
//     (new HomeController)->logout();
// });
// $router->get('/login', function() {
//     (new HomeController)->login();
// });


// Companies


$router->get('/companies', function () {
    // Middleware::permission('view_companies');
    // Middleware::sessionTimeout();
    (new HomeController)->companies();
});
$router->get('/companies/(\d+)', function ($id) {
    // Middleware::permission('view_company');
    // Middleware::sessionTimeout();
    (new HomeController)->getCompany($id);
});




// Contacts


$router->get('/contacts', function () {
    // Middleware::permission('view_contacts');
    // Middleware::sessionTimeout();
    (new HomeController)->contacts();
});
$router->get('/contacts/(\d+)', function ($id) {
    // Middleware::permission('view_contact');
    // Middleware::sessionTimeout();
    (new HomeController)->getContact($id);
});



// Invoices


$router->get('/invoices', function () {
    (new HomeController)->invoices();
});
$router->get('/invoices/(\d+)', function ($id) {
    (new HomeController)->getInvoice($id);
});


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


//route API
$router->post('/signup', function () {
    (new Controller)->newUser();
});
$router->post('/login', function () {
    (new HomeController)->login();
});
// $router->post('/logout', function(){
//     (new Controller)->logoutUser();
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
// $router->get('/page-invoices', function(){
//     (new Controller)->paginatedInvoices();
// });
// $router->get('/update-invoices/(\d+)', function($id){
//     (new Controller)->updateInvoices($id);
// });
// $router->Delete('/delete-invoices/(\d+)', function($id){
//     (new Controller)->deleteInvoice($id);
// });


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



$router->run();
