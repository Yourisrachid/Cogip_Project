<?php

namespace App\Routes;

use App\Core\Controller;
use Bramus\Router\Router;
use App\Controllers\HomeController;
use App\Controllers\CompanySeederController;
use App\Controllers\ContactSeederController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$router = new Router();

$router->before('GET|POST', '/(?!login|logout|signup).*', function() {
    if (!isset($_SESSION['user'])) {
        $response = ['status' => 403, 'message' => 'Not authenticated'];
        $controller = new Controller();
        //var_dump($controller);
        $message = $controller->returnJson($response);
        echo $message;
        exit();
    }
});

$router->mount('/admin', function() use ($router) {
    $router->before('GET|POST', '/.*', function() {
        if ($_SESSION['role_id'] !== 1) { // Suppose que 1 est l'ID pour les administrateurs
            $response = ['status' => 403, 'message' => 'Access denied'];
            $controller = new Controller();
            echo $controller->returnJson($response);
            exit();
        }
    });
    $router->get('/test', function() {
        $response = ['status' => '200', 'role_id' => $_SESSION['role_id']];
        $controller = new Controller();
        echo $controller->returnJson($response);
        exit();
    });
});

$router->mount('/moderator', function() use ($router) {
    $router->before('GET|POST', '/.*', function() {
        if ($_SESSION['role_id'] !== 2 && $_SESSION['role_id'] !== 1) { // Suppose que 2 est l'ID pour les modérateurs
            $response = ['status' => 403, 'message' => 'Access denied'];
            $controller = new Controller();
            echo $controller->returnJson($response);
            exit();
        }
    });
    $router->get('/test', function() {
        $response = ['status' => '200', 'role_id' => $_SESSION['role_id']];
        $controller = new Controller();
        echo $controller->returnJson($response);
        exit();
    });    
});

$router->get('/', function() {
    (new HomeController)->index();
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


$router->get('/invoices', function() {
    (new Controller)->invoices();
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
$router->get('/page-invoices/{page}/{limit}', function($page, $limit){
    (new Controller)->paginatedInvoices($page, $limit);
});


// Test connection


//route API
$router->post('/signup', function(){
    (new Controller)->newUser();
});
$router->post('/login', function(){
    (new Controller)->connectUser();
});
$router->post('/logout', function(){
    (new Controller)->logoutUser();
});
$router->get('/user', function(){
    (new Controller)->allUser();
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


$router->get('/seed-companies', function() {
    (new CompanySeederController)->__invoke();
});

$router->get('/seed-contacts', function() {
    (new ContactSeederController)->__invoke();
});

$router->run();
