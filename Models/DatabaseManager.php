<?php
namespace App\Models;
use PDO;

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
            $this->bdd = new PDO('mysql:host=localhost;dbname=cogip;charset=utf8', 'becode', 'becode');
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