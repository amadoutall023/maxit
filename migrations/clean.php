<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/bootstrap.php';

use App\Core\App;

// Initialiser l'application
App::init();

echo "🧹 Nettoyage de la base de données...\n";

try {
    $pdo = \App\Core\Database::getInstance()->getConnection();

    // Supprimer les données dans l'ordre des dépendances
    $tables = ['"Transaction"', '"Compte"', '"User"'];
    
    foreach ($tables as $table) {
        $sql = "DELETE FROM $table";
        $pdo->exec($sql);
        echo "✅ Table $table vidée\n";
    }

    // Reset des séquences pour PostgreSQL
    $sequences = ['"User_id_seq"', '"Compte_id_seq"', '"Transaction_id_seq"'];
    
    foreach ($sequences as $sequence) {
        $sql = "ALTER SEQUENCE $sequence RESTART WITH 1";
        $pdo->exec($sql);
        echo "✅ Séquence $sequence réinitialisée\n";
    }

    echo "\n🎉 Base de données nettoyée avec succès!\n";

} catch (Exception $e) {
    echo "❌ Erreur lors du nettoyage: " . $e->getMessage() . "\n";
}
