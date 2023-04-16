<?php

namespace App\Entity;

use App\Repository\FactureFournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureFournisseurRepository::class)]
class FactureFournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEchaence = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEmission = null;

    #[ORM\Column]
    private ?bool $etatComptable = null;

    #[ORM\ManyToOne(inversedBy: 'factureFournisseurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    #[ORM\OneToMany(mappedBy: 'FactureFournisseur', targetEntity: Workflowpaiement::class)]
    private Collection $workflowpaiements;

    #[ORM\OneToMany(mappedBy: 'FactureFournisseur', targetEntity: WorkflowPaiements::class)]
    private Collection $workflowPaiements;

    public function __construct()
    {
        $this->workflowpaiements = new ArrayCollection();
        $this->workflowPaiements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEchaence(): ?\DateTimeInterface
    {
        return $this->dateEchaence;
    }

    public function setDateEchaence(\DateTimeInterface $dateEchaence): self
    {
        $this->dateEchaence = $dateEchaence;

        return $this;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->dateEmission;
    }

    public function setDateEmission(\DateTimeInterface $dateEmission): self
    {
        $this->dateEmission = $dateEmission;

        return $this;
    }

    public function isEtatComptable(): ?bool
    {
        return $this->etatComptable;
    }

    public function setEtatComptable(bool $etatComptable): self
    {
        $this->etatComptable = $etatComptable;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * @return Collection<int, Workflowpaiement>
     */
    public function getWorkflowpaiements(): Collection
    {
        return $this->workflowpaiements;
    }

    public function addWorkflowpaiement(Workflowpaiement $workflowpaiement): self
    {
        if (!$this->workflowpaiements->contains($workflowpaiement)) {
            $this->workflowpaiements->add($workflowpaiement);
            $workflowpaiement->setFactureFournisseur($this);
        }

        return $this;
    }

    public function removeWorkflowpaiement(Workflowpaiement $workflowpaiement): self
    {
        if ($this->workflowpaiements->removeElement($workflowpaiement)) {
            // set the owning side to null (unless already changed)
            if ($workflowpaiement->getFactureFournisseur() === $this) {
                $workflowpaiement->setFactureFournisseur(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return (string) $this->id;
    }
}
