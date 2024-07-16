<?php

namespace App\Models;

use App\Core\DatabaseManager;
use PDO;

class Company {
    private $conn;
    private $table = 'companies';

    public function __construct() {
        $database = new DatabaseManager();
        $this->conn = $database->getConnection();
    }


    /*
        ** GET companies
        ** Fetch all companies : localhost:8000/companies?all=true
        ** Fetch page 2 : localhost:8000/companies?page=2           -> 11-20
        ** filter by ->  name:  Filter by name   // country:  Filter by country
        ** sort_by: sort by ...... (ex : name)
        ** order: sorting order (asc or desc)
    */

    public function getAllCompanies($page = 1, $limit = 10, $filters = [], $sort = [], $fetchAll = false) {
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

    /*
        ** GET companies
        ** Fetch companie by id : localhost:8000/companies/2
        ** fetch(`http://localhost:8000/companies/${id}`);
    */

    public function getCompanyById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCompany($data) {
        $query = 'INSERT INTO ' . $this->table . ' (name, type_id, country, tva) VALUES (:name, :type_id, :country, :tva)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':type_id', $data['type_id']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':tva', $data['tva']);
        return $stmt->execute();
    }

    public function updateCompany($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET name = :name, type_id = :type_id, country = :country, tva = :tva WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':type_id', $data['type_id']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':tva', $data['tva']);
        return $stmt->execute();
    }

    public function deleteCompany($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
