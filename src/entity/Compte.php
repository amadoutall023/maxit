<?php

namespace App\Entity;

use App\Core\Abstract\AbstractEntity;

class Compte extends AbstractEntity
{
    private ?int $id = null;
    private int $user_id;
    private string $numero;
    private float $solde;
    private string $type_compte; // 'courant', 'epargne'
    private string $statut; // 'actif', 'suspendu', 'ferme'
    private string $date_creation;
    private ?string $date_fermeture = null;

    public function __construct(
        int $user_id,
        string $numero,
        float $solde = 0.0,
        string $type_compte = 'courant',
        string $statut = 'actif'
    ) {
        $this->user_id = $user_id;
        $this->numero = $numero;
        $this->solde = $solde;
        $this->type_compte = $type_compte;
        $this->statut = $statut;
        $this->date_creation = date('Y-m-d H:i:s');
    }

    public static function toObject(array $data): static
    {
        $compte = new self(
            $data['user_id'],
            $data['numero'],
            $data['solde'] ?? 0.0,
            $data['type_compte'] ?? 'courant',
            $data['statut'] ?? 'actif'
        );
        
        if (isset($data['id'])) {
            $compte->id = $data['id'];
        }
        if (isset($data['date_creation'])) {
            $compte->date_creation = $data['date_creation'];
        }
        if (isset($data['date_fermeture'])) {
            $compte->date_fermeture = $data['date_fermeture'];
        }
        
        return $compte;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'numero' => $this->numero,
            'solde' => $this->solde,
            'type_compte' => $this->type_compte,
            'statut' => $this->statut,
            'date_creation' => $this->date_creation,
            'date_fermeture' => $this->date_fermeture
        ];
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->user_id; }
    public function getNumeroCompte(): string { return $this->numero_compte; }
    public function getSolde(): float { return $this->solde; }
    public function getTypeCompte(): string { return $this->type_compte; }
    public function getStatut(): string { return $this->statut; }
    public function getDateCreation(): string { return $this->date_creation; }
    public function getDateFermeture(): ?string { return $this->date_fermeture; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setSolde(float $solde): void { $this->solde = $solde; }
    public function setStatut(string $statut): void { $this->statut = $statut; }
    public function setDateFermeture(string $date): void { $this->date_fermeture = $date; }

    // Méthodes métier
    public function crediter(float $montant): void
    {
        if ($montant <= 0) {
            throw new \InvalidArgumentException('Le montant doit être positif');
        }
        $this->solde += $montant;
    }

    public function debiter(float $montant): void
    {
        if ($montant <= 0) {
            throw new \InvalidArgumentException('Le montant doit être positif');
        }
        if ($this->solde < $montant) {
            throw new \Exception('Solde insuffisant');
        }
        $this->solde -= $montant;
    }

    public function peutDebiter(float $montant): bool
    {
        return $this->solde >= $montant && $this->statut === 'actif';
    }
}
