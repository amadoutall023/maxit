<?php

namespace App\Core;

use \PDO;
use \PDOException;

class Database{
    
    private $connection;
    private  static $instance = null;

      private function __construct() {


$user ='postgres';
        $password = 'EFVZsJafxazeGwjcWjEIamIonOLNJUCm';
        $dsn = 'pgsql:host=34.1.231.146;port=29546;dbname=railway';


        try {
           
            $this->connection = new PDO(
              $dsn,
              $user ,
              $password,
              [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
              ]
              );

             
        }catch(PDOException $e){
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection():PDO{
        return $this->connection;
    }


    
}
