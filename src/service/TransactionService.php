<?php
namespace App\Service;
use App\Repository\CompteRepository;
use App\Repository\UsersRepository;
use App\Core\App;

class TransactionService{
    private CompteRepository $compteRepository;
    private UsersRepository $userRepository;
    private static TransactionService|null $instance = null;


    public static function getInstance(): TransactionService {
        if (self::$instance == null) {
            self::$instance = new TransactionService();
        }
        return self::$instance;
    }
    public function __construct(){
        $this->compteRepository = App::getDependency('repositories', 'compteRepo');
        $this->userRepository = App::getDependency('repositories', 'usersRepo');
        $this->transactionRepository = App::getDependency('repositories', 'transactionRepo');
    }
    public function getTransactionsByUserId($id_user){
        return $this->transactionRepository->selectByClient($id_user);
    }
}