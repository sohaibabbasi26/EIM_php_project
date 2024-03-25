<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
// use Src\Database;
require 'C:\xampp\htdocs\EIM_test\app\config\dbConnection.php';

    class PrayertimeController{

        public function __construct(){
            $this -> pdo = connectToDb();
        }

        public function getAllPrayerTimes(Request $req, Response $res, $args){
            $prayer_times = [];
            if($this->pdo) {
                try{
                    $stmt = $this->pdo->prepare('SELECT * FROM prayer_time');
                    $stmt -> execute();
                    $prayer_times = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                } catch (\PDOException $e){
                    return 'Query Faied:' . $e -> getMessage();
                }
            } else {
                echo 'DATABASE CONNECTION ERROR';
            }

            header('Content-Type: application/json');
            echo json_encode($prayer_times);
        }
    }
?>