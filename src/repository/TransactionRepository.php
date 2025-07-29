<?php

namespace App\Repository;

use \PDO;
use App\Core\App;
use App\Entity\Transaction;
use App\Core\Abstract\AbstractRepository;

class TransactionRepository extends AbstractRepository
{
    private string $table = '"Transaction"';

    public function __construct()
    {
        parent::__construct();
    }

    public function selectAll(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY date_creation DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $transactions = [];
        while ($row = $stmt->fetch()) {
            $transactions[] = Transaction::toObject($row);
        }
        return $transactions;
    }

    public function insert(array $data)
    {
        $sql = "INSERT INTO {$this->table} 
                (user_id, compte_id, montant, typetransaction) 
                VALUES (:user_id, :compte_id, :montant, :typeTransaction)";
        
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            'user_id' => $data['user_id'],
            'compte_id' => $data['compte_id'],
            'montant' => $data['montant'],
            'typeTransaction' => $data['typeTransaction']
        ]);
        
        return $result ? $this->pdo->lastInsertId() : null;
    }

    public function update(int $id, array $data)
    {
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[$key] = $value;
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function selectByClient(int $id_user): array
    {
        $sql = "SELECT t.* FROM {$this->table} t
                WHERE t.user_id = :id_user
                ORDER BY t.date DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_user' => $id_user]);
        
        $transactions = [];
        while ($row = $stmt->fetch()) {
            $transactions[] = Transaction::toObject($row);
        }
        return $transactions;
    }

    public function selectBy(array $filter): array
    {
        $conditions = [];
        $params = [];
        
        foreach ($filter as $key => $value) {
            $conditions[] = "$key = :$key";
            $params[$key] = $value;
        }
        
        $sql = "SELECT * FROM {$this->table}";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $sql .= " ORDER BY date_creation DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        $transactions = [];
        while ($row = $stmt->fetch()) {
            $transactions[] = Transaction::toObject($row);
        }
        return $transactions;
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $row = $stmt->fetch();
        return $row ? Transaction::toObject($row) : null;
    }

    public function createDepot(int $compte_id, float $montant, ?string $description = null): ?int
    {
        return $this->insert([
            'compte_expediteur_id' => $compte_id,
            'montant' => $montant,
            'type' => 'depot',
            'statut' => 'complete',
            'description' => $description
        ]);
    }

    public function createTransfert(int $compte_expediteur_id, int $compte_destinataire_id, float $montant, ?string $description = null): ?int
    {
        return $this->insert([
            'compte_expediteur_id' => $compte_expediteur_id,
            'compte_destinataire_id' => $compte_destinataire_id,
            'montant' => $montant,
            'type' => 'transfert',
            'statut' => 'en_attente',
            'description' => $description
        ]);
    }

    public function completerTransaction(int $id): bool
    {
        return $this->update($id, [
            'statut' => 'complete',
            'date_completion' => date('Y-m-d H:i:s')
        ]);
    }

    public function annulerTransaction(int $id): bool
    {
        return $this->update($id, [
            'statut' => 'annule',
            'date_completion' => date('Y-m-d H:i:s')
        ]);
    }
}