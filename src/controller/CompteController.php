<?php

namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Core\App;
use App\Service\CompteService;
use App\Service\TransactionService;

class CompteController extends AbstractController
{
    private CompteService $compteService;
    private TransactionService $transactionService;

    public function __construct()
    {
        parent::__construct();
        $this->compteService = App::get('compteServ');
        $this->transactionService = App::get('transactionServ');
    }

    public function index()
    {
        $user_id = $this->session->get('user')['id'];
        
        $transactions = $this->transactionService->getTransactionsByUserId($user_id);
        $comptes = App::get('compteRepo')->selectByClient($user_id);
         $mescomptes =  $this->session->set('comptes', $comptes);
        $soldeTotal = $this->transactionService->obtenirSoldeTotal($user_id);
        
     $this->render("compte/home.php", [
    'transactions' => $transactions, // tableau de transactions
    'comptes' => $comptes,           // tableau de comptes
    'soldeTotal' => $soldeTotal
]);
    }

    public function create()
    {
        $this->layout = 'security';
        $this->render('compte/form.principal.php');
    }

    public function createCompteEpargne()
    {
        // À compléter selon vos besoins (affichage d'un formulaire, etc.)
        $this->layout = 'security';
        $this->render('compte/form2.php');
    }
    public function liteComptesSecondaires(){
    $this->layout = 'security';
    $this->render('compte/liste.php');
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $this->session->get('user')['id'];
            $type_compte = $_POST['type_compte'] ?? 'courant';
            $solde_initial = (float)($_POST['solde_initial'] ?? 0);

            // Générer un numéro de compte unique
            $numero_compte = App::get('compteRepo')->genererNumeroCompte();

            $data = [
                'user_id' => $user_id,
                'numero' => $numero,
                'solde' => $solde_initial,
                'type_compte' => $type_compte,
                'statut' => 'actif'
            ];

            $compte_id = App::get('compteRepo')->insert($data);

            if ($compte_id) {
                // Si il y a un solde initial, créer une transaction de dépôt
                if ($solde_initial > 0) {
                    $this->transactionService->effectuerDepot($compte_id, $solde_initial, 'Dépôt initial');
                }
                
                $this->session->set('success', 'Compte créé avec succès. Numéro: ' . $numero_compte);
                header('Location: /compte');
            } else {
                $this->session->set('error', 'Erreur lors de la création du compte');
                header('Location: /compte/create');
            }
        }
    }

    public function show()
    {
        $compte_id = $_GET['id'] ?? null;
        if (!$compte_id) {
            header('Location: /compte');
            return;
        }

        $compte = App::get('compteRepo')->selectById($compte_id);
        if (!$compte) {
            $this->session->set('error', 'Compte introuvable');
            header('Location: /compte');
            return;
        }

        // Vérifier que le compte appartient à l'utilisateur connecté
        $user_id = $this->session->get('user')['id'];
        if ($compte->getUserId() !== $user_id) {
            $this->session->set('error', 'Accès non autorisé');
            header('Location: /compte');
            return;
        }

        $this->render('compte/show.php', ['compte' => $compte]);
    }

    public function depot()
    {
        header('Location: /transaction/depot');
    }

    public function transfert()
    {
        header('Location: /transaction/transfert');
    }

    public function edit()
    {
        // Implementation pour modifier un compte
    }

// ...existing code...
public function storeEpargne()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $this->session->get('user')['id'];
        $numero = $_POST['numero'] ?? null;
        $solde = (float)($_POST['solde'] ?? 0);

        if (!$numero) {
            $this->session->set('error', 'Le numéro est obligatoire');
            header('Location: /addCompte');
            return;
        }

        $data = [
            'user_id' => $user_id,
            'numero' => $numero,
            'typeCompte' => 'CompteSecondaire', // <-- valeur ENUM attendue
            'solde' => $solde
        ];

        $compte_id = App::get('compteRepo')->insert($data);

        if ($compte_id) {
            if ($solde > 0) {
                $this->transactionService->effectuerDepot($compte_id, $solde, 'Dépôt initial épargne');
            }
            $this->session->set('success', 'Compte épargne créé avec succès.');
            header('Location: /compte');
        } else {
            $this->session->set('error', 'Erreur lors de la création du compte épargne');
            header('Location: /addCompte');
        }
    }
}
// ...existing code...
}
