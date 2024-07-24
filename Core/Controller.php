<?php 

namespace App\Core;
use App\Models\Response;
use App\Models\Invoice;
use App\Models\Invoices;
use App\Models\Users;
use App\Models\DatabaseManager;
use PDO;
use Exception;
use PDOException;


class Controller 
{
    private $dbManager;
    private $responseObject;
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
        $this->responseObject = new Response();
    }
    public function returnJson($response)
    {
        return $this->json($response);
    }

    private function json($response)
    {
        $jsonPosts = json_encode($response);
            if ($jsonPosts === false) {
                throw new Exception(json_last_error_msg());
            }
            header('Content-Type: application/json');
            return $jsonPosts;
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
            
                $query = 'SELECT * FROM users WHERE email = :email';
                $result = $bdd->prepare($query);
                $result->bindParam(':email', $email, PDO::PARAM_STR);
                $result->execute();
                $user = $result->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user'] = $user; 
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['role_id'] = $user['role_id'];
                    $data = ['first_name' =>  $user['first_name'], 'last_name' => $user['last_name'], 'role_id' => $user['role_id']];
                } else {
                    echo $this->json($response = $this->responseObject->Response('400', 'Invalid email or password'));
                }
            } else {
                echo $this->json($response= $this->responseObject->Response('400', 'email and password are required'));
            }

        } catch (PDOException $e) {
            echo $this->json($response= $this->responseObject->Response(500, 'Erreur de requête : ' . $e->getMessage()));
        }
        echo $this->json($response= $this->responseObject->ResponseData('200', 'Connected', $data));
    }
    
    public function logoutUser()
    {
        return $this->getLogoutUser();
    }
    private function getLogoutUser()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        session_destroy();

        // Supprimer le cookie de session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
            echo $this->json($response= $this->responseObject->Response(200, 'disconnected'));
            exit();
    }
    public function newUser()
    {
        return $this->postNewUser();
    }

    private function postNewUser() 
    {
        try {
            $bdd = $this->dbManager->getConnection();
            if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password'])) {
                
                $first_name = htmlspecialchars(trim($_POST['first_name']));
                $last_name = htmlspecialchars(trim($_POST['last_name']));
                $email = htmlspecialchars(trim($_POST['email']));
                $password = htmlspecialchars(trim($_POST['password']));
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $checkQuery = 'SELECT COUNT(*) FROM `users` WHERE email = :email';
                $check = $bdd->prepare($checkQuery);
                $check->bindParam(':email', $email, PDO::PARAM_STR);
                $check->execute();
                $emailExists = $check->fetchColumn();

                if ($emailExists > 0) {
                    echo $this->json($this->responseObject->Response('400', 'Email already exists'));
                    return;
                }
                
                $query = 'INSERT INTO `users` (first_name, last_name, email, password, created_at, updated_at) 
                        VALUES (:first_name, :last_name, :email, :password, NOW(), NOW())';
                $result = $bdd->prepare($query);
                $result->bindParam(':first_name', $first_name, PDO::PARAM_STR);
                $result->bindParam(':last_name', $last_name, PDO::PARAM_STR);
                $result->bindParam(':email', $email, PDO::PARAM_STR);
                $result->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

                if ($result->execute()) {
                    //echo $this->json($this->responseObject->Response('201', 'User created successfully'));
                    $userId = $bdd->lastInsertId();
    
                    $result = $bdd->prepare('SELECT * FROM `users` WHERE id = :id');
                    $result->bindValue(':id', $userId);
                    $result->execute();
    
                    $user = $result->fetch(PDO::FETCH_ASSOC);
    
                    if ($user) {
                        $_SESSION['user'] = $user;
                        $_SESSION['first_name'] = $user['first_name'];
                        $_SESSION['last_name'] = $user['last_name'];
                        $_SESSION['role_id'] = $user['role_id'];
                        $data = ['first_name' =>  $user['first_name'], 'last_name' => $user['last_name'], 'role_id' => $user['role_id']];
                        echo $this->json($response= $this->responseObject->ResponseData('200', 'Connected', $data));
                    }
                }
            } else {
                echo $this->json($this->responseObject->Response('400', 'firstname, lastname and password are required'));
            }  
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
    public function allUser()
    {
        echo $this->getAllUsers();
    }
    public function getAllUsers() {
        $user = new Users();

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

        $filters = [];
        if (isset($_GET['first_name'])) {
            $filters['first_name'] = $_GET['first_name'];
        }
        if (isset($_GET['last_name'])) {
            $filters['last_name'] = $_GET['last_name'];
        }
        if (isset($_GET['role_id'])) {
            $filters['role_id'] = $_GET['role_id'];
        }
        if (isset($_GET['email'])) {
            $filters['email'] = $_GET['email'];
        }
        $sort = [];
        if (isset($_GET['sort_by'])) {
            $sort[$_GET['sort_by']] = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';
        }

        $fetchAll = isset($_GET['all']) && $_GET['all'] == 'true';
        
        $users = $user->getAllUser($page, $limit, $filters, $sort, $fetchAll);
        return $this->json($response= $this->responseObject->ResponseData(200, 'OK', $users));
    }

    // public function newInvoice()
    // {
    //     echo $this->postNewInvoice();
    // }

    // public function postNewInvoice()
    // {
    //     try {
    //         $bdd = $this->dbManager->getConnection();
    //         $ref = $_POST['ref'];
    //         $id_company = $_POST['id_company'];
    //         $price = $_POST['price'];

    //         $query = 'INSERT INTO invoices(ref, id_company, price, created_at, update_at)
    //                 VALUE (:ref, :id_company, :price, NOW(), NOW())';
    //         $result = $bdd->prepare($query);
    //         $result->bindParam(':ref', $ref, PDO::PARAM_STR);
    //         $result->bindParam(':id_company', $id_company, PDO::PARAM_STR);
    //         $result->bindParam(':price', $price, PDO::PARAM_STR);
    //         $result->execute();

    //         $response = $this->responseObject->Response(201, 'invoice created successfully');
    //         // return $this->json($response);
    //         $bdd = $this->dbManager->getConnection();
    //         $ref = $_POST['ref'];
    //         $id_company = $_POST['id_company'];
    //         $price = $_POST['price'];

    //         $query = 'INSERT INTO invoices(ref, id_company, price, created_at, update_at)
    //                 VALUE (:ref, :id_company, :price, NOW(), NOW())';
    //         $result = $bdd->prepare($query);
    //         $result->bindParam(':ref', $ref, PDO::PARAM_STR);
    //         $result->bindParam(':id_company', $id_company, PDO::PARAM_STR);
    //         $result->bindParam(':price', $price, PDO::PARAM_STR);
    //         $result->execute();

    //         $response = $this->responseObject->Response(201, 'invoice created successfully');
    //         return $this->json($response);
    //     } catch (PDOException $e) {
    //         return $this->json([
    //             'status' => 500,
    //             'message' => 'Database error: ' . $e->getMessage()
    //         ]);
    //     } catch (Exception $e) {
    //         return $this->json([
    //             'status' => 400,
    //             'message' => 'Error: ' . $e->getMessage()
    //         ]);
    //     }
    // }
    // public function lastInvoice()
    // {
    //     $query = 'SELECT * FROM invoices ORDER BY created_at DESC LIMIT 5';
    //     echo $this->getInvoice($query);
    // }

    // public function allInvoice()
    // {
    //     $query = 'SELECT * FROM invoices';
    //     echo $this->getInvoice($query);
    // }

    // public function paginatedInvoices()
    // {
    //     /*$offset = ($page - 1) * $limit;
    //     $query = 'SELECT * FROM invoices';

    //     if ($startDate && $endDate) {
    //         $query .= ' WHERE created_at BETWEEN :startDate AND :endDate';
    //     }
    //     $query .= ' LIMIT :limit OFFSET :offset';*/
    //     echo $this->getInvoices();
    // }

    // public function getInvoices() {
    //     $invoice = new Invoices();

    //     $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    //     $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

    //     $filters = [];
    //     if (isset($_GET['ref'])) {
    //         $filters['ref'] = $_GET['ref'];
    //     }
    //     if (isset($_GET['price'])) {
    //         $filters['price'] = $_GET['price'];
    //     }
    //     if (isset($_GET['id_company'])) {
    //         $filters['id_company'] = $_GET['id_company'];
    //     }
    //     $sort = [];
    //     if (isset($_GET['sort_by'])) {
    //         $sort[$_GET['sort_by']] = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';
    //     }

    //     $fetchAll = isset($_GET['all']) && $_GET['all'] == 'true';
    //     var_dump($sort);
    //     $invoices = $invoice->getAllInvoices($page, $limit, $filters, $sort, $fetchAll);
    //     return $this->json($response= $this->responseObject->ResponseData(200, 'OK', $invoices));
    // }

    // private function getInvoice($query, $limit = null, $offset = null, $startDate = null, $endDate = null)
    // {
    //     try {
    //         $bdd = $this->dbManager->getConnection();
    //         $result = $bdd->prepare($query);
    //         if ($limit !== null && $offset !== null) {
    //             $result->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    //             $result->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
    //         }
    //         if ($startDate && $endDate) {
    //             $result->bindParam(':startDate', $startDate, PDO::PARAM_STR);
    //             $result->bindParam(':endDate', $endDate, PDO::PARAM_STR);
    //         }
    //         $result->execute();
    //         $rawInvoices = $result->fetchAll(PDO::FETCH_ASSOC);
            
    //         if ($rawInvoices) {
    //             foreach ($rawInvoices as $rawInvoice) {
    //                 $price = (float) $rawInvoice['price'];
    //                 $invoice = new Invoice(
    //                 $rawInvoice['id'],
    //                 $rawInvoice['ref'], 
    //                 $price,
    //                 $rawInvoice['id_company'],
    //                 (new \DateTime($rawInvoice['created_at']))->format('d-m-Y'),
    //                 (new \DateTime($rawInvoice['update_at']))->format('d-m-Y')
    //             );
    //             $invoices [] = $invoice;
    //             }
    //             $response = $this->responseObject->ResponseData(200, 'OK', $invoices);
    //         } else {
    //             $response = $this->responseObject->Response('404', 'Invoices not found');
    //         }

    //     return $json = $this->json($response);

    //     } catch (PDOException $e) {
    //         echo 'Erreur de requête : ' . $e->getMessage();
    //     } catch (Exception $e) {
    //         echo 'Erreur de conversion en JSON : ' . $e->getMessage();
    //     }
    // }

    // public function updateInvoices($id)
    // {
    //     echo $this->putUdateInvoices($id);
    // }
    
    // private function putUdateInvoices($id)
    // {
    //     try {
    //         $bdd = $this->dbManager->getConnection();
    //         $inputJSON = file_get_contents('php://input');
    //         $_PUT = json_decode($inputJSON, true);

    //         $ref = $_PUT['ref'];
    //         $id_company = $_PUT['id_company'];
    //         $price = $_PUT['price'];
            
    //         $query = 'UPDATE invoices SET ref = :ref, id_company = :id_company, price = :price, update_at = NOW() WHERE id = :id';

    //         $result = $bdd->prepare($query);
    //         $result->bindParam(':id', $id, PDO::PARAM_INT);
    //         $result->bindParam(':ref', $ref, PDO::PARAM_STR);
    //         $result->bindParam(':id_company', $id_company, PDO::PARAM_STR);
    //         $result->bindParam(':price', $price, PDO::PARAM_STR);
    //         $result->execute();
    //         //  var_dump($_PUT);
    //         if ($result->rowCount() > 0) {
    //             $response = $this->responseObject->Response("200", "Post updated successfully");
    //         } else {
    //             $response = $this->responseObject->Response('404', 'Post not found');
    //         }

    //         return $this->json($response);

    //     } catch (PDOException $e) {
    //         return $this->json([
    //             'status' => 500,
    //             'message' => 'Database error: ' . $e->getMessage()
    //         ]);
    //     } catch (Exception $e) {
    //         return $this->json([
    //             'status' => 400,
    //             'message' => 'Error: ' . $e->getMessage()
    //         ]);
    //     }
    // }

    // public function deleteInvoice($id)
    // {
    //     echo $this->deleteInvoices($id);
    // }

    // private function deleteInvoices($id)
    // {
    //     try {
    //         $bdd = $this->dbManager->getConnection();
    //         $query = 'DELETE FROM invoices where id = :id';
    //         $result = $bdd->prepare($query);
    //         $result->bindParam(':id', $id, PDO::PARAM_INT);
    //         $result->execute();

    //         if ($result->rowCount() > 0) {
    //             $response = $this->responseObject->Response('200', 'Post deleted successfully');
    //         } else {
    //             $response = $this->responseObject->Response('404', 'Post not found');
    //         }

    //         return $this->json($response);

    //     } catch (PDOException $e) {
    //         return $this->json([
    //             'status' => 500,
    //             'message' => 'Database error: ' . $e->getMessage()
    //         ]);
    //     } catch (Exception $e) {
    //         return $this->json([
    //             'status' => 400,
    //             'message' => 'Error: ' . $e->getMessage()
    //         ]);
    //     }
    // }
}
