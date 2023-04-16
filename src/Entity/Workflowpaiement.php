<?php

namespace App\Entity;

use App\Repository\WorkflowpaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkflowpaiementRepository::class)]
class Workflowpaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'workflowpaiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FactureFournisseur $FactureFournisseur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEmission = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactureFournisseur(): ?FactureFournisseur
    {
        return $this->FactureFournisseur;
    }

    public function setFactureFournisseur(?FactureFournisseur $FactureFournisseur): self
    {
        $this->FactureFournisseur = $FactureFournisseur;

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
}
