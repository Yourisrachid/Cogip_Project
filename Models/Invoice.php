<?php
namespace App\Models;

use PDO;
use DateTime;
use App\Models\DatabaseManager;

class Invoice
{
    private $table = 'invoices';
    private $conn;
    public function __construct()
    {
        $database = new DatabaseManager();
        $this->conn = $database->getConnection();
    }

    public function formatPublishDate($format = 'Y-m-d\TH:i:s\Z', $dateType = 'created_at')
    {
        if ($this->$dateType) {
            $dateTime = new DateTime($this->$dateType);
            return $dateTime->format($format);
        }
        return null;
    }

    public function getAllInvoices($page = 1, $limit = 10, $filters = [], $sort = [], $fetchAll = false)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE 1=1';

        foreach ($filters as $key => $value) {
            $query .= ' AND ' . $key . ' = :' . $key;
        }

        if (!empty($sort)) {
            $query .= ' ORDER BY ' . implode(', ', array_map(function ($key, $value) {
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

    public function getInvoiceById($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function createInvoice($data)
    {
        $query = 'INSERT INTO ' . $this->table . ' (ref, price, id_company, created_at, updated_at) VALUES (:ref, :price, :id_company, :created_at, :updated_at)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ref', $data['ref']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':id_company', $data['id_company']);
        $stmt->bindParam(':created_at', $data['created_at']);
        $stmt->bindParam(':updated_at', $data['created_at']);
        return $stmt->execute();
    }

    public function updateInvoice($id, $data)
    {
        $query = 'UPDATE ' . $this->table . ' SET ref = :ref, price = :price, id_company = :id_company, created_at = :created_at, updated_at = :updated_at WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':ref', $data['ref']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':id_company', $data['id_company']);
        $stmt->bindParam(':created_at', $data['created_at']);
        $stmt->bindParam(':updated_at', $data['updated_at']);
        return $stmt->execute();
    }



    public function deleteInvoice($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getInvoicesCount($filters = []) {
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
}
