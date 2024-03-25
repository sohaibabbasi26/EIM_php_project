<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
// use Src\Database;
require 'C:\xampp\htdocs\EIM_test\app\config\dbConnection.php';

class StatesController {

    public function __construct() {
        $this->pdo = connectToDb();
    }

    public function getAllStates() {
            $states = []; 
            if ($this->pdo) {
                try {
                    $stmt = $this->pdo->prepare("SELECT * FROM states");
                    $stmt->execute();
                    $states = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                } catch (\PDOException $e) {
                    return "Query failed: " . $e->getMessage(); 
                }
            } else {
                return "Database connection error"; 
            }

            header('Content-Type: application/json');
            echo json_encode($states);
    }
}