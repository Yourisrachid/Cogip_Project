<?php 

namespace App\Core;
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

}


// temporairement ici !
class DatabaseManager
{
    private $bdd;

    public function __construct()
    {
        $this->connectDatabase();
    }

    private function connectDatabase()
    {
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=cogip;charset=utf8', 'youris', 'youris');
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        
    }

    public function getConnection()
    {
        return $this->bdd;
    }
}
