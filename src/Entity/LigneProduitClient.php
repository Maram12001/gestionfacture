<?php

namespace App\Entity;

use App\Repository\LigneProduitClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneProduitClientRepository::class)]
class LigneProduitClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneProduitClients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'ligneProduitClients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FactureClient $factureClient = null;

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    #[ORM\Column]
    private ?float $remise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getFactureClient(): ?FactureClient
    {
        return $this->factureClient;
    }

    public function setFactureClient(?FactureClient $factureClient): self
    {
        $this->factureClient = $factureClient;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(float $remise): self
    {
        $this->remise = $remise;

        return $this;
    }
    public function __toString(): string
    {
        return $this->produit.' ('.$this->id.')';
    }
}
