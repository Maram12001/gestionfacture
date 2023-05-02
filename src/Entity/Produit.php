<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $designation = null;

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    #[ORM\Column]
    private ?float $tva = null;

    #[ORM\OneToMany(mappedBy: 'Produit', targetEntity: LigneProduitClient::class)]
    private Collection $ligneProduitClients;

    public function __construct()
    {
        $this->ligneProduitClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

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

    /**
     * @return Collection<int, LigneProduitClient>
     */
    public function getLigneProduitClients(): Collection
    {
        return $this->ligneProduitClients;
    }

    public function addLigneProduitClient(LigneProduitClient $ligneProduitClient): self
    {
        if (!$this->ligneProduitClients->contains($ligneProduitClient)) {
            $this->ligneProduitClients->add($ligneProduitClient);
            $ligneProduitClient->setProduit($this);
        }

        return $this;
    }

    public function removeLigneProduitClient(LigneProduitClient $ligneProduitClient): self
    {
        if ($this->ligneProduitClients->removeElement($ligneProduitClient)) {
            // set the owning side to null (unless already changed)
            if ($ligneProduitClient->getProduit() === $this) {
                $ligneProduitClient->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return float|null
     */
    public function getTva(): ?float
    {
        return $this->tva;
    }

    /**
     * @param float|null $tva
     */
    public function setTva(?float $tva): void
    {
        $this->tva = $tva;
    }

    public function __toString(): string
    {
        return $this->designation;
    }

}

