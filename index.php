<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/Core/Helper.php';
require_once __DIR__.'/Routes/Routes.php';
