<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomService = null;

    #[ORM\OneToMany(mappedBy: 'Service', targetEntity: WorkflowPaiements::class)]
    private Collection $workflowPaiements;

    public function __construct()
    {
        $this->workflowPaiements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomService(): ?string
    {
        return $this->nomService;
    }

    public function setNomService(string $nomService): self
    {
        $this->nomService = $nomService;

        return $this;
    }

    /**
     * @return Collection<int, WorkflowPaiements>
     */
    public function getWorkflowPaiements(): Collection
    {
        return $this->workflowPaiements;
    }

    public function addWorkflowPaiement(WorkflowPaiements $workflowPaiement): self
    {
        if (!$this->workflowPaiements->contains($workflowPaiement)) {
            $this->workflowPaiements->add($workflowPaiement);
            $workflowPaiement->setService($this);
        }

        return $this;
    }

    public function removeWorkflowPaiement(WorkflowPaiements $workflowPaiement): self
    {
        if ($this->workflowPaiements->removeElement($workflowPaiement)) {
            // set the owning side to null (unless already changed)
            if ($workflowPaiement->getService() === $this) {
                $workflowPaiement->setService(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomService;
    }
}
