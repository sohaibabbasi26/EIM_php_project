<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
// use Src\Database;
require 'C:\xampp\htdocs\EIM_test\app\config\dbConnection.php';

class ZonesController {

    public function __construct() {
        $this->pdo = connectToDb();
    }

    public function getAllZones() {
            $zones = []; 
            if ($this->pdo) {
                try {
                    $stmt = $this->pdo->prepare("SELECT * FROM time_zones");
                    $stmt->execute();
                    $zones= $stmt->fetchAll(\PDO::FETCH_ASSOC);
                } catch (\PDOException $e) {
                    return "Query failed: " . $e->getMessage(); 
                }
            } else {
                return "Database connection error"; 
            }
            header('Content-Type: application/json');
            echo json_encode($zones);
    }
}