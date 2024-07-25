<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: http://localhost:5173");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");
    exit;
}

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

// Configuration de la session
ini_set('session.cookie_samesite', 'None');
ini_set('session.cookie_secure', 0);
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '127.0.0.1',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'None'
]);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Core/Helper.php';
require_once __DIR__ . '/Routes/Routes.php';

