<?php
namespace App\Repository;
use App\Core\Abstract\AbstractRepository;

class TransactionRepository extends AbstractRepository{

    private string $table = 'transaction';

    private static TransactionRepository|null $instance = null;

    public static function getInstance():TransactionRepository{
        if(self::$instance == null){
            self::$instance = new TransactionRepository();
        }
        return self::$instance;
    }

    public function __construct(){
        parent::__construct();
    }

    public function selectAll(){

   }
     public function insert(array $data){}
     public function update(){

     }
     public function delete(){

     }
   public function selectByClient($id_user){
    $sql = "SELECT * FROM transaction WHERE user_id = :id_user  ";
    $stmt = $this->pdo->prepare($sql);
    $result = $stmt->execute(
        ['id_user' => $id_user]
    );
    if($result){
        return $stmt->fetchAll();
    }
    return null;
}
     public function selectBy(array $filter){

     }
  public function selectById(){}
}