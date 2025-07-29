<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;

class Transaction extends AbstractEntity
{
    private ?int $id = null;
    private ?int $user_id = null;
    private ?int $compte_id = null;
    private float $montant;
    private string $typetransaction; // 'Depot', 'Retrait', 'Transfert'
    private string $date;

    public function __construct(
        float $montant = 0.0,
        string $typetransaction = 'Depot',
        ?int $user_id = null,
        ?int $compte_id = null
    ) {
        $this->montant = $montant;
        $this->typetransaction = $typetransaction;
        $this->user_id = $user_id;
        $this->compte_id = $compte_id;
        $this->date = date('Y-m-d H:i:s');
    }

    public static function toObject(array $data): static
    {
        $transaction = new self(
            $data['montant'] ?? 0.0,
            $data['typetransaction'] ?? 'Depot',
            $data['user_id'] ?? null,
            $data['compte_id'] ?? null
        );
        
        if (isset($data['id'])) {
            $transaction->id = $data['id'];
        }
        if (isset($data['date'])) {
            $transaction->date = $data['date'];
        }
        
        return $transaction;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'compte_id' => $this->compte_id,
            'montant' => $this->montant,
            'typetransaction' => $this->typetransaction,
            'date' => $this->date
        ];
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getUserId(): ?int { return $this->user_id; }
    public function getCompteId(): ?int { return $this->compte_id; }
    public function getMontant(): float { return $this->montant; }
    public function getTypetransaction(): string { return $this->typetransaction; }
    public function getDate(): string { return $this->date; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setUserId(?int $user_id): void { $this->user_id = $user_id; }
    public function setCompteId(?int $compte_id): void { $this->compte_id = $compte_id; }
    public function setMontant(float $montant): void { $this->montant = $montant; }
    public function setTypetransaction(string $typetransaction): void { $this->typetransaction = $typetransaction; }
    public function setDate(string $date): void { $this->date = $date; }

    // Méthodes d'aide pour compatibilité
    public function getType(): string { return $this->typetransaction; }
}
