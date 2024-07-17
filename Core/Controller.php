<?php 

namespace App\Core;
use App\Models\Response;
use App\Models\Invoice;
use App\Models\DatabaseManager;
use PDO;

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
                    session_start();
                    $_SESSION['user'] = $user; 
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    //header("Location: /dashboard");
                } else {
                    echo 'Invalid email or password';
                }
            } else {
                echo 'email and password are required';
            }

        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
        }
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
            //header("Location: /login");
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
    public function lastInvoice()
    {
        $query = 'SELECT * FROM invoices ORDER BY created_at DESC LIMIT 5';
        echo $this->getInvoice($query);
    }

    public function allInvoice()
    {
        $query = 'SELECT * FROM invoices';
        echo $this->getInvoice($query);
    }

    public function paginatedInvoices($page, $limit)
{
    // Calculer l'offset
    $offset = ($page - 1) * $limit;
    $query = 'SELECT * FROM invoices LIMIT :limit OFFSET :offset';
    echo $this->getInvoice($query, $limit, $offset);
}

    private function getInvoice($query, $limit = null, $offset = null)
    {
        try {
            $bdd = $this->dbManager->getConnection();
            $result = $bdd->prepare($query);
            if ($limit !== null && $offset !== null) {
                $result->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
                $result->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            }
            $result->execute();
            $rawInvoices = $result->fetchAll(PDO::FETCH_ASSOC);
            
            if ($rawInvoices) {
                foreach ($rawInvoices as $rawInvoice) {
                    $price = (float) $rawInvoice['price'];
                    $invoice = new Invoice(
                    $rawInvoice['id'],
                    $rawInvoice['ref'], 
                    $price,
                    $rawInvoice['id_company'],
                    (new \DateTime($rawInvoice['created_at']))->format('d-m-Y'),
                    (new \DateTime($rawInvoice['update_at']))->format('d-m-Y')
                );
                $invoices [] = $invoice;
                }
                $response = $this->responseObject->ResponseData(200, 'OK', $invoices);
            } else {
                $response = $this->responseObject->Response('404', 'Invoices not found');
            }

        return $json = $this->json($response);

        } catch (PDOException $e) {
            echo 'Erreur de requête : ' . $e->getMessage();
        } catch (Exception $e) {
            echo 'Erreur de conversion en JSON : ' . $e->getMessage();
        }
    }


    
}
