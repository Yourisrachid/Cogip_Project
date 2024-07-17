<?php

namespace App\Routes;

use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Core\Controller;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$router = new Router();

$router->before('GET|POST', '/(?!login|logout).*', function() {
    if (!isset($_SESSION['user'])) {
        $response = ['status' => 404, 'message' => 'Not authenticated'];
        $controller = new Controller();
        //var_dump($controller);
        $message = $controller->returnJson($response);
        echo $message;
        exit();
    }
});


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

//route API
$router->post('/login', function(){
    (new Controller)->connectUser();
});
$router->post('/logout', function(){
    (new Controller)->logoutUser();
});
$router->post('/new-invoices', function(){
    (new Controller)->newInvoice();
});
$router->get('/all-invoices', function(){
    (new Controller)->allInvoice();
});
$router->get('/last-invoices', function(){
    (new Controller)->lastInvoice();
});
$router->get('/page-invoices', function(){
    (new Controller)->paginatedInvoices();
});
$router->get('/update-invoices/(\d+)', function($id){
    (new Controller)->updateInvoices($id);
});
$router->Delete('/delete-invoices/(\d+)', function($id){
    (new Controller)->deleteInvoice($id);
});


$router->run();