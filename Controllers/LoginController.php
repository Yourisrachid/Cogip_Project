<?php

namespace app\Controllers;

use PDO;
use Firebase\JWT\JWT;
use App\Controllers\Auth;

class LoginController extends Auth
{
    protected function getCredentials(): array
    {
        $data = $this->getRequestData();
        return [
            'email' => $data['email'] ?? null,
            'password' => $data['password'] ?? null,
        ];
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->jsonResponse(['message' => 'Please login']);
        }

        $credentials = $this->getCredentials();
        $email = $credentials['email'];
        $password = $credentials['password'];

        if (!$email || !$password) {
            return $this->jsonResponse(['error' => 'Email and password are required!'], 400);
        }

        $user = $this->authenticateUser($email, $password);
        if (isset($user['error'])) {
            return $this->jsonResponse(['error' => $user['error']], 401);
        }

        $token = $this->generateJwtToken($user);

        return $this->respondWithToken($token, $user);
    }

    private function authenticateUser($email, $password)
    {
        $bdd = $this->dbManager->getConnection();
        $query = 'SELECT users.*, roles.name as role_name FROM users 
                  LEFT JOIN roles ON users.role_id = roles.id 
                  WHERE email = :email';
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $permissionsQuery = 'SELECT permissions.name FROM permissions 
                                 LEFT JOIN role_permissions ON permissions.id = role_permissions.permission_id 
                                 WHERE role_permissions.role_id = :role_id';
            $permissionsStmt = $bdd->prepare($permissionsQuery);
            $permissionsStmt->bindParam(':role_id', $user['role_id'], PDO::PARAM_INT);
            $permissionsStmt->execute();
            $permissions = $permissionsStmt->fetchAll(PDO::FETCH_COLUMN);

            // Ajout des permissions à l'objet utilisateur
            $user['permissions'] = $permissions;

            // Suppression du mot de passe de l'objet utilisateur avant de le renvoyer
            unset($user['password']);

            return $user;
        }
        return ['error' => 'Invalid email or password!'];
    }

    private function generateJwtToken($user)
    {
        $payload = [
            'user_id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user['email'],
            'role' => $user['role_name'],
            'permissions' => $user['permissions'],
            'exp' => time() + $_ENV['JWT_TTL'] * 60  // Expiration time
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }

    protected function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}