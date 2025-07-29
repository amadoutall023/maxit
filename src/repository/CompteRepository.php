<?php

namespace App\Repository;

use App\Core\Abstract\AbstractRepository;
use App\Entity\Compte;

class CompteRepository extends AbstractRepository
{
    private string $table = '"Compte"';

    public function __construct()
    {
        parent::__construct();
    }

    public function selectAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $comptes = [];
        while ($row = $stmt->fetch()) {
            $comptes[] = Compte::toObject($row);
        }
        return $comptes;
    }

    public function insert(array $data)
    {
        $sql = "INSERT INTO {$this->table} (user_id, numero, typecompte, solde) 
                VALUES (:user_id, :numero, :typeCompte, :solde)";
        
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            'user_id' => $data['user_id'],
            'numero' => $data['numero'],
            'typeCompte' => $data['typeCompte'] ?? 'ComptePrincipal',
            'solde' => $data['solde'] ?? 0.0
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

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $row = $stmt->fetch();
        return $row ? Compte::toObject($row) : null;
    }

    public function selectByClient(int $id_user): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :id_user ORDER BY datecreation DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_user' => $id_user]);
        
        $comptes = [];
        while ($row = $stmt->fetch()) {
            $comptes[] = Compte::toObject($row);
        }
        return $comptes;
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
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        
        $comptes = [];
        while ($row = $stmt->fetch()) {
            $comptes[] = Compte::toObject($row);
        }
        return $comptes;
    }

    public function findPrincipalByUserId(int $userId): ?Compte
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND typecompte = 'ComptePrincipal' LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        
        $row = $stmt->fetch();
        return $row ? Compte::toObject($row) : null;
    }

    public function findByNumeroCompte(string $numeroCompte): ?Compte
    {
        $sql = "SELECT * FROM {$this->table} WHERE numero = :numero";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numero' => $numeroCompte]);
        
        $row = $stmt->fetch();
        return $row ? Compte::toObject($row) : null;
    }

    public function updateSolde(int $id, float $nouveauSolde): bool
    {
        return $this->update($id, ['solde' => $nouveauSolde]);
    }

    public function genererNumeroCompte(): string
    {
        do {
            $numero = 'CMP' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            $existant = $this->findByNumeroCompte($numero);
        } while ($existant !== null);
        
        return $numero;
    }
}