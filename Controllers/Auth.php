<?php

namespace app\Controllers;

use App\Core\Controller;

abstract class Auth extends Controller
{
    abstract protected function getCredentials(): array;

    protected function respondWithToken($token, $user)
    {
        header('Content-Type: application/json');
        echo json_encode([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $_ENV['JWT_TTL'] * 60,
            'user_id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
        ]);
        exit;
    }

    protected function getRequestData()
    {
        $json = file_get_contents('php://input');
        return json_decode($json, true);
    }
}