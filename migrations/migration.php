<?php

require_once __DIR__ . '/../vendor/autoload.php';

function prompt(string $message): string {
    echo $message;
    return trim(fgets(STDIN));
}

function writeEnvIfNotExists(): void {
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) {
        $env = <<<ENV
DB_USER=postgres
APP_URL=http://localhost:8001
DB_PASSWORD=password

dsn =pgsql:host=localhost;port=5432;dbname=maxita;

ENV;
        file_put_contents($envPath, $env);
        echo ".env généré avec succès avec les valeurs statiques.\n";
    } else {
        echo "Le fichier .env existe déjà, aucune modification.\n";
    }
}

$driver = strtolower(prompt("Quel SGBD utiliser ? (mysql / pgsql) : "));
if (!in_array($driver, ['mysql', 'pgsql'])) {
    echo "SGBD non supporté. Choisissez 'mysql' ou 'pgsql'.\n";
    exit;
}

$host = prompt("Hôte (default: 127.0.0.1) : ") ?: "127.0.0.1";
$port = prompt("Port (default: 3306 ou 5432) : ") ?: ($driver === 'pgsql' ? "5432" : "3306");
$user = prompt("Utilisateur (default: root) : ") ?: "root";
$pass = prompt("Mot de passe : ");
$dbName = prompt("Nom de la base à créer : ");

try {
    $dsn = "$driver:host=$host;port=$port";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($driver === 'mysql') {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base MySQL `$dbName` créée avec succès.\n";
        $pdo->exec("USE `$dbName`");
    } elseif ($driver === 'pgsql') {
        $check = $pdo->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'")->fetch();
        if (!$check) {
            $pdo->exec("CREATE DATABASE \"$dbName\"");
            echo "Base PostgreSQL `$dbName` créée.\n";
        } else {
            echo "ℹ Base PostgreSQL `$dbName` déjà existante.\n";
        }
    }

    $dsn = "$driver:host=$host;port=$port;dbname=$dbName";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($driver === 'pgsql') {
        // Création des types ENUM PostgreSQL
        $pdo->exec("
            DO \$\$
            BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_user_enum') THEN
                    CREATE TYPE type_user_enum AS ENUM ('client', 'ServiceCommercial');
                END IF;
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_compte_enum') THEN
                    CREATE TYPE type_compte_enum AS ENUM ('ComptePrincipal', 'CompteSecondaire');
                END IF;
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_transaction_enum') THEN
                    CREATE TYPE type_transaction_enum AS ENUM ('Depot', 'Retrait', 'Transfert');
                END IF;
            END
            \$\$;
        ");
    }

    $tables = [];

    if ($driver === 'pgsql') {
        $tables = [
            "CREATE TABLE IF NOT EXISTS \"User\" (
                id SERIAL PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                login VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                typeUser type_user_enum NOT NULL,
                adresse TEXT,
                numero VARCHAR(20),
                numeroCarteIdentite VARCHAR(50),
                photoIdentite TEXT
            );",

            "CREATE TABLE IF NOT EXISTS \"Compte\" (
                id SERIAL PRIMARY KEY,
                numero VARCHAR(50) UNIQUE NOT NULL,
                typeCompte type_compte_enum NOT NULL,
                dateCreation DATE DEFAULT CURRENT_DATE,
                solde NUMERIC(12, 2) DEFAULT 0,
                user_id INTEGER NOT NULL,
                FOREIGN KEY (user_id) REFERENCES \"User\"(id) ON DELETE CASCADE
            );",

            "CREATE TABLE IF NOT EXISTS \"Transaction\" (
                id SERIAL PRIMARY KEY,
                date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                typeTransaction type_transaction_enum NOT NULL,
                montant NUMERIC(12, 2) NOT NULL CHECK (montant > 0),
                user_id INTEGER,
                compte_id INTEGER,
                FOREIGN KEY (user_id) REFERENCES \"User\"(id) ON DELETE SET NULL,
                FOREIGN KEY (compte_id) REFERENCES \"Compte\"(id) ON DELETE SET NULL
            );"
        ];
    } else {
        $tables = [
            "CREATE TABLE IF NOT EXISTS `User` (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                login VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                typeUser VARCHAR(20) NOT NULL CHECK (typeUser IN ('client', 'ServiceCommercial')),
                adresse TEXT,
                numero VARCHAR(20),
                numeroCarteIdentite VARCHAR(50),
                photoIdentite TEXT
            );",

            "CREATE TABLE IF NOT EXISTS `Compte` (
                id INT AUTO_INCREMENT PRIMARY KEY,
                numero VARCHAR(50) UNIQUE NOT NULL,
                typeCompte VARCHAR(20) NOT NULL CHECK (typeCompte IN ('ComptePrincipal', 'CompteSecondaire')),
                dateCreation DATE DEFAULT CURRENT_DATE,
                solde DECIMAL(12, 2) DEFAULT 0,
                user_id INT NOT NULL,
                FOREIGN KEY (user_id) REFERENCES `User`(id) ON DELETE CASCADE
            );",

            "CREATE TABLE IF NOT EXISTS `Transaction` (
                id INT AUTO_INCREMENT PRIMARY KEY,
                date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                typeTransaction VARCHAR(20) NOT NULL CHECK (typeTransaction IN ('Depot', 'Retrait', 'Transfert')),
                montant DECIMAL(12, 2) NOT NULL CHECK (montant > 0),
                user_id INT,
                compte_id INT,
                FOREIGN KEY (user_id) REFERENCES `User`(id) ON DELETE SET NULL,
                FOREIGN KEY (compte_id) REFERENCES `Compte`(id) ON DELETE SET NULL
            );"
        ];
    }

    foreach ($tables as $sql) {
        $pdo->exec($sql);
    }

    echo "Toutes les tables ont été créées avec succès dans `$dbName`.\n";

    // Écriture du fichier .env avec contenu fixe
    writeEnvIfNotExists();

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
