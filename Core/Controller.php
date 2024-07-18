<?php 

namespace App\Core;
use PDO;
use Exception;
use PDOException;
use App\Models\DatabaseManager;

class Controller 
{
    protected $dbManager;
    /*
    * @var $view, $data
    * return view
    */
    public function view($view, $data = [])
    {
        extract($data);
        require_once(__ROOT__.'/Resources/views/'.$view.'.php');
    }

    

    public function __construct() 
    {
        $this->dbManager = new DatabaseManager();
    }

    public function connectUser()
    {
        return $this->getConnectUser();
    }

    private function getConnectUser()
    {
        try {
            $bdd = $this->dbManager->getConnection();

            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $query = 'SELECT users.*, roles.name as role_name FROM users 
                          LEFT JOIN roles ON users.role_id = roles.id 
                          WHERE email = :email';
                $stmt = $bdd->prepare($query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    session_start();
                    session_regenerate_id(true);
                    $_SESSION['user'] = $user;
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['role'] = $user['role_name'];

                    $permissionsQuery = 'SELECT permissions.name FROM permissions 
                                         LEFT JOIN role_permissions ON permissions.id = role_permissions.permission_id 
                                         WHERE role_permissions.role_id = :role_id';
                    $permissionsStmt = $bdd->prepare($permissionsQuery);
                    $permissionsStmt->bindParam(':role_id', $user['role_id'], PDO::PARAM_INT);
                    $permissionsStmt->execute();
                    $permissions = $permissionsStmt->fetchAll(PDO::FETCH_COLUMN);

                    $_SESSION['permissions'] = $permissions;

                    return $this->jsonResponse(['message' => 'Login successful', 'user' => $user]);
                } else {
                    return $this->jsonResponse(['error' => 'Invalid email or password'], 401);
                }
            } else {
                return $this->jsonResponse(['error' => 'Email and password are required'], 400);
            }

        } catch (PDOException $e) {
            return $this->jsonResponse(['error' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    protected function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }



    public function newInvoice()
    {
        echo $this->postNewInvoice();
    }

    public function postNewInvoice()
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $ref = $_POST['ref'];
            $id_company = $_POST['id_company'];
            $price = $_POST['price'];

            $query = 'INSERT INTO invoices(ref, id_company, price, created_at, update_at)
                    VALUE (:ref, :id_company, :price, NOW(), NOW())';
            $result = $bdd->prepare($query);
            $result->bindParam(':ref', $ref, PDO::PARAM_STR);
            $result->bindParam(':id_company', $id_company, PDO::PARAM_STR);
            $result->bindParam(':price', $price, PDO::PARAM_STR);
            $result->execute();

            $response = $this->responseObject->Response(201, 'invoice created successfully');
            return $this->json($response);
        } catch (PDOException $e) {
            return $this->json([
                'status' => 500,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        } catch (Exception $e) {
            return $this->json([
                'status' => 400,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

}
