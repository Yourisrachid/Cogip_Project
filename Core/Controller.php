<?php 

namespace App\Core;
use App\Models\DatabaseManager;
use PDO;

class Controller 
{
    private $dbManager;
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
                    print_r($user);
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
