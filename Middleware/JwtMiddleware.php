<?php
namespace app\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;

        if (!$token) {
            http_response_code(401);
            echo json_encode(['error' => 'Token not provided']);
            exit;
        }

        try {
            $token = str_replace('Bearer ', '', $token);
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
            
            // Inject decoded token into the request for further use
            // Since we're not using Symfony's Request object, we'll add it to a global variable
            // You might want to adjust this based on your framework or how you handle request data
            global $jwtPayload;
            $jwtPayload = $decoded;

        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid token: ' . $e->getMessage()]);
            exit;
        }

        return $next($request);
    }
}