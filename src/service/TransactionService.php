<?php

namespace App\Service;

use App\Repository\CompteRepository;
use App\Repository\TransactionRepository;
use App\Entity\Transaction;
use App\Entity\Compte;
use App\Core\App;

class TransactionService
{
    private CompteRepository $compteRepository;
    private TransactionRepository $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = App::get('transactionRepo');
        $this->compteRepository = App::get('compteRepo');
    }

    public function getTransactionsByUserId(int $id_user): array
    {
        return $this->transactionRepository->selectByClient($id_user);
    }

    public function effectuerDepot(int $compte_id, float $montant, ?string $description = null): bool
    {
        try {
            // Validation
            if ($montant <= 0) {
                throw new \InvalidArgumentException('Le montant doit être positif');
            }

            // Récupérer le compte
            $compte = $this->compteRepository->selectById($compte_id);
            if (!$compte) {
                throw new \Exception('Compte introuvable');
            }

            if ($compte->getStatut() !== 'actif') {
                throw new \Exception('Le compte n\'est pas actif');
            }

            // Démarrer une transaction
            App::get('database')->getConnection()->beginTransaction();

            try {
                // Créer la transaction
                $transactionId = $this->transactionRepository->createDepot($compte_id, $montant, $description);
                
                if (!$transactionId) {
                    throw new \Exception('Erreur lors de la création de la transaction');
                }

                // Mettre à jour le solde
                $compte->crediter($montant);
                $this->compteRepository->updateSolde($compte_id, $compte->getSolde());

                // Valider la transaction
                App::get('database')->getConnection()->commit();
                return true;

            } catch (\Exception $e) {
                App::get('database')->getConnection()->rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            error_log("Erreur lors du dépôt: " . $e->getMessage());
            return false;
        }
    }

    public function effectuerTransfert(int $compte_expediteur_id, int $compte_destinataire_id, float $montant, ?string $description = null): bool
    {
        try {
            // Validation
            if ($montant <= 0) {
                throw new \InvalidArgumentException('Le montant doit être positif');
            }

            if ($compte_expediteur_id === $compte_destinataire_id) {
                throw new \InvalidArgumentException('Les comptes expéditeur et destinataire doivent être différents');
            }

            // Récupérer les comptes
            $compteExpediteur = $this->compteRepository->selectById($compte_expediteur_id);
            $compteDestinataire = $this->compteRepository->selectById($compte_destinataire_id);

            if (!$compteExpediteur || !$compteDestinataire) {
                throw new \Exception('Un ou plusieurs comptes sont introuvables');
            }

            if (!$compteExpediteur->peutDebiter($montant)) {
                throw new \Exception('Solde insuffisant ou compte inactif');
            }

            if ($compteDestinataire->getStatut() !== 'actif') {
                throw new \Exception('Le compte destinataire n\'est pas actif');
            }

            // Démarrer une transaction
            App::get('database')->getConnection()->beginTransaction();

            try {
                // Créer la transaction
                $transactionId = $this->transactionRepository->createTransfert(
                    $compte_expediteur_id, 
                    $compte_destinataire_id, 
                    $montant, 
                    $description
                );
                
                if (!$transactionId) {
                    throw new \Exception('Erreur lors de la création de la transaction');
                }

                // Débiter le compte expéditeur
                $compteExpediteur->debiter($montant);
                $this->compteRepository->updateSolde($compte_expediteur_id, $compteExpediteur->getSolde());

                // Créditer le compte destinataire
                $compteDestinataire->crediter($montant);
                $this->compteRepository->updateSolde($compte_destinataire_id, $compteDestinataire->getSolde());

                // Compléter la transaction
                $this->transactionRepository->completerTransaction($transactionId);

                // Valider la transaction
                App::get('database')->getConnection()->commit();
                return true;

            } catch (\Exception $e) {
                App::get('database')->getConnection()->rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            error_log("Erreur lors du transfert: " . $e->getMessage());
            return false;
        }
    }

    public function effectuerTransfertParNumero(string $numero_expediteur, string $numero_destinataire, float $montant, ?string $description = null): bool
    {
        try {
            // Récupérer les comptes par numéro
            $compteExpediteur = $this->compteRepository->findByNumeroCompte($numero_expediteur);
            $compteDestinataire = $this->compteRepository->findByNumeroCompte($numero_destinataire);

            if (!$compteExpediteur || !$compteDestinataire) {
                throw new \Exception('Un ou plusieurs numéros de compte sont invalides');
            }

            return $this->effectuerTransfert(
                $compteExpediteur->getId(),
                $compteDestinataire->getId(),
                $montant,
                $description
            );

        } catch (\Exception $e) {
            error_log("Erreur lors du transfert par numéro: " . $e->getMessage());
            return false;
        }
    }

    public function obtenirHistoriqueTransactions(int $user_id, ?string $type = null, int $limit = 50): array
    {
        $transactions = $this->transactionRepository->selectByClient($user_id);
        
        if ($type) {
            $transactions = array_filter($transactions, function($transaction) use ($type) {
                return $transaction->getType() === $type;
            });
        }

        return array_slice($transactions, 0, $limit);
    }

    public function obtenirSoldeTotal(int $user_id): float
    {
        $comptes = $this->compteRepository->selectByClient($user_id);
        $soldeTotal = 0;

        foreach ($comptes as $compte) {
            if ($compte->getStatut() === 'actif') {
                $soldeTotal += $compte->getSolde();
            }
        }

        return $soldeTotal;
    }

    public function annulerTransaction(int $transaction_id): bool
    {
        try {
            $transaction = $this->transactionRepository->selectById($transaction_id);
            
            if (!$transaction) {
                throw new \Exception('Transaction introuvable');
            }

            if ($transaction->getStatut() !== 'en_attente') {
                throw new \Exception('Seules les transactions en attente peuvent être annulées');
            }

            return $this->transactionRepository->annulerTransaction($transaction_id);

        } catch (\Exception $e) {
            error_log("Erreur lors de l'annulation: " . $e->getMessage());
            return false;
        }
    }
}