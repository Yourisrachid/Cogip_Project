<?php

namespace App\Models;
use PDO;

class Contact {
    private $conn;
    private $table = 'contacts';

    public function __construct() {
        $database = new DatabaseManager();
        $this->conn = $database->getConnection();
    }


    /*
        ** GET contacts
        ** Fetch all companies : localhost:8000/contacts?all=true
        ** Fetch page 2 and limit to 5 : localhost:8000/contacts?page=2&limit=5           -> 11-20
        ** filter by ->  name:  Filter by name   // company_id:  Filter by company_id
        ** sort_by: sort by ...... (ex : name)
        ** order: sorting order (asc or desc)
    */



    public function getAllContacts($page = 1, $limit = 10, $filters = [], $sort = [], $fetchAll = false) {
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

        $stmt = $this->conn->prepare($query);


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

    public function getContactsCount($filters = []) {
        $query = 'SELECT COUNT(*) as count FROM ' . $this->table . ' WHERE 1=1';

        foreach ($filters as $key => $value) {
            $query .= ' AND ' . $key . ' = :' . $key;
        }

        $stmt = $this->conn->prepare($query);

        foreach ($filters as $key => $value) {
            $stmt->bindParam(':' . $key, $value);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }



    /*
        ** GET contacts
        ** Fetch contact by id : localhost:8000/contacts/2
        ** fetch(`http://localhost:8000/contacts/${id}`);
    */



    public function getContactById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createContact($data) {
        $query = 'INSERT INTO ' . $this->table . ' (name, company_id, email, phone) VALUES (:name, :company_id, :email, :phone)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':company_id', $data['company_id']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        return $stmt->execute();
    }

    public function updateContact($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET name = :name, company_id = :company_id, email = :email, phone = :phone WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':company_id', $data['company_id']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        return $stmt->execute();
    }

    public function deleteContact($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
