<?php
namespace App\Models;
use App\Models\DatabaseManager;
use PDO;

class Users
{
    private $table = 'users';
    private $dbManager;

    public function __construct()
    {
        $this->dbManager = new DatabaseManager();
    }

    public function formatPublishDate($format = 'Y-m-d\TH:i:s\Z', $dateType = 'created_at')
    {
        if ($this->$dateType) {
            $dateTime = new DateTime($this->$dateType);
            return $dateTime->format($format);
        }
        return null;
    }

    public function getAllUser($page = 1, $limit = 10, $filters = [], $sort = [], $fetchAll = false) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE 1=1';

        foreach ($filters as $key => $value) {
            $query .= ' AND ' . $key . ' = :' . $key;
        }

        if (!empty($sort)) {
            $query .= ' ORDER BY ' . implode(', ', array_map(function($key, $value) {
                return $key . ' ' . $value;
            }, array_keys($sort), $sort));
        }

        if (!$fetchAll) {
            $offset = ($page - 1) * $limit;
            $query .= ' LIMIT :limit OFFSET :offset';
        }

        $bdd = $this->dbManager->getConnection();
        $stmt = $bdd->prepare($query);

        foreach ($filters as $key => $value) {
            $stmt->bindParam(':' . $key, $value);
        }

        if (!$fetchAll) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
           
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $bdd = $this->dbManager->getConnection();
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*public function updateUser($id, $data) {
        try {
            $bdd = $this->dbManager->getConnection();
            $query = 'UPDATE ' . $this->table . ' SET role_id = :role_id, first_name = :first_name, last_name = :last_name, email = :email ';
            $stmt = $bdd->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':role_id', $data['role_id'], PDO::PARAM_INT);
            $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);            
            return $stmt->execute();
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        } catch (Exception $e) {
            return [
                'status' => 400,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }*/
}