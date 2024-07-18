<?php

namespace App\Core;

class Middleware
{
    public static function auth()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function role($role)
    {
        self::auth();
        if ($_SESSION['role'] !== $role) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Access denied';
            exit();
        }
    }

    public static function permission($permission)
    {
        self::auth();
        if (!in_array($permission, $_SESSION['permissions'])) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Access denied';
            exit();
        }
    }
}
