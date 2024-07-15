<?php

namespace App\Routes;

use Bramus\Router\Router;
use App\Controllers\HomeController;

$router = new Router();

$router->get('/', function() {
    (new HomeController)->index();
});

$router->run();