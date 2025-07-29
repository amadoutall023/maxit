<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/bootstrap.php';

use App\Core\App;
use App\Repository\UsersRepository;
use App\Repository\CompteRepository;
use App\Repository\TransactionRepository;

// Initialiser l'application
App::init();

echo "🌱 Début du seeding de la base de données...\n\n";

try {
    $userRepo = App::get('usersRepo');
    $compteRepo = App::get('compteRepo');
    $transactionRepo = App::get('transactionRepo');

    // Données utilisateurs de test
    $users = [
        [
            'nom' => 'Diallo',
            'prenom' => 'Amadou',
            'login' => 'amadou.diallo',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'typeUser' => 'client',
            'adresse' => 'Dakar, Sénégal',
            'numero' => '+221701234567',
            'numeroCarteIdentite' => 'CNI001234567',
            'photoIdentite' => null
        ],
        [
            'nom' => 'Fall',
            'prenom' => 'Fatou',
            'login' => 'fatou.fall',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'typeUser' => 'client',
            'adresse' => 'Thiès, Sénégal',
            'numero' => '+221709876543',
            'numeroCarteIdentite' => 'CNI009876543',
            'photoIdentite' => null
        ],
        [
            'nom' => 'Ndiaye',
            'prenom' => 'Omar',
            'login' => 'omar.ndiaye',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'typeUser' => 'ServiceCommercial',
            'adresse' => 'Saint-Louis, Sénégal',
            'numero' => '+221705555555',
            'numeroCarteIdentite' => 'CNI005555555',
            'photoIdentite' => null
        ]
    ];

    // Insérer les utilisateurs
    $userIds = [];
    foreach ($users as $userData) {
        $userId = $userRepo->insert($userData);
        if ($userId) {
            $userIds[] = $userId;
            echo "✅ Utilisateur créé: {$userData['prenom']} {$userData['nom']} (ID: $userId)\n";
        } else {
            echo "❌ Erreur lors de la création de l'utilisateur {$userData['prenom']} {$userData['nom']}\n";
        }
    }

    echo "\n";

    // Créer des comptes pour les utilisateurs clients
    $compteIds = [];
    foreach ($userIds as $index => $userId) {
        if ($users[$index]['typeUser'] === 'client') {
            // Générer un numéro de compte unique
            $numeroCompte = 'CMP' . str_pad($userId, 6, '0', STR_PAD_LEFT);
            
            $compteData = [
                'user_id' => $userId,
                'numero' => $numeroCompte,
                'typeCompte' => 'ComptePrincipal',
                'solde' => rand(50000, 500000) // Solde aléatoire entre 50k et 500k
            ];

            $compteId = $compteRepo->insert($compteData);
            if ($compteId) {
                $compteIds[$userId] = $compteId;
                echo "✅ Compte créé: {$numeroCompte} pour {$users[$index]['prenom']} {$users[$index]['nom']} (Solde: {$compteData['solde']} FCFA)\n";
            } else {
                echo "❌ Erreur lors de la création du compte pour {$users[$index]['prenom']} {$users[$index]['nom']}\n";
            }
        }
    }

    echo "\n";

    // Créer des transactions de test
    $transactions = [
        [
            'user_id' => $userIds[0],
            'compte_id' => $compteIds[$userIds[0]] ?? null,
            'montant' => 25000,
            'typeTransaction' => 'Depot'
        ],
        [
            'user_id' => $userIds[0],
            'compte_id' => $compteIds[$userIds[0]] ?? null,
            'montant' => 15000,
            'typeTransaction' => 'Retrait'
        ],
        [
            'user_id' => $userIds[1],
            'compte_id' => $compteIds[$userIds[1]] ?? null,
            'montant' => 50000,
            'typeTransaction' => 'Depot'
        ],
        [
            'user_id' => $userIds[1],
            'compte_id' => $compteIds[$userIds[1]] ?? null,
            'montant' => 30000,
            'typeTransaction' => 'Transfert'
        ]
    ];

    foreach ($transactions as $transactionData) {
        if ($transactionData['compte_id']) {
            $transactionId = $transactionRepo->insert($transactionData);
            if ($transactionId) {
                echo "✅ Transaction créée: {$transactionData['typeTransaction']} de {$transactionData['montant']} FCFA (ID: $transactionId)\n";
            } else {
                echo "❌ Erreur lors de la création de la transaction\n";
            }
        }
    }

    echo "\n🎉 Seeding terminé avec succès!\n";
    echo "\n📋 Comptes de connexion:\n";
    echo "- Login: amadou.diallo | Password: password123\n";
    echo "- Login: fatou.fall | Password: password123\n";
    echo "- Login: omar.ndiaye | Password: password123 (Service Commercial)\n";

} catch (Exception $e) {
    echo "❌ Erreur lors du seeding: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
