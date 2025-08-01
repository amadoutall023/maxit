<?php

namespace App\Repository;
use App\Entity\User;
use App\Core\Abstract\AbstractRepository;

use PDO;

class UsersRepository extends AbstractRepository{


    private static UsersRepository|null $instance = null;

    public static function getInstance():UsersRepository{
        if(self::$instance == null){
            self::$instance = new UsersRepository();
        }
        return self::$instance;
    }

    public function __construct(){
        parent::__construct();
    }

    private string $table = '"User"';

    public function selectAll(){}
     public function insert(array $userData){
        $sql = "INSERT INTO $this->table (nom, prenom,login, password, adresse, numeros, numeroCNI, photoIdentite, type_user_id) values (:nom, :prenom, :login, :password, :adresse, :numeros, :numeroCNI, :photoIdentite, :type_user_id)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($userData);
        
        if($result){
            return $this->pdo->lastInsertId();
        }else{
            return false;
        }
     }



     public function selectByLoginAndPassword(string $login, string $passwors): null|User{
        $query = "SELECT * FROM $this->table WHERE login = :login AND password = :password";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'login' => $login,
            'password' => $passwors
        ]);
        
        $result = $stmt->fetch();
        if($result){
            return User::toObject($result);
        }
        return null;
        
    }

    public function selectByLogin(string $login): ?User {
    $query = "SELECT id, nom, prenom, login, password, adresse, numero, numeroCarteIdentite,photoIdentite, typeUser
FROM $this->table WHERE login = :login
";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['login' => $login]);
    $result = $stmt->fetch();
    return $result ? User::toObject($result) : null;
}



     public function update(int $id, array $data){}
     public function delete(int $id){}
     public function selectById(int $id){}
     public function selectBy(array $filter){}

}