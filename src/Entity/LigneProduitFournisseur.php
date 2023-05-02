<?php

namespace App\Entity;

use App\Repository\LigneProduitFournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneProduitFournisseurRepository::class)]
class LigneProduitFournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ligneProduitFournisseurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'ligneProduitFournisseurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FactureFournisseur $factureFournisseur = null;

    #[ORM\Column]
    private ?float $quantity = null;

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


    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

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

    /**
     * @return FactureFournisseur|null
     */
    public function getFactureFournisseur(): ?FactureFournisseur
    {
        return $this->factureFournisseur;
    }

    /**
     * @param FactureFournisseur|null $factureFournisseur
     */
    public function setFactureFournisseur(?FactureFournisseur $factureFournisseur): void
    {
        $this->factureFournisseur = $factureFournisseur;
    }

}
