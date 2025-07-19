<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $dsn = $_ENV['dsn'] ?? "{$_ENV['DB_DRIVER']}:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}";
    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données\n";
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}

try {
    $pdo->beginTransaction();

    // 1. Users (clients)
    $clients = [
        ['demba', 'fall', '770000001', 'client', 'Dakar Liberté 6', 'CNI001', 'recto1.png'],
        ['ahmet', 'mater', '770000002', 'client', 'Dakar Médina', 'CNI002', 'recto2.png'],
        ['zz', 'xx', '770000003', 'client', 'Rufisque', 'CNI003', 'recto3.png'],
        ['modou', 'Sagnane', '770000004', 'client', 'Ziguinchor', 'CNI004', 'recto4.png'],
        ['fallou', 'Thiam', '770000005', 'client', 'Kaolack', 'CNI005', 'recto5.png'],
        ['saly', 'Sow', '770000006', 'client', 'Touba', 'CNI006', 'recto6.png'],
    ];

    $stmtUser = $pdo->prepare("INSERT INTO \"User\" (nom, prenom, login, typeUser, adresse, numeroCarteIdentite, photoIdentite, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $userIds = [];
    foreach ($clients as $client) {
        $stmtUser->execute([...$client, password_hash('passer123', PASSWORD_BCRYPT)]);
        $userIds[] = $pdo->lastInsertId();
    }
    echo "Utilisateurs insérés\n";

    // 2. Comptes
    $stmtCompte = $pdo->prepare("INSERT INTO \"Compte\" (numero, typeCompte, solde, user_id) VALUES (?, ?, ?, ?)");
    $compteIds = [];
    foreach ($clients as $index => $client) {
        $stmtCompte->execute([$client[2], 'ComptePrincipal', rand(20000, 150000), $userIds[$index]]);
        $compteIds[] = $pdo->lastInsertId();
    }
    echo "Comptes insérés\n";

    // 3. Service Commercial (utilisateur)
    $stmtSC = $pdo->prepare("INSERT INTO \"User\" (nom, prenom, login, password, typeUser) VALUES (?, ?, ?, ?, ?)");
    $stmtSC->execute(['Admin', 'SC', 'admin@maxitsa.sn', password_hash('passer123', PASSWORD_BCRYPT), 'ServiceCommercial']);
    echo "Service commercial inséré\n";

    // 4. Transactions
    $transactions = [
        ['2025-07-18 12:00:00', 'Transfert', 10000, $userIds[0], $compteIds[0]],
        ['2025-07-18 14:00:00', 'Retrait', 5000, $userIds[1], $compteIds[1]],
        ['2025-07-18 15:00:00', 'Depot', 20000, $userIds[2], $compteIds[2]],
        ['2025-07-18 16:00:00', 'Transfert', 15000, $userIds[3], $compteIds[3]],
        ['2025-07-18 17:00:00', 'Retrait', 10000, $userIds[4], $compteIds[4]],
    ];
    $stmtTrx = $pdo->prepare("INSERT INTO \"Transaction\" (date, typeTransaction, montant, user_id, compte_id) VALUES (?, ?, ?, ?, ?)");
    foreach ($transactions as $trx) {
        $stmtTrx->execute($trx);
    }
    echo "Transactions insérées\n";

    $pdo->commit();
    echo "Toutes les données ont été insérées avec succès dans une transaction.\n";

} catch (PDOException $e) {
    $pdo->rollBack();
    die("Erreur lors de l'insertion des données : " . $e->getMessage());
}
