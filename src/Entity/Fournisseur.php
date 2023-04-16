<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $raisonSociale = null;

    #[ORM\Column]
    private ?int $matriculeFiscale = null;

    #[ORM\Column]
    private ?int $fax = null;

    #[ORM\Column(length: 50)]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'Fournisseur', targetEntity: FactureFournisseur::class)]
    private Collection $factureFournisseurs;

    public function __construct()
    {
        $this->factureFournisseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getMatriculeFiscale(): ?int
    {
        return $this->matriculeFiscale;
    }

    public function setMatriculeFiscale(int $matriculeFiscale): self
    {
        $this->matriculeFiscale = $matriculeFiscale;

        return $this;
    }

    public function getFax(): ?int
    {
        return $this->fax;
    }

    public function setFax(int $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, FactureFournisseur>
     */
    public function getFactureFournisseurs(): Collection
    {
        return $this->factureFournisseurs;
    }

    public function addFactureFournisseur(FactureFournisseur $factureFournisseur): self
    {
        if (!$this->factureFournisseurs->contains($factureFournisseur)) {
            $this->factureFournisseurs->add($factureFournisseur);
            $factureFournisseur->setFournisseur($this);
        }

        return $this;
    }

    public function removeFactureFournisseur(FactureFournisseur $factureFournisseur): self
    {
        if ($this->factureFournisseurs->removeElement($factureFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($factureFournisseur->getFournisseur() === $this) {
                $factureFournisseur->setFournisseur(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->raisonSociale;
    }
}
