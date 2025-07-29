<?php

namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Core\App;
use App\Service\TransactionService;

class TransactionController extends AbstractController
{
    private TransactionService $transactionService;

    public function __construct()
    {
        parent::__construct();
        $this->transactionService = App::get('transactionServ');
    }

    public function depot()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $compte_id = $_POST['compte_id'] ?? null;
            $montant = (float)($_POST['montant'] ?? 0);
            $description = $_POST['description'] ?? null;

            if (!$compte_id || $montant <= 0) {
                $this->session->set('error', 'Données invalides');
                header('Location: /transaction/depot');
                return;
            }

            $success = $this->transactionService->effectuerDepot($compte_id, $montant, $description);
            
            if ($success) {
                $this->session->set('success', 'Dépôt effectué avec succès');
            } else {
                $this->session->set('error', 'Erreur lors du dépôt');
            }
            
            header('Location: /compte');
        } else {
            $user_id = $this->session->get('user')['id'];
            $comptes = App::get('compteRepo')->selectByClient($user_id);
            $this->render('transaction/depot.php', ['comptes' => $comptes]);
        }
    }

    public function transfert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $compte_expediteur_id = $_POST['compte_expediteur_id'] ?? null;
            $compte_destinataire_numero = $_POST['compte_destinataire_numero'] ?? null;
            $montant = (float)($_POST['montant'] ?? 0);
            $description = $_POST['description'] ?? null;

            if (!$compte_expediteur_id || !$compte_destinataire_numero || $montant <= 0) {
                $this->session->set('error', 'Données invalides');
                header('Location: /transaction/transfert');
                return;
            }

            // Récupérer le compte expéditeur pour validation
            $compteExpediteur = App::get('compteRepo')->selectById($compte_expediteur_id);
            if (!$compteExpediteur) {
                $this->session->set('error', 'Compte expéditeur invalide');
                header('Location: /transaction/transfert');
                return;
            }

            $success = $this->transactionService->effectuerTransfertParNumero(
                $compteExpediteur->getNumeroCompte(),
                $compte_destinataire_numero,
                $montant,
                $description
            );
            
            if ($success) {
                $this->session->set('success', 'Transfert effectué avec succès');
            } else {
                $this->session->set('error', 'Erreur lors du transfert');
            }
            
            header('Location: /compte');
        } else {
            $user_id = $this->session->get('user')['id'];
            $comptes = App::get('compteRepo')->selectByClient($user_id);
            $this->render('transaction/transfert.php', ['comptes' => $comptes]);
        }
    }

    public function historique()
    {
        $user_id = $this->session->get('user')['id'];
        $type = $_GET['type'] ?? null;
        $limit = (int)($_GET['limit'] ?? 50);
        
        $transactions = $this->transactionService->obtenirHistoriqueTransactions($user_id, $type, $limit);
        $soldeTotal = $this->transactionService->obtenirSoldeTotal($user_id);
        
        $this->render('transaction/historique.php', [
            'transactions' => $transactions,
            'soldeTotal' => $soldeTotal,
            'typeFiltre' => $type
        ]);
    }

    public function annuler()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $transaction_id = (int)($_POST['transaction_id'] ?? 0);
            
            if (!$transaction_id) {
                $this->session->set('error', 'ID de transaction invalide');
                header('Location: /transaction/historique');
                return;
            }

            $success = $this->transactionService->annulerTransaction($transaction_id);
            
            if ($success) {
                $this->session->set('success', 'Transaction annulée avec succès');
            } else {
                $this->session->set('error', 'Erreur lors de l\'annulation');
            }
        }
        
        header('Location: /transaction/historique');
    }
    
// ...exising code...


// ...existing code...
}
