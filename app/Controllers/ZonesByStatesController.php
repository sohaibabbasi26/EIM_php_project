<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
// use Src\Database;
require 'C:\xampp\htdocs\EIM_test\app\config\dbConnection.php';

    class ZonesByStatesController{

        public function __construct(){
            $this -> pdo = connectToDb();
        }

        public function getAllZonesByStateId($args){
            $state_id = $args['state_id'];
            $time_zones = [];
            if($this->pdo) {
                try{
                    $stmt = $this->pdo->prepare('SELECT * FROM time_zones WHERE state_id = :state_id');
                    $stmt->bindParam(':state_id', $state_id);
                    $stmt -> execute();
                    $time_zones = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                } catch (\PDOException $e){
                    return 'Query Faied:' . $e -> getMessage();
                }
            } else {
                echo 'DATABASE CONNECTION ERROR';
            }

            header('Content-Type: application/json');
            echo json_encode($time_zones);
        }
    }
?>