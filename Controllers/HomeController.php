<?php

namespace App\Controllers;

use PDO;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Users;
use App\Core\Controller;
use DateTime;

class HomeController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->jsonResponse(['message' => 'Welcome to COGIP API']);
    }

    public function companies()
    {
        $company = new Company();

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

        $filters = [];
        if (isset($_GET['name'])) {
            $filters['name'] = $_GET['name'];
        }
        if (isset($_GET['country'])) {
            $filters['country'] = $_GET['country'];
        }
        if (isset($_GET['created_at'])) {
            $filters['created_at'] = $_GET['created_at'];
        }
        if (isset($_GET['updated_at'])) {
            $filters['updated_at'] = $_GET['updated_at'];
        }
        if (isset($_GET['type_id'])) {
            $filters['type_id'] = $_GET['type_id'];
        }


        $sort = [];
        if (isset($_GET['sort_by'])) {
            $sort[$_GET['sort_by']] = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';
        }

        $fetchAll = isset($_GET['all']) && $_GET['all'] == 'true';

        $companies = $company->getAllCompanies($page, $limit, $filters, $sort, $fetchAll);

        $totalCompanies = $company->getCompaniesCount($filters);


        $response = [
            'data' => $companies,
            'current_page' => $page,
            'total_pages' => ceil($totalCompanies / $limit)
        ];
        return $this->jsonResponse($response);
    }

    public function getCompany($id)
    {
        $company = new Company();
        $companyData = $company->getCompanyById($id);

        if ($companyData) {
            return $this->jsonResponse($companyData);
        } else {
            return $this->jsonResponse(['error' => "Can't find this company !"], 404);
        }
    }

    public function createCompany()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['name']) || !isset($data['type_id']) || !isset($data['country']) || !isset($data['tva'])) {
            return $this->jsonResponse(['error' => 'Invalid input'], 400);
        }

        $company = new Company();
        $data['created_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $result = $company->createCompany($data);
        if ($result) {
            return $this->jsonResponse(['message' => 'Company created !'], 201);
        } else {
            return $this->jsonResponse(['error' => 'Failed to crreate company !'], 500);
        }
    }

    public function updateCompany($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['name']) || !isset($data['type_id']) || !isset($data['country']) || !isset($data['tva'])) {
            return $this->jsonResponse(['error' => 'Invalid input'], 400);
        }

        $company = new Company();
        $result = $company->updateCompany($id, $data);
        if ($result) {
            return $this->jsonResponse(['message' => 'Company updated !'], 200);
        } else {
            return $this->jsonResponse(['error' => 'Failed to update company !'], 500);
        }
    }

    public function deleteCompany($id)
    {
        $company = new Company();
        $result = $company->deleteCompany($id);
        if ($result) {
            return $this->jsonResponse(['message' => 'Company deleted!'], 200);
        } else {
            return $this->jsonResponse(['error' => 'Failed to delete company!'], 500);
        }
    }




    // ------------------------------------------------------




    public function contacts()
    {
        $contact = new Contact();

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

        $filters = [];
        if (isset($_GET['name'])) {
            $filters['name'] = $_GET['name'];
        }
        if (isset($_GET['email'])) {
            $filters['email'] = $_GET['email'];
        }

        $sort = [];
        if (isset($_GET['sort_by'])) {
            $sort[$_GET['sort_by']] = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';
        }

        $fetchAll = isset($_GET['all']) && $_GET['all'] == 'true';

        $contacts = $contact->getAllContacts($page, $limit, $filters, $sort, $fetchAll);
        $totalContacts = $contact->getContactsCount($filters);

        $response = [
            'data' => $contacts,
            'current_page' => $page,
            'total_pages' => ceil($totalContacts / $limit)
        ];

        return $this->jsonResponse($response);
    }

    public function getContact($id)
    {
        $contact = new Contact();
        $contactData = $contact->getContactById($id);

        if ($contactData) {
            return $this->jsonResponse($contactData);
        } else {
            return $this->jsonResponse(['error' => "Can't find this contact"], 404);
        }
    }

    public function createContact()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $contact = new Contact();
        $data['created_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $result = $contact->createContact($data);
        if ($result) {
            return $this->jsonResponse(['message' => 'Contact created !'], 201);
        } else {
            return $this->jsonResponse(['error' => 'Failed to create contact !'], 500);
        }
    }

    public function updateContact($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $contact = new Contact();
        $result = $contact->updateContact($id, $data);
        if ($result) {
            return $this->jsonResponse(['message' => 'Contact updated !'], 200);
        } else {
            return $this->jsonResponse(['error' => 'Failed to update contact !'], 500);
        }
    }

    public function deleteContact($id)
    {
        $contact = new Contact();
        $result = $contact->deleteContact($id);
        if ($result) {
            return $this->jsonResponse(['message' => 'Contact deleted !'], 200);
        } else {
            return $this->jsonResponse(['error' => 'Failed to delete contact !'], 500);
        }
    }



    //---------------------------------------------------------



    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);

            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;

            if ($email && $password) {

                $user = $this->authenticateUser($email, $password);
                if (isset($user['error'])) {
                    return $this->jsonResponse(['error' => $user['error']], 401);
                } else {
                    return $this->jsonResponse(['message' => 'Login successful', 'user' => $user]);
                }
            } else {
                return $this->jsonResponse(['error' => 'Email and password are required !'], 400);
            }
        } else {
            return $this->jsonResponse(['message' => 'Please login']);
        }
    }

    private function isUserLoggedIn()
    {
        // if (session_status() === PHP_SESSION_NONE || isset($_SESSION)) {
        //     session_start();
        // }
        var_dump($_SESSION);
        if (isset($_SESSION['user']['id'])){
            return[
                'status'=> 'success',
                'isAuthenticated'=> true,
                'user' => [
                    'id'=> $_SESSION['user']['id'],
                    'email'=> $_SESSION['user']['email'] ?? null,
                ]
            ];
        } else {
            return [
                'status'=> 'error',
                'isAuthenticated'=> false,
                'message'=> 'User not logged in'
            ];
        }
    }

    public function checkAuth()
    {
        $result= $this->isUserLoggedIn();
        if ($result['isAuthenticated']){
            http_response_code(200);
        }else{
            http_response_code(401);
        }
        return $this->jsonResponse($result);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['firstname']) || !isset($data['lastname']) || !isset($data['email']) || !isset($data['password'])) {
                return $this->jsonResponse(['error' => 'Invalid input'], 422);
            }

            $first_name = $data['firstname'];
            $last_name = $data['lastname'];
            $email = $data['email'];
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $role_id = $data['role_id'] ?? 1;

            $bdd = $this->dbManager->getConnection();
            $query = 'INSERT INTO users (first_name, last_name, email, password, role_id, created_at, updated_at) VALUES (:first_name, :last_name, :email, :password, :role_id, NOW(), NOW())';
            $stmt = $bdd->prepare($query);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role_id', $role_id);

            if ($stmt->execute()) {
                return $this->jsonResponse(['message' => 'User registered successfully'], 201);
            } else {
                return $this->jsonResponse(['error' => 'Error : cant register User'], 500);
            }
        } else {
            return $this->jsonResponse(['message' => 'Please register correctly']);
        }
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

            // session_start();
            $_SESSION['user'] = $user;
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['role'] = $user['role_name'];
            $_SESSION['permissions'] = $permissions;

            var_dump($_SESSION);

            return $user;
        }
        return ['error' => 'Invalid email or password !'];
    }


    /////// Invoices ///////

    public function invoices()
    {
        $invoice = new Invoice();

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

        $filters = [];
        if (isset($_GET['ref'])) {
            $filters['ref'] = $_GET['ref'];
        }
        if (isset($_GET['price'])) {
            $filters['price'] = $_GET['price'];
        }

        $sort = [];
        if (isset($_GET['sort_by'])) {
            $sort[$_GET['sort_by']] = isset($_GET['order']) && strtolower($_GET['order']) === 'desc' ? 'DESC' : 'ASC';
        }

        $fetchAll = isset($_GET['all']) && $_GET['all'] == 'true';

        $invoices = $invoice->getAllInvoices($page, $limit, $filters, $sort, $fetchAll);
        $totalInvoices = $invoice->getInvoicesCount($filters);

        $response = [
            'data' => $invoices,
            'current_page' => $page,
            'total_pages' => ceil($totalInvoices / $limit)
        ];

        return $this->jsonResponse($response);
    }


    public function getInvoice($id)
    {
        $invoice = new Invoice();
        $invoiceData = $invoice->getInvoiceById($id);

        if ($invoiceData) {
            return $this->jsonResponse($invoiceData);
        } else {
            return $this->jsonResponse(['error' => "Can't find this invoice !"], 404);
        }
    }



    public function createInvoice()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['ref']) || !isset($data['price']) || !isset($data['id_company']) ) {
            return $this->jsonResponse(['error' => 'Invalid input'], 400);
        }

        $invoice = new Invoice();
        $data['created_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $result = $invoice->createInvoice($data);
        if ($result) {
            return $this->jsonResponse(['message' => 'Invoice created !'], 201);
        } else {
            return $this->jsonResponse(['error' => 'Failed to create invoice !'], 500);
        }
    }

    public function updateInvoice($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['ref']) || !isset($data['price']) || !isset($data['id_company']) ) {
            return $this->jsonResponse(['error' => 'Invalid input'], 400);
        }

        $invoice = new Invoice();
        $result = $invoice->updateInvoice($id, $data);
        if ($result) {
            return $this->jsonResponse(['message' => 'Invoice updated !'], 200);
        } else {
            return $this->jsonResponse(['error' => 'Failed to update invoice !'], 500);
        }
    }

    public function deleteInvoice($id)
    {
        $invoice = new Invoice();
        $result = $invoice->deleteInvoice($id);
        if ($result) {
            return $this->jsonResponse(['message' => 'invoice deleted!'], 200);
        } else {
            return $this->jsonResponse(['error' => 'Failed to delete invoice!'], 500);
        }
    }




    // USERS -------------------------------------



    public function getUser($id)
    {
        $userModel = new Users();
        $user = $userModel->getUserById($id);
        return $this->jsonResponse($user);
    }

    public function updateUserRole($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['role_id'])) {
            return $this->jsonResponse(['error' => 'Role ID is required'], 400);
        }

        $userModel = new Users();
        $success = $userModel->updateUserRole($id, $data['role_id']);
        if ($success) {
            return $this->jsonResponse(['message' => 'User role updated successfully']);
        } else {
            return $this->jsonResponse(['error' => 'Failed to update user role'], 500);
        }
    }


    protected function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
}


