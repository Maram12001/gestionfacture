<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
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

    #[ORM\OneToMany(mappedBy: 'Client', targetEntity: FactureClient::class)]
    private Collection $factureClients;

    public function __construct()
    {
        $this->factureClients = new ArrayCollection();
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
     * @return Collection<int, FactureClient>
     */
    public function getFactureClients(): Collection
    {
        return $this->factureClients;
    }

    public function addFactureClient(FactureClient $factureClient): self
    {
        if (!$this->factureClients->contains($factureClient)) {
            $this->factureClients->add($factureClient);
            $factureClient->setClient($this);
        }

        return $this;
    }

    public function removeFactureClient(FactureClient $factureClient): self
    {
        if ($this->factureClients->removeElement($factureClient)) {
            // set the owning side to null (unless already changed)
            if ($factureClient->getClient() === $this) {
                $factureClient->setClient(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->raisonSociale;
    }
}
