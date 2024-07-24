<?php
namespace App\Models;
use PDO;
use DateTime;
use App\Models\DatabaseManager;

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

}