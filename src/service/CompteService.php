<?php
namespace App\Service;
use App\Repository\CompteRepository;
use App\Repository\UsersRepository;
use App\Core\App;

class CompteService{
    private CompteRepository $compteRepository;
    private UsersRepository $userRepository;
    private static CompteService|null $instance = null;


    public static function getInstance(): CompteService {
        if (self::$instance == null) {
            self::$instance = new CompteService();
        }
        return self::$instance;
    }
    public function __construct(){
        $this->compteRepository = App::getDependency('repositories', 'compteRepo');
        $this->userRepository = App::getDependency('repositories', 'usersRepo');
    }

//     public function creerComptePrincipal(array $userData, array $compteData): bool|string {
//     $existing = $this->compteRepository->findPrincipalByUserId($userData['id_user'] ?? 0);
//     if ($existing) return "Un compte principal existe déjà pour cet utilisateur.";

//     $userId = $this->userRepository->insert($userData);
    
//     $numeroCompte = "CPR-" . time();

//     $compteData['numero'] = $numeroCompte;
//     $compteData['typeCompte'] = "Principal";
//     $compteData['solde'] = 0;
//     $compteData['dateCreation'] = date('Y-m-d');
//     $compteData['id_user'] = $userId;

//     return $this->compteRepository->insert($compteData);
// }
public function creerComptePrincipal(array $userData, $numeroTelephone): bool|string {
        $existingNumero = $this->telephoneRepository->findByNumero($numeroTelephone);
        if ($existingNumero) {
            return "Ce numéro de téléphone est déjà associé à un compte.";
        }

        $this->pdo->beginTransaction();

        try {
            $userId = $this->userRepository->insert($userData);
            if (!$userId) {
                throw new Exception("Erreur lors de la création de l'utilisateur.");
            }

            $numeroCompte = "CPR-" . time();
            $compteData = [
                'numero' => $numeroCompte,
                'typeCompte' => 'Principal',
                'solde' => 0,
                'dateCreation' => date('Y-m-d'),
                'id_user' => $userId
            ];

            $compteId = $this->compteRepository->insert($compteData);
            if (!$compteId) {
                throw new Exception("Erreur lors de la création du compte.");
            }

            $numeroData = [
                'numero' => $numeroTelephone,
                'user_id' => $userId,
                'compte_id' => $compteId
            ];

            $numeroCreated = $this->telephoneRepository->insert($numeroData);
            if (!$numeroCreated) {
                throw new Exception("Erreur lors de l'association du numéro de téléphone.");
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return "Erreur : " . $e->getMessage();
        }
    }
    public function getCompteByUserId($userId){
        return $this->compteRepository->selectByClient($userId);
    }
 


}